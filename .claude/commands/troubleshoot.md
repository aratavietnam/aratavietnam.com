# Troubleshoot Command

Chẩn đoán và khắc phục sự cố trong dự án WordPress: $ARGUMENTS

## Troubleshooting Types

### Investigation
```bash
/troubleshoot --investigate     # Debug asset loading issues
/troubleshoot --analyze [issue] # Analyze specific problem
/troubleshoot --trace           # Trace execution flow
```

### Fix Operations
```bash
/troubleshoot --fix "assets not loading"  # Fix hashed filename issues
/troubleshoot --fix "build errors"        # Resolve build problems
/troubleshoot --fix "performance"         # Address performance issues
```

### Diagnostic Tools
```bash
/troubleshoot --check           # Run comprehensive diagnostics
/troubleshoot --validate        # Validate current setup
/troubleshoot --test            # Test specific functionality
```

## Common WordPress Issues

### Asset Loading Problems
1. **Hashed Filename Issues**
   - Vite build generates hashed filenames
   - WordPress can't find assets
   - Manifest file not properly read

2. **Path Resolution**
   - Incorrect asset URLs
   - Missing base path configuration
   - HTTPS/HTTP mismatch

3. **Cache Issues**
   - Browser cache conflicts
   - WordPress cache problems
   - CDN cache invalidation

### Build Process Issues
1. **Vite Configuration**
   - Incorrect output paths
   - Missing WordPress integration
   - Plugin conflicts

2. **Dependency Problems**
   - Version conflicts
   - Missing packages
   - Peer dependency issues

3. **Environment Issues**
   - Node.js version mismatch
   - Missing environment variables
   - Permission problems

### Performance Issues
1. **Slow Loading**
   - Large bundle sizes
   - Unoptimized images
   - Too many HTTP requests

2. **Memory Issues**
   - PHP memory limits
   - JavaScript memory leaks
   - Database query overload

## Diagnostic Process

1. **Problem Identification**
   - Gather error messages
   - Reproduce the issue
   - Check browser console
   - Review server logs

2. **Root Cause Analysis**
   - Trace the problem source
   - Check configuration files
   - Validate dependencies
   - Test in isolation

3. **Solution Implementation**
   - Apply targeted fixes
   - Test the solution
   - Verify no side effects
   - Document the fix

## Fix Strategies

### Asset Loading Fixes
```bash
# Check Vite manifest integration
/troubleshoot --fix "vite manifest not found"

# Fix asset path issues
/troubleshoot --fix "incorrect asset paths"

# Resolve cache problems
/troubleshoot --fix "cache conflicts"
```

### Build Process Fixes
```bash
# Fix Vite configuration
/troubleshoot --fix "vite config errors"

# Resolve dependency issues
/troubleshoot --fix "dependency conflicts"

# Fix permission problems
/troubleshoot --fix "build permissions"
```

## Usage Examples
```bash
/troubleshoot --investigate                    # General investigation
/troubleshoot --fix "assets not loading"       # Fix specific asset issue
/troubleshoot --analyze "slow page load"       # Analyze performance issue
/troubleshoot --check                          # Run full diagnostics
/troubleshoot --fix "vite build errors"        # Fix build problems
```

## Integration with Other Commands
- Use with `/scan --validate` after fixes
- Combine with `/analyze --profile` for performance issues
- Follow up with `/git --status` to review changes
