# Laravel Project Setup Guide

## Requirements
- Laravel v12
- PHP 8.2

## Installation Steps

1. **Clone the repository**

2. **Install PHP dependencies**
   ```bash
   composer install
   composer dump-autoload
   ```

3. **Install JavaScript dependencies**
   ```bash
   npm install
   npm run build
   ```
   Alternatively, for development mode:
   ```bash
   npm run dev
   ```

4. **Environment Configuration**
   - Copy the `.env.example` file to `.env`
   ```bash
   cp .env.example .env
   ```
   - Configure your database connection in the `.env` file
   - Set the `APP_URL` to your local development URL

5. **Create storage symbolic link**
   ```bash
   php artisan storage:link
   ```

6. **Run database migrations**
   ```bash
   php artisan migrate
   ```

7. **Seed the database**
   ```bash
   php artisan db:seed
   ```

## Login Credentials
- **Email**: test@example.com
- **Password**: password

## Project Structure

### Core Module
The core module (`/core`) contains the foundation of the application with several key components:

- **Models**: Base model classes that extend Laravel's Eloquent models with additional functionality
- **Services**: Service layer implementing the Service Interface pattern
- **Repositories**: Repository pattern implementation for data access
- **Helpers**: Utility traits and helper classes
- **HTTP Controllers**: Base controller classes with common CRUD operations

### Architecture

This project follows a modular architecture with:

1. **Service Layer**: Handles business logic through the `ServiceAbstract` and `ServiceInterface` classes
2. **Repository Pattern**: Manages data access through `RepositoriesAbstract` and `RepositoryInterface`
3. **Base Models**: Extends Laravel's Eloquent with media handling and relationship checks
4. **Controller Abstraction**: Provides common CRUD operations in `ControllerAbstract`

### Key Features

- **Media Handling**: Uses Spatie Media Library for file uploads and management
- **Relationship Checks**: Prevents deletion of models with existing relationships
- **Query Builder Integration**: Uses Spatie Query Builder for advanced filtering
- **Modular Structure**: Organized in modules for better separation of concerns

## Development Guidelines

1. **Creating New Modules**:
   - Follow the existing module structure in the `Modules/` directory
   - Extend the base classes from the core module

2. **Adding New Models**:
   - Extend `BaseModel` from the core module
   - Define `$fillable` properties and relationships
   - Set `$allowedFilters` for query filtering

3. **Implementing Services**:
   - Create a service class that extends `ServiceAbstract`
   - Inject the corresponding repository in the constructor

4. **Creating Controllers**:
   - Extend `ControllerAbstract` for common CRUD operations
   - Define required properties like `$viewsPath`, `$routeName`, etc.

5. **Media Handling**:
   - Define media collections in your controller's `$mediaCollections` property
