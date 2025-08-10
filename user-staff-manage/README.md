# User and Staff Management Service

This service is responsible for managing users who are staff members. It provides CRUD operations for staff users and API routes for login and token verification.

## Features

- **CRUD Operations for Staff Users**:
    - Create, Read, Update, and Delete staff user records.
- **Authentication**:
    - API route for staff login.
    - Token-based authentication and verification.

## API Endpoints

### Staff Management

1. **Create Staff User**
    - **Method**: `POST`
    - **Endpoint**: `/api/staff`
    - **Description**: Creates a new staff user.
    - **Request Body**:
      ```json
      {
        "name": "string",
        "email": "string",
        "password": "string",
        "role": "string"
      }
      ```

2. **Get All Staff Users**
    - **Method**: `GET`
    - **Endpoint**: `/api/staff`
    - **Description**: Retrieves a list of all staff users.

3. **Get Staff User by ID**
    - **Method**: `GET`
    - **Endpoint**: `/api/staff/{id}`
    - **Description**: Retrieves details of a specific staff user by ID.

4. **Update Staff User**
    - **Method**: `PUT`
    - **Endpoint**: `/api/staff/{id}`
    - **Description**: Updates the details of a specific staff user.
    - **Request Body**:
      ```json
      {
        "name": "string",
        "email": "string",
        "role": "string"
      }
      ```

5. **Delete Staff User**
    - **Method**: `DELETE`
    - **Endpoint**: `/api/staff/{id}`
    - **Description**: Deletes a specific staff user by ID.

### Authentication

1. **Login**
    - **Method**: `POST`
    - **Endpoint**: `/api/login`
    - **Description**: Authenticates a staff user and returns a token.
    - **Request Body**:
      ```json
      {
        "email": "string",
        "password": "string"
      }
      ```

2. **Token Verification**
    - **Method**: `POST`
    - **Endpoint**: `/api/token/verify`
    - **Description**: Verifies the validity of a token.
    - **Request Body**:
      ```json
      {
        "token": "string"
      }
      ```

## Installation

1. Clone the repository:
   ```bash
   git clone <repository-url>
   cd <repository-folder>
   ```

2. Install dependencies:
   ```bash
   composer install
   npm install
   ```

3. Set up the environment:
    - Copy `.env.example` to `.env` and configure database and other settings.

4. Run migrations:
   ```bash
   php artisan migrate
   ```

5. Start the development server:
   ```bash
   php artisan serve
   ```

## Usage

- Use the provided API endpoints to manage staff users and handle authentication.
- Ensure the token is included in the `Authorization` header for protected routes.

## License

This project is licensed under the [MIT License](https://opensource.org/licenses/MIT).
