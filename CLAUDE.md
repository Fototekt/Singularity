# CLAUDE.md

This file provides guidance to Claude Code (claude.ai/code) when working with code in this repository.

## Project Overview - Compliance Checking SaaS

This is a web-hosted and locally-hosted SaaS product that reviews client practices and provides directory compliance checking. The system checks:
- Document folder structure and file naming conventions
- File format requirements for PDFs, DOCs, XMLs, etc.
- ISO compliance standards
- Code compliance standards
- Custom compliance rules based on client practices

**Target Audience**: Corporations with audit requirements for shareholder clarity

## Subscription Tiers

The application includes a 3-tier subscription system:

### Essential - $9.99/month
- Basic compliance checking
- Up to 100 documents/month
- Standard file formats (PDF, DOC, DOCX)
- Basic reporting
- Email support

### Professional - $19.99/month
- Advanced compliance checking
- Up to 1,000 documents/month
- Extended file formats (XML, CSV, TXT, images)
- Custom compliance rules (5 rules)
- Advanced analytics & dashboards
- Priority email support
- API access

### Enterprise - $199.99/month
- Unlimited compliance checking
- Unlimited documents
- All file formats supported
- Unlimited custom compliance rules
- AI-powered compliance suggestions
- White-label options
- Dedicated account manager
- Phone & email support
- On-premises deployment option
- Integration support

## Repository Structure

1. **Initial Analysis and Planning**
   First think through the problem, read the codebase for relevant files, and write a plan to tasks/todo.md.

2. **Design Inspiration**
   The folder design is a bootstrap5 template that I want to use as the design inspiration of the applications. Please do not make any changes to any file in this folder or subfolders.

3. **Todo List Structure**
   The plan should have a list of todo items that you can check off as you complete them.

4. **Plan Verification**
   Before you begin working, check in with me and I will verify the plan.

5. **Task Execution**
   Then, begin working on the todo items, marking them as complete as you go.

6. **Communication**
   Please every step of the way just give me a high level explanation of what changes you made.

7. **Simplicity Principle**
   Make every task and code change you do as simple as possible. We want to avoid making any massive or complex changes. Every change should impact as little code as possible. Everything is about simplicity.

8. **Process Documentation**
   Every time you perform actions related to the project, append your actions to docs/activity.md and read that file whenever you find it necessary to assist you. Please include every prompt I give.

9. **Git Repository**
   Every time you make successful changes please push the changes to the current git repository.

10. **HTML Folder**
    The html folder is the html home directory of the web server. It is a traditional LAMP stack. All files that need to be deployed must be in that folder or a sub-folder.

11. **Review Process**
    Finally, add a review section to the todo.md file with a summary of the changes you made and any other relevant information.

## Development Guidelines

### User Roles (3-5 types)
- **System Administrator**: Full system access and configuration
- **Organization Admin**: Manage organization settings and users
- **Compliance Manager**: Create and manage compliance rules
- **Analyst**: Run compliance checks and view reports
- **End User**: Basic compliance checking only

### Technology Integration
- Traditional Tech Stack with AI Components
- AI Desktop Tools integration (Claude Desktop compatible)
- MCP Tools/Servers for document processing
- AI Agents for automated compliance analysis

### Deployment Targets
- Hybrid (cloud + on-premises)
- Public Internet access
- Corporate network deployment
- Multi-device support (desktop/laptop/tablet/phone)