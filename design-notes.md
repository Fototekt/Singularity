# Design Notes - Bootstrap 5 Admin Dashboard Template

## Overview
This project uses a comprehensive Bootstrap 5 admin dashboard template located in the `/design` folder. The template provides a complete UI framework with modern design patterns, responsive layouts, and extensive component library.

## Template Structure

### Core Files Organization
- **HTML Pages**: 68 template files covering all major UI patterns
- **CSS**: Bootstrap 5 SCSS source files with custom styling
- **JavaScript**: Modern libraries for charts, tables, calendars, and more
- **Assets**: Icons, images, fonts, and vendor libraries

## Key Design Patterns

### 1. Page Layout Structure
```html
<div class="page-wrapper">
    <nav class="sidebar-wrapper"><!-- Collapsible sidebar navigation --></nav>
    <div class="main-container">
        <div class="page-header"><!-- Header with breadcrumbs --></div>
        <div class="content-wrapper-scroll">
            <div class="content-wrapper">
                <!-- Main content area -->
            </div>
        </div>
        <div class="app-footer"><!-- Footer content --></div>
    </div>
</div>
```

### 2. Color System
The template uses a shade-based color system:
- Primary shades: `shade-red`, `shade-blue`, `shade-green`, `shade-yellow`
- Text colors: `text-red`, `text-blue`, `text-green`
- Background variants for cards and sections

### 3. Component Library

#### Forms
- Consistent form groups with `.mb-3` spacing
- Label styling with `.form-label`
- Input controls: `.form-control`, `.form-select`
- Multiple layout patterns (horizontal, vertical, inline)

#### Cards
- Standard card structure: `.card`, `.card-header`, `.card-body`
- Headers with `.d-flex` for title and actions
- Consistent padding and margin patterns

#### Tables
- Responsive wrapper: `.table-responsive`
- Vertical alignment: `.v-middle`
- Styled with borders and hover states

#### Navigation
- Collapsible sidebar with icon-based menu
- Dropdown menus with proper ARIA attributes
- Breadcrumb navigation in page headers
- Active state tracking with `.active` and `.current-page`

### 4. Responsive Design
- Mobile-first approach using Bootstrap's grid system
- Breakpoint utilities: `d-none`, `d-lg-block`, `d-xl-flex`
- Collapsible elements for mobile views
- Responsive tables and card layouts

## JavaScript Integration

### Core Libraries
1. **Bootstrap 5**: Full framework with components
2. **jQuery**: DOM manipulation and events
3. **Moment.js**: Date/time handling
4. **Modernizr**: Feature detection

### Vendor Libraries
- **ApexCharts**: Modern charting library
- **DataTables**: Advanced table features
- **FullCalendar**: Event calendar
- **Summernote**: WYSIWYG editor
- **Dropzone**: File uploads
- **Bootstrap Select**: Enhanced dropdowns
- **OverlayScrollbars**: Custom scrollbars

## CSS Architecture

### File Structure
- `main.scss`: Primary stylesheet with all imports
- `variables.scss`: Theme customization variables
- Bootstrap source files in `/bootstrap` folder
- Component-specific SCSS modules

### Utility Classes
- Spacing: Bootstrap spacing utilities (m-*, p-*)
- Text: `.text-truncate`, `.text-muted`, `.text-uppercase`
- Display: `.d-flex`, `.justify-content-between`, `.align-items-center`
- Custom: `.scroll370`, `.auto-align-graph`

## Best Practices for Implementation

1. **Maintain Consistency**
   - Use existing color variables and classes
   - Follow established spacing patterns
   - Reuse component structures from templates

2. **Responsive First**
   - Test all layouts on mobile breakpoints
   - Use Bootstrap's responsive utilities
   - Ensure touch-friendly interfaces

3. **Component Reuse**
   - Reference existing HTML templates for patterns
   - Use consistent class naming conventions
   - Leverage vendor libraries already included

4. **Performance Considerations**
   - Use minified CSS/JS versions in production
   - Lazy load heavy components (charts, editors)
   - Optimize images and assets

## Key Templates Reference

### Authentication
- `login.html` - Login page pattern
- `signup.html` - Registration form
- `forgot-password.html` - Password recovery

### Dashboards
- `index.html` - Main dashboard with widgets
- `graph-widgets.html` - Chart examples
- `widgets.html` - UI component showcase

### Forms
- `form-layout1.html` to `form-layout4.html` - Various form layouts
- `form-validations.html` - Validation patterns
- `form-inputs.html` - Input component examples

### E-commerce
- `products.html` - Product listing
- `checkout.html` - Multi-step checkout
- `orders.html` - Order management

### Data Display
- `data-tables.html` - Table patterns
- `apex.html` - Chart examples
- `calendar.html` - Event calendar

## Implementation Guidelines

1. **Start with a base template** (e.g., `starter-page.html`) and modify as needed
2. **Preserve the sidebar and header structure** for consistency
3. **Use card components** for content sections
4. **Follow the established grid system** for responsive layouts
5. **Reference specific template files** for complex components
6. **Maintain the loading wrapper** for async operations
7. **Use Bootstrap Icons** for consistent iconography

This design system provides a solid foundation for building a professional, responsive admin interface with minimal custom CSS required.