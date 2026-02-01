
---

```md
# Authentication & Personal Data API

This document explains the authentication flow and personal profile data
for the API in a clear and simple way.

The API supports two account types:
- **Admin**
- **Resident**

---

## Authentication Method

The API uses **Bearer Token Authentication**.

After a successful login, the server returns an access token.
This token must be sent in the header with every protected request.

```

Authorization: Bearer ACCESS_TOKEN

````

---

## Admin API

### Admin Login
**POST** `/api/admin/login`

#### Request Body
```json
{
  "phone": "777777777",
  "password": "password123"
}
````

#### Success Response

```json
{
  "success": true,
  "message": "Login successful",
  "token": "ACCESS_TOKEN",
  "token_type": "Bearer",
  "admin": {
    "id": 1,
    "name": "Admin Name",
    "email": "admin@example.com",
    "phone": "777777777",
    "branches": []
  }
}
```

#### Notes

* All previous tokens are deleted on login
* A new token is generated on each login

---

### Admin Logout

**POST** `/api/admin/logout`
**Authentication:** `admin-api`

#### Response

```json
{
  "success": true,
  "message": "Logout successful"
}
```

---

### Admin Profile

**GET** `/api/admin/profile`
**Authentication:** `admin-api`

#### Response

```json
{
  "success": true,
  "admin": {
    "id": 1,
    "name": "Admin Name",
    "email": "admin@example.com",
    "phone": "777777777",
    "created_at": "2026-01-22 12:00:00",
    "branches": [
      {
        "id": 10,
        "name": "Branch A",
        "type": "main"
      }
    ]
  }
}
```

#### Returned Personal Data (Admin)

* id
* name
* email
* phone
* created_at
* branches (id, name, type)

---

## Resident API

### Resident Login

**POST** `/api/resident/login`

#### Request Body

```json
{
  "phone": "700000000",
  "password": "password123"
}
```

#### Success Response

```json
{
  "success": true,
  "message": "Login successful",
  "token": "ACCESS_TOKEN",
  "token_type": "Bearer",
  "resident": {
    "id": 5,
    "name": "Resident Name",
    "phone": "700000000",
    "is_active": true,
    "branch": {
      "id": 10,
      "name": "Branch A",
      "location": "Aden",
      "is_active": true
    }
  }
}
```

#### Login Rules

Login will fail if:

* The resident account is inactive
* The branch is inactive
* No admin is linked to the branch
* The admin subscription is expired, canceled, or suspended

---

### Resident Logout

**POST** `/api/resident/logout`
**Authentication:** `resident-api`

#### Response

```json
{
  "success": true,
  "message": "Logout successful"
}
```

---

### Resident Profile

**GET** `/api/resident/profile`
**Authentication:** `resident-api`

#### Response

```json
{
  "success": true,
  "resident": {
    "id": 5,
    "name": "Resident Name",
    "phone": "700000000",
    "is_active": true,
    "created_at": "2026-01-22 12:00:00",
    "branch": {
      "id": 10,
      "name": "Branch A",
      "location": "Aden",
      "is_active": true
    },
    "subscription_status": {
      "is_active": true,
      "status": "active",
      "plan_name": "Gold",
      "ends_at": "2026-02-22",
      "days_remaining": 31,
      "on_trial": false
    }
  }
}
```

#### Returned Personal Data (Resident)

* id
* name
* phone
* is_active
* created_at
* branch (id, name, location, is_active)
* subscription_status (status, plan, remaining days)

---

### Resident Branch Info

**GET** `/api/resident/branch`
**Authentication:** `resident-api`

#### Response

```json
{
  "success": true,
  "branch": {
    "id": 10,
    "name": "Branch A",
    "location": "Aden",
    "is_active": true,
    "admins": [
      {
        "id": 1,
        "name": "Admin Name",
        "email": "admin@example.com",
        "phone": "777777777"
      }
    ]
  }
}
```

---

## Routes Overview

### Admin Routes

* POST `/admin/login`
* POST `/admin/logout`
* GET `/admin/profile`
* GET `/admin/branches`
* GET `/admin/orders`

### Resident Routes

* POST `/resident/login`
* POST `/resident/logout`
* GET `/resident/profile`
* GET `/resident/branch`
* GET `/resident/orders`

---

## Important Notes

* Always send the `Authorization` header with Bearer token
* Handle `403 Forbidden` errors and display the message from the API
* Do not assume missing fields; rely only on returned data

---

**End of Documentation**
