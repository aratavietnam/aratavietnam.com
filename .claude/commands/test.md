# Test Command

Tạo và chạy tests cho: $ARGUMENTS

## Test Strategy
1. **Unit Tests**: Individual functions/components
2. **Integration Tests**: API endpoints, database
3. **E2E Tests**: User workflows
4. **Performance Tests**: Load & stress testing

## Test Requirements
- Coverage > 80%
- All edge cases covered
- Error scenarios tested
- Mock external dependencies

## Frameworks
- **Jest**: Unit & integration
- **Testing Library**: React components
- **Cypress**: E2E testing
- **Supertest**: API testing

## Usage
```bash
/test "UserService authentication"
/test --unit "validation functions"
/test --e2e "user registration flow"
```