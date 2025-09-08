# Cleanup Command

Dọn dẹp và tối ưu hóa dự án WordPress: $ARGUMENTS

## Cleanup Types

### Code Cleanup
```bash
/cleanup --code --dry-run       # Check what can be cleaned (preview mode)
/cleanup --code                 # Clean up code issues
/cleanup --unused               # Remove unused code and imports
```

### File Cleanup
```bash
/cleanup --files                # Remove unused files
/cleanup --assets               # Clean up unused assets
/cleanup --temp                 # Remove temporary files
```

### Dependency Cleanup
```bash
/cleanup --deps                 # Update and clean dependencies
/cleanup --packages             # Remove unused packages
/cleanup --node-modules         # Clean node_modules
```

### Database Cleanup
```bash
/cleanup --database             # Clean up database (WordPress specific)
/cleanup --transients           # Clear expired transients
/cleanup --revisions            # Remove old post revisions
```

## Cleanup Areas

1. **Code Cleanup**
   - Remove unused functions and classes
   - Clean up commented code
   - Remove debug statements
   - Optimize imports and includes

2. **File System Cleanup**
   - Delete unused theme files
   - Remove old backup files
   - Clean up log files
   - Remove temporary uploads

3. **Asset Cleanup**
   - Remove unused CSS/JS files
   - Optimize image files
   - Clean up font files
   - Remove duplicate assets

4. **Dependency Management**
   - Update outdated packages
   - Remove unused dependencies
   - Clean package lock files
   - Optimize bundle sizes

5. **WordPress Specific**
   - Clean up inactive plugins
   - Remove unused themes
   - Clear cache files
   - Optimize database tables

## Safety Features
- **Dry Run Mode**: Preview changes before applying
- **Backup Creation**: Automatic backups before cleanup
- **Rollback Support**: Ability to undo changes
- **Selective Cleanup**: Choose specific areas to clean

## Cleanup Process
1. **Analysis**: Identify cleanup opportunities
2. **Preview**: Show what will be cleaned (dry-run)
3. **Backup**: Create safety backups
4. **Execute**: Perform cleanup operations
5. **Verify**: Confirm everything still works

## Usage Examples
```bash
/cleanup --code --dry-run                  # Preview code cleanup
/cleanup --files                           # Remove unused files
/cleanup --deps                            # Clean up dependencies
/cleanup --assets --dry-run                # Preview asset cleanup
/cleanup --database --safe                 # Safe database cleanup
```

## Integration Notes
- Run before committing changes
- Use with `/scan --validate` to verify results
- Combine with `/git --status` to review changes
