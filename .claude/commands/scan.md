# Scan Command

Quét và kiểm tra tính hợp lệ của dự án WordPress: $ARGUMENTS

## Scan Types

### Validation Scans
```bash
/scan --validate                # Check build process & assets
/scan --validate --assets       # Validate asset paths and loading
/scan --validate --build        # Check build configuration
```

### Security Scans
```bash
/scan --security                # Security vulnerability scan
/scan --permissions             # File permissions check
/scan --sanitization            # Input/output sanitization check
```

### Performance Scans
```bash
/scan --performance             # Performance bottleneck scan
/scan --assets --performance    # Asset loading performance
/scan --database                # Database query performance
```

### Compliance Scans
```bash
/scan --standards               # WordPress coding standards
/scan --accessibility           # WCAG accessibility compliance
/scan --seo                     # SEO best practices
```

## Scan Areas

1. **Build Process Validation**
   - Asset compilation success
   - File path correctness
   - Dependency resolution
   - Output file integrity

2. **Asset Validation**
   - CSS/JS file loading
   - Image optimization
   - Font loading
   - CDN configuration

3. **WordPress Compliance**
   - Theme standards compliance
   - Plugin compatibility
   - Hook usage validation
   - Template hierarchy

4. **Security Checks**
   - Input validation
   - Output escaping
   - SQL injection vulnerabilities
   - XSS prevention

5. **Performance Metrics**
   - Page load times
   - Asset sizes
   - Database query efficiency
   - Caching effectiveness

## Scan Results
- **Pass/Fail Status**: Clear validation results
- **Issue Details**: Specific problems found
- **Recommendations**: How to fix issues
- **Priority Levels**: Critical, High, Medium, Low

## Usage Examples
```bash
/scan --validate                           # Full validation scan
/scan --validate --assets                  # Asset-specific validation
/scan --security                           # Security vulnerability scan
/scan --performance                        # Performance bottleneck scan
/scan --standards "wp-content/themes"      # Standards compliance for theme
```

## Integration with Build Process
- Run after `npm run build`
- Validate asset paths match
- Check for hashed filename issues
- Verify Vite/WordPress integration
