# Release and Deployment

Complete guide for preparing TailPress themes for production deployment.

## Release Overview

When your theme is ready for production use, TailPress provides several methods to create optimized, deployment-ready theme packages.

## Release Methods

### 1. GitHub Workflow (Recommended)

TailPress includes a pre-configured GitHub Actions workflow for automated releases.

#### Workflow Features

The workflow located at `.github/workflows/release.yml` automatically:

- Installs and optimizes Composer dependencies
- Compiles assets for production
- Creates a ZIP file of your theme
- Attaches the ZIP as a release asset

#### Using GitHub Workflow

1. **Commit your changes** to the main branch
2. **Create a new release** on GitHub:
   ```bash
   git tag v1.0.0
   git push origin v1.0.0
   ```
3. **Create release on GitHub** with the tag
4. **Download the generated ZIP** from release assets

#### Workflow Configuration

The default workflow can be customized in `.github/workflows/release.yml`:

```yaml
name: Release
on:
  release:
    types: [created]

jobs:
  build:
    runs-on: ubuntu-latest
    steps:
      - uses: actions/checkout@v3
      
      - name: Setup Node.js
        uses: actions/setup-node@v3
        with:
          node-version: '18'
          
      - name: Setup PHP
        uses: shivammathur/setup-php@v2
        with:
          php-version: '8.1'
          
      - name: Install dependencies
        run: |
          npm ci
          composer install --no-dev --optimize-autoloader
          
      - name: Build assets
        run: npm run build
        
      - name: Create release ZIP
        run: |
          zip -r theme.zip . -x "node_modules/*" ".git/*" ".github/*"
          
      - name: Upload release asset
        uses: actions/upload-release-asset@v1
        with:
          upload_url: ${{ github.event.release.upload_url }}
          asset_path: ./theme.zip
          asset_name: theme.zip
          asset_content_type: application/zip
```

### 2. TailPress CLI

Use the built-in CLI tool for local releases.

#### CLI Release Command

```bash
./vendor/bin/tailpress-cli release <destination-path> <zipfile-name>
```

#### Example Usage

```bash
# Create release in current directory
./vendor/bin/tailpress-cli release . my-theme-v1.0.0.zip

# Create release in specific directory
./vendor/bin/tailpress-cli release /path/to/releases my-theme-v1.0.0.zip
```

#### CLI Features

The CLI tool automatically:

- Mirrors your theme folder to a temporary location
- Optimizes Composer dependencies with `--no-dev --optimize-autoloader`
- Compiles assets for production
- Removes files and folders listed in `.distignore`
- Creates a ZIP file ready for distribution

### 3. Manual Release

For complete control over the release process.

#### Manual Steps

1. **Create a copy** of your theme directory
2. **Install production dependencies**:
   ```bash
   composer install --no-dev --optimize-autoloader
   ```
3. **Build production assets**:
   ```bash
   npm run build
   ```
4. **Remove development files** (see .distignore for reference)
5. **Create ZIP file** of the cleaned directory

#### Production Dependencies

Ensure only production dependencies are included:

```bash
# Remove development packages
composer install --no-dev --optimize-autoloader

# Verify no dev dependencies
composer show --no-dev
```

#### Asset Compilation

Build optimized assets for production:

```bash
# Production build
npm run build

# Verify build output
ls -la dist/
```

## File Exclusion

### .distignore File

The `.distignore` file specifies which files to exclude from releases:

```
# Development files
node_modules/
.git/
.github/
.gitignore
.distignore

# Source files
resources/
src/
vite.config.mjs
package.json
package-lock.json
composer.json
composer.lock

# Development tools
.vscode/
.idea/
*.log
.DS_Store
Thumbs.db

# Documentation
README.md
CHANGELOG.md
```

### Essential Files for Release

Include these files in your release:

```
# Required WordPress files
style.css
index.php
functions.php
screenshot.png

# Template files
header.php
footer.php
single.php
archive.php
404.php

# Compiled assets
dist/

# Production dependencies
vendor/

# WordPress configuration
theme.json
```

## Version Management

### Semantic Versioning

Follow semantic versioning (SemVer) for releases:

- **MAJOR** (1.0.0): Breaking changes
- **MINOR** (1.1.0): New features, backward compatible
- **PATCH** (1.1.1): Bug fixes, backward compatible

### Version Updates

Update version numbers in multiple locations:

#### style.css
```css
/*
Theme Name: Your Theme Name
Version: 1.0.0
*/
```

#### package.json
```json
{
    "name": "your-theme",
    "version": "1.0.0"
}
```

#### composer.json
```json
{
    "name": "your-org/your-theme",
    "version": "1.0.0"
}
```

### Changelog Management

Maintain a CHANGELOG.md file:

```markdown
# Changelog

## [1.0.0] - 2024-01-15

### Added
- Initial theme release
- Custom color palette
- Responsive design
- Block editor support

### Changed
- Updated to TailPress 5.0

### Fixed
- Mobile navigation issues
```

## Quality Assurance

### Pre-Release Checklist

Before creating a release:

- [ ] All features tested and working
- [ ] Cross-browser compatibility verified
- [ ] Mobile responsiveness confirmed
- [ ] Accessibility standards met
- [ ] Performance optimized
- [ ] Code reviewed and cleaned
- [ ] Documentation updated
- [ ] Version numbers updated
- [ ] Changelog updated

### Testing

#### Functionality Testing

- Test all theme features
- Verify WordPress integration
- Check block editor compatibility
- Test with different content types

#### Performance Testing

```bash
# Analyze bundle size
npm run build
ls -lh dist/

# Test loading times
# Use browser dev tools or online tools
```

#### Compatibility Testing

- Test with latest WordPress version
- Verify PHP compatibility
- Check with popular plugins
- Test on different hosting environments

## Deployment Strategies

### WordPress.org Repository

For themes submitted to WordPress.org:

1. Follow WordPress coding standards
2. Include proper theme headers
3. Ensure GPL compatibility
4. Pass theme review requirements

### Premium Theme Distribution

For commercial themes:

1. Implement licensing system
2. Add update mechanisms
3. Include documentation
4. Provide customer support

### Client Delivery

For client projects:

1. Create installation guide
2. Include customization documentation
3. Provide maintenance instructions
4. Set up staging environment

## Automated Deployment

### CI/CD Pipeline

Set up continuous deployment:

```yaml
# .github/workflows/deploy.yml
name: Deploy
on:
  push:
    branches: [main]

jobs:
  deploy:
    runs-on: ubuntu-latest
    steps:
      - uses: actions/checkout@v3
      
      - name: Build and deploy
        run: |
          npm ci
          npm run build
          # Deploy to staging/production
```

### Deployment Tools

Consider using deployment tools:

- **WP CLI**: Command-line WordPress management
- **Deployer**: PHP deployment tool
- **GitHub Actions**: Automated workflows
- **Buddy**: Visual CI/CD tool

## Security Considerations

### Code Security

- Sanitize all user inputs
- Escape all outputs
- Use WordPress security functions
- Follow WordPress security guidelines

### File Permissions

Set proper file permissions:

```bash
# Directories: 755
find . -type d -exec chmod 755 {} \;

# Files: 644
find . -type f -exec chmod 644 {} \;
```

### Sensitive Information

Never include in releases:

- Database credentials
- API keys
- Development configurations
- Personal information

## Troubleshooting

### Common Release Issues

#### Large File Sizes

- Optimize images and assets
- Remove unnecessary dependencies
- Use proper .distignore exclusions

#### Missing Dependencies

- Verify composer.json includes all required packages
- Check for missing WordPress dependencies
- Test in clean environment

#### Build Failures

- Check for syntax errors
- Verify all imports are correct
- Ensure proper environment setup

### Release Validation

Test your release package:

1. Extract ZIP in clean environment
2. Install on fresh WordPress instance
3. Activate theme and test functionality
4. Check for any missing files or errors

## Next Steps

After successful release:

- Monitor for user feedback
- Track performance metrics
- Plan future updates
- Maintain documentation
- Provide ongoing support

## Resources

- [WordPress Theme Review Guidelines](https://make.wordpress.org/themes/handbook/review/)
- [Semantic Versioning](https://semver.org/)
- [GitHub Actions Documentation](https://docs.github.com/en/actions)
