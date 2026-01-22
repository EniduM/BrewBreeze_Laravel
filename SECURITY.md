# Security Implementation

## CSRF Protection
- All HTML forms include `@csrf` token via Blade
- Middleware: `VerifyCsrfToken` active on all web routes
- Token automatically rotated per session
- SameSite cookie attribute enforced

## XSS Prevention
- All Blade variables escaped by default: `{{ $var }}` 
- User-generated content sanitized through validation layer
- No raw HTML output without explicit `{!! !!}` (used only for trusted content)
- Content-Security-Policy headers configured for additional protection

## SQL Injection Prevention
- All database queries use Eloquent ORM with parameterized queries
- Never concatenates user input into raw SQL
- Query scopes (`scopeByStatus`, `scopeSearch`) use parameter binding
- Form Requests validate all input before database operations

## Authentication & Session Management
- Passwords hashed with bcrypt (Laravel default, 10+ rounds)
- Sanctum tokens stored as SHA-256 hashes in `personal_access_tokens` table
- Sessions stored securely with httpOnly, Secure, SameSite flags
- Sessions automatically invalidated on logout
- Two-factor authentication optional via Jetstream

## Authorization & Access Control
- Role-based access via middleware (`EnsureUserIsAdmin`, `EnsureUserIsCustomer`)
- Resource-level authorization via Laravel Policies
- Example: `$this->authorize('view', $order)` checks OrderPolicy
- Admins can manage all resources; customers limited to their own orders
- API endpoints require `auth:sanctum` middleware

## Data Protection
- Soft deletes preserve data: `SoftDeletes` trait on all models
- Sensitive columns like passwords never logged
- Rate limiting on authentication endpoints: 5 attempts per minute
- Password reset tokens expire after 60 minutes
- Remember tokens hashed before storage

## HTTPS Enforcement
- Forced on production via `ForceHttpsMiddleware`
- All cookies marked as `secure` and `httpOnly`
- HSTS header configured: `max-age=31536000`
- Mixed content blocked by CSP headers

## API Security
- All API routes require `auth:sanctum` middleware
- Token scope validation on sensitive endpoints
- Rate limiting per authenticated user
- CORS properly configured for cross-origin requests
- JSON response format prevents JSONP exploitation

## Monitoring & Logging
- Sensitive data filtered from logs (passwords, tokens)
- All authentication attempts logged with timestamp + IP
- Database migrations create audit trail of structure changes
- Unhandled exceptions logged with full context
- Admin status changes logged for compliance

## Best Practices Implemented
- Input validation on all forms via Form Requests
- Output encoding on all user-facing data
- Secure random token generation for APIs
- Principle of least privilege on database user
- Regular security updates via Composer
