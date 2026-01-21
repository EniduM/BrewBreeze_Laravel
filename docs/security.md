# Security Documentation

## BrewBreeze Application Security

This document outlines the security measures implemented in the BrewBreeze application to protect against common web application vulnerabilities and threats.

---

## Table of Contents

1. [Authentication & Authorization](#authentication--authorization)
2. [Role-Based Access Control (RBAC)](#role-based-access-control-rbac)
3. [CSRF Protection](#csrf-protection)
4. [XSS Prevention](#xss-prevention)
5. [SQL Injection Prevention](#sql-injection-prevention)
6. [API Security with Sanctum](#api-security-with-sanctum)
7. [Password Hashing](#password-hashing)
8. [Session Management](#session-management)
9. [Additional Security Measures](#additional-security-measures)

---

## Authentication & Authorization

### Overview
Authentication verifies user identity, while authorization determines what authenticated users can access.

### Implementation

#### Authentication
- **Laravel Jetstream**: Provides complete authentication scaffolding
- **Laravel Fortify**: Handles authentication logic
- **Email Verification**: Users must verify their email addresses
- **Password Reset**: Secure password reset functionality via email

#### Authorization
- **Middleware Protection**: Routes protected by authentication middleware
- **Policies**: Granular authorization using Laravel Policies
- **Route Guards**: Multiple authentication guards for different contexts

### Threats Mitigated

| Threat | Mitigation |
|--------|-----------|
| Unauthorized access | All protected routes require authentication |
| Session hijacking | Secure session management with CSRF tokens |
| Brute force attacks | Laravel's rate limiting on login attempts |
| Account enumeration | Generic error messages prevent user discovery |

### Code Examples

```php
// Route protection
Route::middleware(['auth:sanctum', 'verified'])->group(function () {
    // Protected routes
});

// Policy-based authorization
if ($user->can('update', $product)) {
    // User can update product
}
```

---

## Role-Based Access Control (RBAC)

### Overview
RBAC restricts system access based on user roles (Admin and Customer).

### Implementation

#### User Roles
- **Admin**: Full system access
- **Customer**: Limited access to customer-specific features

#### Role Storage
- Roles stored in `users` table as enum: `admin` or `customer`
- Helper methods: `isAdmin()` and `isCustomer()` on User model

#### Middleware Protection
- **EnsureUserIsAdmin**: Protects admin-only routes
- **EnsureUserIsCustomer**: Protects customer-only routes

### Threats Mitigated

| Threat | Mitigation |
|--------|-----------|
| Privilege escalation | Role checks at middleware and policy levels |
| Unauthorized feature access | Role-based route protection |
| Cross-role access | Separate middleware for each role |

### Code Examples

```php
// Admin middleware
Route::middleware(['auth', 'admin'])->group(function () {
    Route::get('/admin/dashboard', ...);
});

// Customer middleware
Route::middleware(['auth', 'customer'])->group(function () {
    Route::get('/dashboard', ...);
});

// Policy check
public function update(User $user, Product $product): bool
{
    return $user->isAdmin();
}
```

### Access Matrix

| Feature | Admin | Customer |
|---------|-------|----------|
| View Products | ✅ | ✅ |
| Create/Edit Products | ✅ | ❌ |
| View Orders | ✅ | ✅ (own only) |
| Create Orders | ❌ | ✅ |
| Manage Subscriptions | ✅ | ✅ (own only) |
| View Messages | ✅ | ❌ |
| Send Messages | ❌ | ✅ |

---

## CSRF Protection

### Overview
Cross-Site Request Forgery (CSRF) protection prevents unauthorized actions from being performed on behalf of authenticated users.

### Implementation

#### Automatic CSRF Protection
- **Laravel's Built-in CSRF**: Enabled by default for all POST/PUT/DELETE requests
- **CSRF Token**: Included in all forms via `@csrf` directive
- **Token Validation**: Automatically validated on form submissions

#### API Protection
- **Sanctum Token**: API uses token-based authentication (no CSRF needed)
- **Stateful Domains**: CSRF protection for SPA applications

### Threats Mitigated

| Threat | Mitigation |
|--------|-----------|
| Unauthorized form submissions | CSRF token validation |
| Cross-site attacks | Token verification on every request |
| Session hijacking | Token tied to user session |

### Code Examples

```blade
{{-- Blade form with CSRF token --}}
<form method="POST" action="/orders">
    @csrf
    <!-- Form fields -->
</form>

{{-- Livewire components --}}
<form wire:submit="save">
    <!-- CSRF handled automatically by Livewire -->
</form>
```

### Configuration

```php
// config/sanctum.php
'stateful' => explode(',', env('SANCTUM_STATEFUL_DOMAINS', 
    'localhost,localhost:3000,127.0.0.1,127.0.0.1:8000,::1'
));
```

---

## XSS Prevention

### Overview
Cross-Site Scripting (XSS) protection prevents malicious scripts from being executed in users' browsers.

### Implementation

#### Automatic Escaping
- **Blade Templates**: All output automatically escaped by default
- **{!! !!} Syntax**: Only used when explicitly needed (with caution)
- **Livewire**: Automatic XSS protection in components

#### Input Sanitization
- **Validation**: All user input validated before processing
- **HTML Purification**: Consider using HTMLPurifier for rich text content
- **Content Security Policy**: Can be configured via middleware

### Threats Mitigated

| Threat | Mitigation |
|--------|-----------|
| Stored XSS | Automatic escaping in Blade templates |
| Reflected XSS | Input validation and output escaping |
| DOM-based XSS | Careful JavaScript handling |

### Code Examples

```blade
{{-- Safe: Automatically escaped --}}
<p>{{ $user->name }}</p>

{{-- Dangerous: Only use when necessary --}}
<div>{!! $trustedHtml !!}</div>

{{-- Safe: Using Str::limit --}}
<p>{{ Str::limit($description, 100) }}</p>
```

### Best Practices

1. **Always use `{{ }}` for user-generated content**
2. **Validate and sanitize all input**
3. **Use `{!! !!}` only for trusted content**
4. **Implement Content Security Policy headers**

---

## SQL Injection Prevention

### Overview
SQL Injection protection prevents malicious SQL code from being executed in database queries.

### Implementation

#### Eloquent ORM
- **Parameter Binding**: All queries use parameter binding automatically
- **Query Builder**: Safe query construction methods
- **Prepared Statements**: Database uses prepared statements

#### Raw Queries
- **DB::raw()**: Only used with caution and proper escaping
- **Parameter Binding**: Always use parameter binding for raw queries

### Threats Mitigated

| Threat | Mitigation |
|--------|-----------|
| SQL injection via input | Parameter binding in all queries |
| Database manipulation | Eloquent ORM prevents direct SQL |
| Data extraction | Proper query construction |

### Code Examples

```php
// ✅ Safe: Eloquent ORM
$products = Product::where('name', $request->name)->get();

// ✅ Safe: Query Builder with binding
DB::table('products')
    ->where('name', '=', $request->name)
    ->get();

// ✅ Safe: Raw query with binding
DB::select('SELECT * FROM products WHERE name = ?', [$request->name]);

// ❌ Dangerous: Never do this
DB::select("SELECT * FROM products WHERE name = '{$request->name}'");
```

### Best Practices

1. **Always use Eloquent ORM or Query Builder**
2. **Never concatenate user input into SQL**
3. **Use parameter binding for raw queries**
4. **Validate input before database operations**

---

## API Security with Sanctum

### Overview
Laravel Sanctum provides token-based authentication for API endpoints with scope-based authorization.

### Implementation

#### Token Authentication
- **Token Generation**: Tokens created on login with scopes
- **Token Storage**: Tokens stored securely in database
- **Token Revocation**: Tokens can be revoked on logout

#### Scope-Based Authorization
- **Admin Scope**: Full system access
- **Customer Scope**: Limited to customer endpoints
- **Middleware Protection**: `ability:customer` middleware enforces scopes

### Threats Mitigated

| Threat | Mitigation |
|--------|-----------|
| Unauthorized API access | Token authentication required |
| Token theft | HTTPS recommended, token expiration |
| Scope escalation | Ability middleware enforces scopes |
| Token replay | Token revocation on logout |

### Code Examples

```php
// Token creation with scopes
$abilities = $user->isAdmin() ? ['admin'] : ['customer'];
$token = $user->createToken('api-token', $abilities)->plainTextToken;

// Protected route with scope
Route::post('/api/cart', [CartController::class, 'store'])
    ->middleware('auth:sanctum', 'ability:customer');

// Token revocation
$request->user()->currentAccessToken()->delete();
```

### API Security Best Practices

1. **Always use HTTPS in production**
2. **Implement token expiration**
3. **Use scope-based authorization**
4. **Validate all API requests**
5. **Rate limit API endpoints**
6. **Log API access for auditing**

---

## Password Hashing

### Overview
Passwords are never stored in plain text. Laravel uses bcrypt for secure password hashing.

### Implementation

#### Automatic Hashing
- **Model Casting**: Passwords automatically hashed via `casts()` method
- **Bcrypt Algorithm**: Default hashing algorithm (cost factor: 10)
- **One-way Hashing**: Passwords cannot be reversed

#### Password Verification
- **Hash::check()**: Secure password comparison
- **Auth::attempt()**: Automatic password verification in authentication

### Threats Mitigated

| Threat | Mitigation |
|--------|-----------|
| Password theft | Passwords stored as hashes |
| Rainbow table attacks | Bcrypt with salt prevents pre-computed attacks |
| Brute force | Slow hashing algorithm increases attack time |

### Code Examples

```php
// Automatic hashing in model
protected function casts(): array
{
    return [
        'password' => 'hashed',
    ];
}

// Manual hashing (if needed)
$hashedPassword = Hash::make($password);

// Password verification
if (Hash::check($plainPassword, $hashedPassword)) {
    // Password matches
}
```

### Best Practices

1. **Never store plain text passwords**
2. **Use Laravel's automatic hashing**
3. **Implement password strength requirements**
4. **Consider password expiration policies**
5. **Use secure password reset flows**

---

## Session Management

### Overview
Secure session management prevents session hijacking and ensures proper session lifecycle.

### Implementation

#### Session Configuration
- **Session Driver**: Database or file-based sessions
- **Session Encryption**: Sessions encrypted by default
- **Session Timeout**: Configurable session lifetime
- **Secure Cookies**: HTTPS-only cookies in production

#### Session Security
- **CSRF Tokens**: Tied to user sessions
- **Session Regeneration**: On login for security
- **Concurrent Sessions**: Can be limited if needed

### Threats Mitigated

| Threat | Mitigation |
|--------|-----------|
| Session hijacking | Encrypted sessions, secure cookies |
| Session fixation | Session regeneration on login |
| Session timeout | Automatic session expiration |
| Concurrent sessions | Can be limited per user |

### Configuration

```php
// config/session.php
'driver' => env('SESSION_DRIVER', 'database'),
'lifetime' => env('SESSION_LIFETIME', 120), // minutes
'secure' => env('SESSION_SECURE_COOKIE', true), // HTTPS only
'http_only' => true, // Prevent JavaScript access
'same_site' => 'lax', // CSRF protection
```

### Best Practices

1. **Use HTTPS in production**
2. **Set appropriate session lifetime**
3. **Regenerate session on login**
4. **Use secure cookie settings**
5. **Implement session timeout warnings**

---

## Additional Security Measures

### Input Validation

#### Request Validation
- **Form Requests**: Dedicated validation classes
- **Validation Rules**: Comprehensive rule sets
- **Custom Messages**: User-friendly error messages

```php
// Example: LoginRequest
public function rules(): array
{
    return [
        'email' => 'required|email',
        'password' => 'required|string|min:8',
    ];
}
```

### Rate Limiting

#### Implementation
- **Login Attempts**: Limited to prevent brute force
- **API Endpoints**: Can be rate limited
- **General Routes**: Global rate limiting available

```php
// Rate limiting example
Route::middleware(['throttle:60,1'])->group(function () {
    // 60 requests per minute
});
```

### Error Handling

#### Secure Error Messages
- **Generic Messages**: Don't reveal system details
- **Logging**: Detailed errors logged server-side
- **User-Friendly**: Clear messages for users

### Database Security

#### Best Practices
- **Foreign Key Constraints**: Enforced relationships
- **Soft Deletes**: Data retention with security
- **Indexes**: Performance and data integrity
- **Transactions**: Atomic operations

### File Upload Security

#### If Implemented
- **File Validation**: Type and size validation
- **Storage Location**: Outside public directory
- **Virus Scanning**: Consider antivirus checks
- **File Naming**: Prevent directory traversal

### Security Headers

#### Recommended Headers
```php
// Can be added via middleware
X-Content-Type-Options: nosniff
X-Frame-Options: DENY
X-XSS-Protection: 1; mode=block
Strict-Transport-Security: max-age=31536000
Content-Security-Policy: default-src 'self'
```

---

## Security Checklist

### Authentication & Authorization
- [x] User authentication implemented
- [x] Email verification required
- [x] Password reset functionality
- [x] Role-based access control
- [x] Policy-based authorization
- [x] Middleware protection

### Data Protection
- [x] Password hashing (bcrypt)
- [x] CSRF protection enabled
- [x] XSS prevention (Blade escaping)
- [x] SQL injection prevention (Eloquent ORM)
- [x] Input validation
- [x] Output sanitization

### API Security
- [x] Token-based authentication
- [x] Scope-based authorization
- [x] Request validation
- [x] JSON response format
- [x] HTTPS recommended

### Session Management
- [x] Encrypted sessions
- [x] Secure cookies
- [x] Session timeout
- [x] Session regeneration

### Additional
- [x] Error handling
- [x] Logging
- [x] Database transactions
- [x] Foreign key constraints

---

## Security Recommendations

### Production Deployment

1. **Environment Configuration**
   - Set `APP_ENV=production`
   - Set `APP_DEBUG=false`
   - Use strong `APP_KEY`

2. **HTTPS**
   - Enable HTTPS for all connections
   - Use valid SSL certificates
   - Configure secure cookies

3. **Database**
   - Use strong database passwords
   - Limit database user permissions
   - Regular backups

4. **Server Configuration**
   - Keep software updated
   - Configure firewall rules
   - Implement intrusion detection

5. **Monitoring**
   - Log security events
   - Monitor failed login attempts
   - Track API usage patterns

### Regular Security Audits

1. **Dependency Updates**
   - Keep Laravel and packages updated
   - Review security advisories
   - Test updates in staging

2. **Code Reviews**
   - Review security-sensitive code
   - Check for common vulnerabilities
   - Validate input/output handling

3. **Penetration Testing**
   - Regular security testing
   - Vulnerability scanning
   - Code analysis tools

---

## Incident Response

### If Security Breach Detected

1. **Immediate Actions**
   - Revoke affected tokens
   - Reset compromised passwords
   - Review access logs

2. **Investigation**
   - Identify breach scope
   - Review affected systems
   - Document findings

3. **Remediation**
   - Patch vulnerabilities
   - Update security measures
   - Notify affected users (if required)

4. **Prevention**
   - Implement additional safeguards
   - Update security policies
   - Conduct security training

---

## Contact

For security concerns or to report vulnerabilities, please contact the development team.

**Last Updated**: {{ date('Y-m-d') }}

**Version**: 1.0

