# Analyze Command

Phân tích kiến trúc và cấu trúc dự án WordPress: $ARGUMENTS

## Analysis Types

### Code Analysis
```bash
/analyze --code --think          # Analyze theme architecture with deep thinking
/analyze --code [file/directory] # Analyze specific code files
```

### Architecture Analysis  
```bash
/analyze --architecture --seq    # Deep dive into project structure with sequential thinking
/analyze --architecture          # Quick architecture overview
```

### Performance Analysis
```bash
/analyze --profile              # Find performance bottlenecks
/analyze --performance          # Analyze loading times and optimization opportunities
```

## Analysis Focus Areas

1. **Theme Architecture**
   - File organization and structure
   - Template hierarchy compliance
   - Hook and filter usage
   - Code patterns and conventions

2. **WordPress Integration**
   - Plugin compatibility
   - Theme standards compliance
   - Security best practices
   - Performance optimization

3. **Build Process**
   - Asset compilation
   - Dependency management
   - Optimization strategies
   - Development workflow

4. **Code Quality**
   - Coding standards (PSR, WordPress)
   - Security vulnerabilities
   - Performance issues
   - Maintainability concerns

## Output Format
- Detailed analysis report
- Actionable recommendations
- Priority-based improvement suggestions
- Code examples and fixes

## Usage Examples
```bash
/analyze --code --think                    # Full theme analysis with reasoning
/analyze --architecture --seq              # Sequential architecture deep dive
/analyze --profile                         # Performance bottleneck analysis
/analyze --code "wp-content/themes/custom" # Analyze specific theme directory
```
