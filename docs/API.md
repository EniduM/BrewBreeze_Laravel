# BrewBreeze API Documentation

## Base URL

```
http://127.0.0.1:8000/api/v1
```

## Authentication

All protected endpoints require authentication using Bearer tokens obtained from the login endpoint.

### Headers

```
Authorization: Bearer {token}
Content-Type: application/json
Accept: application/json
```

---

## Endpoints

### Authentication

#### Login

**POST** `/api/v1/login`

**Request Body:**
```json
{
  "email": "user@example.com",
  "password": "password123"
}
```

**Response (200 OK):**
```json
{
  "success": true,
  "message": "Login successful",
  "data": {
    "user": {
      "id": 1,
      "name": "John Doe",
      "email": "user@example.com",
      "role": "customer"
    },
    "token": "1|abcdefghijklmnopqrstuvwxyz",
    "token_type": "Bearer"
  }
}
```

#### Logout

**POST** `/api/v1/logout`

**Headers:** Requires authentication

**Response (200 OK):**
```json
{
  "success": true,
  "message": "Logged out successfully"
}
```

---

### Products

#### Get All Products

**GET** `/api/v1/products`

**Headers:** Requires authentication

**Query Parameters:**
- `search` (string, optional): Search products by name or description
- `min_price` (float, optional): Minimum price filter
- `max_price` (float, optional): Maximum price filter
- `roast_level` (string, optional): Filter by roast level
- `sort_by` (string, optional): Sort field (name, price, created_at, stock)
- `sort_order` (string, optional): Sort order (asc, desc) - default: desc
- `per_page` (integer, optional): Items per page (default: 15, max: 100)
- `page` (integer, optional): Page number

**Response (200 OK):**
```json
{
  "success": true,
  "message": "Products retrieved successfully",
  "data": [
    {
      "id": 1,
      "name": "Premium Arabica",
      "description": "High-quality Arabica coffee beans",
      "price": 29.99,
      "formatted_price": "$29.99",
      "stock": 50,
      "is_in_stock": true,
      "image": "http://127.0.0.1:8000/storage/products/image.jpg",
      "roast_level": "medium",
      "origin": "Colombia",
      "created_at": "2024-01-01T00:00:00.000000Z"
    }
  ],
  "meta": {
    "current_page": 1,
    "last_page": 3,
    "per_page": 15,
    "total": 42,
    "from": 1,
    "to": 15
  },
  "links": {
    "first": "http://127.0.0.1:8000/api/v1/products?page=1",
    "last": "http://127.0.0.1:8000/api/v1/products?page=3",
    "prev": null,
    "next": "http://127.0.0.1:8000/api/v1/products?page=2"
  }
}
```

---

### Cart

#### Add to Cart

**POST** `/api/v1/cart`

**Headers:** Requires authentication + `customer` scope

**Request Body:**
```json
{
  "product_id": 1,
  "quantity": 2
}
```

**Response (200 OK):**
```json
{
  "success": true,
  "message": "Product added to cart successfully",
  "data": {
    "cart": {
      "id": 1,
      "items": [
        {
          "product_id": 1,
          "product_name": "Premium Arabica",
          "quantity": 2,
          "price": 29.99,
          "subtotal": 59.98
        }
      ],
      "total": 59.98
    }
  }
}
```

---

### Orders

#### Create Order

**POST** `/api/v1/orders`

**Headers:** Requires authentication + `customer` scope

**Request Body:**
```json
{
  "payment_method": "credit_card",
  "currency": "usd",
  "address": "123 Main St, City, State, ZIP"
}
```

**Response (201 Created):**
```json
{
  "success": true,
  "message": "Order created successfully",
  "data": {
    "order": {
      "id": 1,
      "date": "2024-01-01",
      "total": 59.98,
      "status": "paid",
      "items": [
        {
          "product_id": 1,
          "product_name": "Premium Arabica",
          "quantity": 2,
          "price": 29.99,
          "subtotal": 59.98
        }
      ],
      "payment": {
        "method": "credit_card",
        "amount": 59.98,
        "date": "2024-01-01"
      }
    }
  }
}
```

---

### Subscriptions

#### Get Subscriptions

**GET** `/api/v1/subscriptions`

**Headers:** Requires authentication + `customer` scope

**Response (200 OK):**
```json
{
  "success": true,
  "message": "Subscriptions retrieved successfully",
  "data": [
    {
      "id": 1,
      "tier": "premium",
      "tier_name": "Premium Plan",
      "tier_price": 49.99,
      "formatted_price": "$49.99",
      "start_date": "2024-01-01",
      "status": "active",
      "is_active": true,
      "days_active": 30,
      "next_billing_date": "2024-02-01",
      "created_at": "2024-01-01T00:00:00.000000Z"
    }
  ]
}
```

#### Create Subscription

**POST** `/api/v1/subscriptions`

**Headers:** Requires authentication + `customer` scope

**Request Body:**
```json
{
  "tier": "premium"
}
```

**Available Tiers:**
- `basic` - Basic Plan ($19.99/month)
- `premium` - Premium Plan ($49.99/month)
- `elite` - Elite Plan ($99.99/month)

**Response (201 Created):**
```json
{
  "success": true,
  "message": "Subscription created successfully",
  "data": {
    "subscription": {
      "id": 1,
      "tier": "premium",
      "tier_name": "Premium Plan",
      "tier_price": 49.99,
      "formatted_price": "$49.99",
      "start_date": "2024-01-01",
      "status": "active",
      "next_billing_date": "2024-02-01"
    }
  }
}
```

**Error Response (400 Bad Request):**
```json
{
  "success": false,
  "message": "You already have an active subscription. Please cancel it before subscribing to a new one."
}
```

#### Cancel Subscription

**DELETE** `/api/v1/subscriptions/{subscription_id}`

**Headers:** Requires authentication + `customer` scope

**Response (200 OK):**
```json
{
  "success": true,
  "message": "Subscription cancelled successfully",
  "data": {
    "subscription": {
      "id": 1,
      "tier": "premium",
      "status": "cancelled"
    }
  }
}
```

**Error Response (404 Not Found):**
```json
{
  "success": false,
  "message": "Subscription not found."
}
```

---

### User

#### Get Authenticated User

**GET** `/api/v1/user`

**Headers:** Requires authentication

**Response (200 OK):**
```json
{
  "success": true,
  "data": {
    "user": {
      "id": 1,
      "name": "John Doe",
      "email": "user@example.com",
      "role": "customer"
    }
  }
}
```

---

## Error Responses

All error responses follow this format:

```json
{
  "success": false,
  "message": "Error description",
  "error": "Detailed error message",
  "errors": {} // Only present for validation errors
}
```

### Status Codes

- `200` - OK
- `201` - Created
- `400` - Bad Request
- `401` - Unauthorized
- `403` - Forbidden
- `404` - Not Found
- `422` - Validation Error
- `429` - Too Many Requests (Rate Limit)
- `500` - Internal Server Error

---

## Rate Limiting

API requests are rate-limited:
- **Public endpoints** (login): 60 requests per minute
- **Protected endpoints**: 100 requests per minute

When rate limit is exceeded, a `429` status code is returned with the following response:

```json
{
  "success": false,
  "message": "Too many requests",
  "error": "Rate limit exceeded. Please try again later."
}
```

---

## Token Expiration

API tokens expire after 24 hours by default. To refresh your token, make a new login request.

---

## Payment Methods

Supported payment methods:
- `credit_card` - Credit card via Stripe
- `debit_card` - Debit card via Stripe
- `paypal` - PayPal
- `bank_transfer` - Bank transfer (manual verification)

---

## Pagination

Endpoints that support pagination return metadata in the `meta` field:

```json
{
  "meta": {
    "current_page": 1,
    "last_page": 3,
    "per_page": 15,
    "total": 42,
    "from": 1,
    "to": 15
  }
}
```

---

## Response Headers

All API responses include custom headers:

- `X-Response-Time`: Response time in milliseconds
- `X-API-Version`: API version (v1)

---

## Examples

### cURL Example - Login

```bash
curl -X POST http://127.0.0.1:8000/api/v1/login \
  -H "Content-Type: application/json" \
  -d '{
    "email": "user@example.com",
    "password": "password123"
  }'
```

### cURL Example - Get Products

```bash
curl -X GET http://127.0.0.1:8000/api/v1/products \
  -H "Authorization: Bearer YOUR_TOKEN_HERE" \
  -H "Accept: application/json"
```

### cURL Example - Create Order

```bash
curl -X POST http://127.0.0.1:8000/api/v1/orders \
  -H "Authorization: Bearer YOUR_TOKEN_HERE" \
  -H "Content-Type: application/json" \
  -d '{
    "payment_method": "credit_card",
    "currency": "usd",
    "address": "123 Main St, City, State, ZIP"
  }'
```

---

## Support

For API support or to report issues, please contact the development team.
