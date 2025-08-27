-- Compliance Checking SaaS Database Schema
-- Copy and paste this entire file into phpMyAdmin SQL tab

CREATE DATABASE IF NOT EXISTS compliance_saas;
USE compliance_saas;

-- Drop existing tables if they exist (for clean setup)
DROP TABLE IF EXISTS api_keys;
DROP TABLE IF EXISTS activity_logs;
DROP TABLE IF EXISTS reports;
DROP TABLE IF EXISTS folder_structures;
DROP TABLE IF EXISTS compliance_checks;
DROP TABLE IF EXISTS compliance_rules;
DROP TABLE IF EXISTS documents;
DROP TABLE IF EXISTS subscriptions;
DROP TABLE IF EXISTS users;
DROP TABLE IF EXISTS organizations;

-- Organizations table
CREATE TABLE organizations (
    id INT PRIMARY KEY AUTO_INCREMENT,
    name VARCHAR(255) NOT NULL,
    domain VARCHAR(100) UNIQUE,
    subscription_tier ENUM('essential', 'professional', 'enterprise') DEFAULT 'essential',
    subscription_status ENUM('active', 'inactive', 'cancelled', 'trial') DEFAULT 'trial',
    stripe_customer_id VARCHAR(100),
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);

-- Users table
CREATE TABLE users (
    id INT PRIMARY KEY AUTO_INCREMENT,
    organization_id INT,
    email VARCHAR(255) UNIQUE NOT NULL,
    password_hash VARCHAR(255) NOT NULL,
    first_name VARCHAR(100),
    last_name VARCHAR(100),
    role ENUM('system_admin', 'org_admin', 'compliance_manager', 'analyst', 'end_user') DEFAULT 'end_user',
    status ENUM('active', 'inactive', 'pending') DEFAULT 'pending',
    email_verified BOOLEAN DEFAULT FALSE,
    verification_token VARCHAR(100),
    reset_token VARCHAR(100),
    reset_expires TIMESTAMP NULL,
    last_login TIMESTAMP NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (organization_id) REFERENCES organizations(id) ON DELETE SET NULL
);

-- Subscriptions table
CREATE TABLE subscriptions (
    id INT PRIMARY KEY AUTO_INCREMENT,
    organization_id INT NOT NULL,
    stripe_subscription_id VARCHAR(100) UNIQUE,
    tier ENUM('essential', 'professional', 'enterprise') NOT NULL,
    status ENUM('active', 'inactive', 'cancelled', 'past_due') DEFAULT 'active',
    current_period_start TIMESTAMP,
    current_period_end TIMESTAMP,
    monthly_document_count INT DEFAULT 0,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (organization_id) REFERENCES organizations(id) ON DELETE CASCADE
);

-- Documents table
CREATE TABLE documents (
    id INT PRIMARY KEY AUTO_INCREMENT,
    user_id INT NOT NULL,
    organization_id INT NOT NULL,
    filename VARCHAR(255) NOT NULL,
    original_filename VARCHAR(255) NOT NULL,
    file_path VARCHAR(500) NOT NULL,
    file_size BIGINT NOT NULL,
    file_type VARCHAR(50) NOT NULL,
    mime_type VARCHAR(100),
    checksum VARCHAR(64),
    upload_date TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    status ENUM('uploaded', 'processing', 'completed', 'failed') DEFAULT 'uploaded',
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE,
    FOREIGN KEY (organization_id) REFERENCES organizations(id) ON DELETE CASCADE
);

-- Compliance rules table
CREATE TABLE compliance_rules (
    id INT PRIMARY KEY AUTO_INCREMENT,
    organization_id INT NOT NULL,
    name VARCHAR(255) NOT NULL,
    description TEXT,
    rule_type ENUM('filename', 'folder_structure', 'content', 'metadata', 'iso_standard') NOT NULL,
    rule_data JSON NOT NULL,
    is_active BOOLEAN DEFAULT TRUE,
    created_by INT NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (organization_id) REFERENCES organizations(id) ON DELETE CASCADE,
    FOREIGN KEY (created_by) REFERENCES users(id) ON DELETE CASCADE
);

-- Compliance checks table
CREATE TABLE compliance_checks (
    id INT PRIMARY KEY AUTO_INCREMENT,
    document_id INT NOT NULL,
    rule_id INT NOT NULL,
    status ENUM('passed', 'failed', 'warning') NOT NULL,
    details TEXT,
    checked_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (document_id) REFERENCES documents(id) ON DELETE CASCADE,
    FOREIGN KEY (rule_id) REFERENCES compliance_rules(id) ON DELETE CASCADE
);

-- Folder structures table
CREATE TABLE folder_structures (
    id INT PRIMARY KEY AUTO_INCREMENT,
    organization_id INT NOT NULL,
    user_id INT NOT NULL,
    folder_path VARCHAR(1000) NOT NULL,
    scan_date TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    total_files INT DEFAULT 0,
    compliant_files INT DEFAULT 0,
    non_compliant_files INT DEFAULT 0,
    FOREIGN KEY (organization_id) REFERENCES organizations(id) ON DELETE CASCADE,
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE
);

-- Reports table
CREATE TABLE reports (
    id INT PRIMARY KEY AUTO_INCREMENT,
    organization_id INT NOT NULL,
    user_id INT NOT NULL,
    report_type ENUM('compliance_summary', 'detailed_analysis', 'folder_scan', 'custom') NOT NULL,
    title VARCHAR(255) NOT NULL,
    parameters JSON,
    file_path VARCHAR(500),
    status ENUM('generating', 'completed', 'failed') DEFAULT 'generating',
    generated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (organization_id) REFERENCES organizations(id) ON DELETE CASCADE,
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE
);

-- Activity logs table
CREATE TABLE activity_logs (
    id INT PRIMARY KEY AUTO_INCREMENT,
    user_id INT,
    organization_id INT,
    action VARCHAR(100) NOT NULL,
    details TEXT,
    ip_address VARCHAR(45),
    user_agent TEXT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE SET NULL,
    FOREIGN KEY (organization_id) REFERENCES organizations(id) ON DELETE SET NULL
);

-- API keys table
CREATE TABLE api_keys (
    id INT PRIMARY KEY AUTO_INCREMENT,
    organization_id INT NOT NULL,
    user_id INT NOT NULL,
    key_hash VARCHAR(255) NOT NULL,
    name VARCHAR(100) NOT NULL,
    permissions JSON,
    last_used TIMESTAMP NULL,
    expires_at TIMESTAMP NULL,
    is_active BOOLEAN DEFAULT TRUE,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (organization_id) REFERENCES organizations(id) ON DELETE CASCADE,
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE
);

-- Create indexes for better performance
CREATE INDEX idx_users_email ON users(email);
CREATE INDEX idx_users_organization ON users(organization_id);
CREATE INDEX idx_documents_user ON documents(user_id);
CREATE INDEX idx_documents_organization ON documents(organization_id);
CREATE INDEX idx_compliance_checks_document ON compliance_checks(document_id);
CREATE INDEX idx_compliance_checks_rule ON compliance_checks(rule_id);
CREATE INDEX idx_activity_logs_user ON activity_logs(user_id);
CREATE INDEX idx_activity_logs_date ON activity_logs(created_at);

-- Insert sample organizations
INSERT INTO organizations (name, domain, subscription_tier, subscription_status) VALUES 
('System Administration', 'system.local', 'enterprise', 'active'),
('Acme Corporation', 'acme.com', 'enterprise', 'active'),
('Tech Solutions Inc', 'techsolutions.com', 'professional', 'active'),
('Small Business LLC', 'smallbiz.com', 'essential', 'trial'),
('Global Industries', 'global.com', 'enterprise', 'active');

-- Insert sample users (password for all is "password")
INSERT INTO users (organization_id, email, password_hash, first_name, last_name, role, status, email_verified) VALUES 
(1, 'admin@system.local', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'System', 'Admin', 'system_admin', 'active', TRUE),
(2, 'john@acme.com', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'John', 'Smith', 'org_admin', 'active', TRUE),
(3, 'sarah@techsolutions.com', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'Sarah', 'Johnson', 'compliance_manager', 'active', TRUE),
(4, 'mike@smallbiz.com', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'Mike', 'Williams', 'end_user', 'active', TRUE),
(5, 'admin@global.com', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'Global', 'Admin', 'org_admin', 'active', TRUE);

-- Insert sample subscriptions
INSERT INTO subscriptions (organization_id, tier, status, monthly_document_count) VALUES
(1, 'enterprise', 'active', 0),
(2, 'enterprise', 'active', 247),
(3, 'professional', 'active', 84),
(4, 'essential', 'active', 23),
(5, 'enterprise', 'active', 456);

-- Insert sample documents
INSERT INTO documents (user_id, organization_id, filename, original_filename, file_path, file_size, file_type, status) VALUES
(2, 2, 'doc_001.pdf', 'Company_Policy_2024.pdf', '/uploads/doc_001.pdf', 2048576, 'pdf', 'completed'),
(2, 2, 'doc_002.docx', 'Procedure_Manual.docx', '/uploads/doc_002.docx', 1536000, 'docx', 'completed'),
(3, 3, 'doc_003.pdf', 'ISO_Compliance_Report.pdf', '/uploads/doc_003.pdf', 3072000, 'pdf', 'processing'),
(4, 4, 'doc_004.txt', 'meeting_notes.txt', '/uploads/doc_004.txt', 12000, 'txt', 'completed'),
(5, 5, 'doc_005.xml', 'data_export.xml', '/uploads/doc_005.xml', 256000, 'xml', 'completed');

-- Insert sample compliance rules
INSERT INTO compliance_rules (organization_id, name, description, rule_type, rule_data, created_by) VALUES
(1, 'PDF Format Validation', 'Validates that PDF files meet basic format requirements', 'content', '{"format": "pdf", "min_version": "1.4"}', 1),
(1, 'Document Naming Convention', 'Standard document naming pattern validation', 'filename', '{"pattern": "^[A-Z]{2,3}-\\\\d{4}-\\\\d{2}-\\\\d{2}.*\\\\.(pdf|docx)$", "description": "Format: ABC-2024-01-01-description.pdf"}', 1),
(1, 'Folder Structure Standard', 'Validates standard folder organization', 'folder_structure', '{"required_folders": ["Documents", "Reports", "Archive"], "max_depth": 3}', 1),
(2, 'Acme Naming Standard', 'Company-specific document naming', 'filename', '{"pattern": "^ACME_\\\\d{4}_.*\\\\.(pdf|docx)$"}', 2),
(3, 'Tech Solutions ISO Standard', 'ISO 27001 compliance checking', 'iso_standard', '{"standard": "ISO27001", "version": "2022"}', 3);

-- Insert sample compliance checks
INSERT INTO compliance_checks (document_id, rule_id, status, details) VALUES
(1, 1, 'passed', 'PDF format validation successful'),
(1, 4, 'failed', 'Document naming does not follow ACME standard'),
(2, 1, 'warning', 'PDF version is older than recommended'),
(3, 5, 'passed', 'ISO 27001 compliance requirements met'),
(4, 2, 'failed', 'Filename does not match required pattern'),
(5, 1, 'passed', 'XML format validation successful');

-- Insert sample activity logs
INSERT INTO activity_logs (user_id, organization_id, action, details) VALUES
(2, 2, 'login', 'User logged in successfully'),
(2, 2, 'document_upload', 'Uploaded Company_Policy_2024.pdf'),
(3, 3, 'compliance_check', 'Ran compliance check on 5 documents'),
(4, 4, 'subscription_upgrade', 'Upgraded from Essential to Professional'),
(5, 5, 'report_generated', 'Generated monthly compliance report'),
(1, 1, 'system_maintenance', 'System backup completed successfully');

-- Success message
SELECT 'Database setup completed successfully! You can now login with admin@system.local / password' AS Status;