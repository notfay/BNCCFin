# BNCCFin API Documentation

## Overview
This Laravel application has full CRUD operations for Products, Categories, and Invoices accessible via REST API.

## API Base URL
```
http://localhost:8000/api/v1
```

## Available Endpoints

### Categories
- `GET /categories` - Get all categories
- `GET /categories/{id}` - Get single category
- `POST /categories` - Create new category
- `PUT /categories/{id}` - Update category
- `DELETE /categories/{id}` - Delete category

### Products
- `GET /products` - Get all products
- `GET /products/{id}` - Get single product
- `POST /products` - Create new product
- `PUT /products/{id}` - Update product
- `DELETE /products/{id}` - Delete product

### Invoices
- `GET /invoices` - Get all invoices
- `GET /invoices/{id}` - Get single invoice

---

## Testing with Postman

### Option 1: Import Collection
1. Open Postman
2. Click **Import**
3. Select `BNCCFin_API.postman_collection.json`
4. All endpoints will be ready to test

### Option 2: Manual Testing

#### 1. Create Category
**POST** `http://localhost:8000/api/v1/categories`

Headers:
```
Content-Type: application/json
```

Body (raw JSON):
```json
{
  "name": "Electronics"
}
```

#### 2. Get All Categories
**GET** `http://localhost:8000/api/v1/categories`

#### 3. Create Product
**POST** `http://localhost:8000/api/v1/products`

Headers:
```
Content-Type: application/json
```

Body (raw JSON):
```json
{
  "category_id": 1,
  "name": "Laptop Dell XPS 15",
  "price": 25000000,
  "quantity": 10,
  "image": "laptop.jpg"
}
```

#### 4. Get All Products
**GET** `http://localhost:8000/api/v1/products`

#### 5. Update Product
**PUT** `http://localhost:8000/api/v1/products/1`

Headers:
```
Content-Type: application/json
```

Body (raw JSON):
```json
{
  "name": "Updated Laptop",
  "price": 26000000,
  "quantity": 15
}
```

#### 6. Delete Product
**DELETE** `http://localhost:8000/api/v1/products/1`

---

## Response Format

### Success Response
```json
{
  "success": true,
  "message": "Operation successful",
  "data": { }
}
```

### Error Response
```json
{
  "success": false,
  "message": "Error message",
  "errors": { }
}
```

---

## Validation Rules

### Category
- `name`: required, string, 3-50 characters, unique

### Product
- `category_id`: required, must exist in categories
- `name`: required, string, 5-80 characters
- `price`: required, integer, minimum 1
- `quantity`: required, integer, minimum 0
- `image`: optional, string

---

## Running the Server

See the main instructions below for how to start the Laravel server.
