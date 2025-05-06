# PHP API Project

## Overview
This project is a simple PHP API that demonstrates the use of controllers and models to handle CRUD operations for multiple resources. It is structured to provide a clear separation of concerns, making it easy to maintain and extend.

## Project Structure
```
php-api-project
├── controllers
│   ├── Controller1.php
│   ├── Controller2.php
│   ├── Controller3.php
│   └── Controller4.php
├── models
│   ├── Model1.php
│   ├── Model2.php
│   ├── Model3.php
│   └── Model4.php
├── database
│   └── db_connection.php
├── index.php
└── README.md
```

## Setup Instructions
1. Clone the repository:
   ```
   git clone <repository-url>
   ```
2. Navigate to the project directory:
   ```
   cd php-api-project
   ```
3. Configure the database connection in `database/db_connection.php` with your database credentials.

4. Start a local server (e.g., using PHP's built-in server):
   ```
   php -S localhost:8000
   ```

## Usage
- Access the API endpoints through your browser or a tool like Postman.
- The API supports the following operations for each resource:
  - **Create**: POST request to `/resource`
  - **Read**: GET request to `/resource` or `/resource/{id}`
  - **Update**: PUT request to `/resource/{id}`
  - **Delete**: DELETE request to `/resource/{id}`

## API Endpoints
- `/resource1` - Handled by `Controller1`
- `/resource2` - Handled by `Controller2`
- `/resource3` - Handled by `Controller3`
- `/resource4` - Handled by `Controller4`

## Contributing
Feel free to submit issues or pull requests for improvements or bug fixes.

## License
This project is licensed under the MIT License.