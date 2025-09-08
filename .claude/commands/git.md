# Git Command

Quản lý Git và version control cho dự án WordPress: $ARGUMENTS

## Git Operations

### Status and Review
```bash
/git --status                   # Review current changes
/git --diff                     # Show detailed differences
/git --log                      # View commit history
```

### Branch Management
```bash
/git --branch [name]            # Create or switch branch
/git --merge [branch]           # Merge branch
/git --rebase                   # Rebase current branch
```

### Commit Operations
```bash
/git --commit "message"         # Commit with message
/git --amend                    # Amend last commit
/git --reset [commit]           # Reset to specific commit
```

### Remote Operations
```bash
/git --push                     # Push to remote
/git --pull                     # Pull from remote
/git --fetch                    # Fetch remote changes
```

## WordPress-Specific Git Workflows

1. **Pre-Commit Workflow**
   ```bash
   /cleanup --code --dry-run      # Check what can be cleaned
   /git --status                  # Review changes
   /scan --validate               # Validate everything works
   /git --commit "feature: description"
   ```

2. **Asset Management**
   - Track built assets appropriately
   - Ignore development files
   - Handle Vite build outputs
   - Manage WordPress uploads

3. **Branch Strategy**
   - `main/master`: Production-ready code
   - `develop`: Development integration
   - `feature/*`: Feature branches
   - `hotfix/*`: Critical fixes

## Git Best Practices

1. **Commit Messages**
   - Use conventional commits format
   - Be descriptive and specific
   - Reference issues when applicable
   - Keep first line under 50 characters

2. **File Management**
   - Proper `.gitignore` configuration
   - Track only necessary files
   - Exclude sensitive information
   - Handle WordPress-specific files

3. **Branching Strategy**
   - Feature branches for new work
   - Regular integration with develop
   - Clean merge history
   - Tag releases appropriately

## WordPress .gitignore Recommendations
```
# WordPress Core
/wp-admin/
/wp-includes/
/wp-content/index.php
/wp-content/languages/
/wp-content/upgrade/

# Plugins (except custom)
/wp-content/plugins/
!/wp-content/plugins/custom-plugin/

# Themes (except active)
/wp-content/themes/
!/wp-content/themes/your-theme/

# Build and Dependencies
node_modules/
vendor/
dist/
build/

# Environment and Config
.env
wp-config.php
.htaccess
```

## Usage Examples
```bash
/git --status                              # Check current status
/git --diff                                # See what changed
/git --commit "fix: resolve asset loading" # Commit changes
/git --push                                # Push to remote
/git --branch "feature/new-component"      # Create feature branch
```
