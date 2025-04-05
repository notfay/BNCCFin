### Step 1: Set Up Laravel Project

1. **Install Laravel**: If you haven't already, make sure you have Composer installed. Then, create a new Laravel project:

   ```bash
   composer create-project --prefer-dist laravel/laravel inventory-management
   ```

2. **Navigate to the project directory**:

   ```bash
   cd inventory-management
   ```

3. **Set up the environment**: Copy the `.env.example` file to `.env` and configure your database settings.

   ```bash
   cp .env.example .env
   ```

   Update the `.env` file with your database credentials:

   ```plaintext
   DB_CONNECTION=mysql
   DB_HOST=127.0.0.1
   DB_PORT=3306
   DB_DATABASE=your_database_name
   DB_USERNAME=your_username
   DB_PASSWORD=your_password
   ```

4. **Generate the application key**:

   ```bash
   php artisan key:generate
   ```

### Step 2: Set Up Authentication

1. **Install Laravel Breeze for authentication**:

   ```bash
   composer require laravel/breeze --dev
   ```

2. **Install Breeze**:

   ```bash
   php artisan breeze:install
   ```

3. **Run migrations**:

   ```bash
   php artisan migrate
   ```

4. **Install NPM dependencies and compile assets**:

   ```bash
   npm install && npm run dev
   ```

### Step 3: Create Models and Migrations

1. **Create Product Model and Migration**:

   ```bash
   php artisan make:model Product -m
   ```

   In the migration file located in `database/migrations`, define the schema for the products table:

   ```php
   public function up()
   {
       Schema::create('products', function (Blueprint $table) {
           $table->id();
           $table->string('name');
           $table->text('description')->nullable();
           $table->decimal('price', 8, 2);
           $table->integer('quantity');
           $table->timestamps();
       });
   }
   ```

2. **Create Role Model and Migration**:

   ```bash
   php artisan make:model Role -m
   ```

   In the migration file, define the schema for the roles table:

   ```php
   public function up()
   {
       Schema::create('roles', function (Blueprint $table) {
           $table->id();
           $table->string('name')->unique();
           $table->timestamps();
       });
   }
   ```

3. **Run the migrations**:

   ```bash
   php artisan migrate
   ```

### Step 4: Implement User Roles

1. **Create a RoleController**:

   ```bash
   php artisan make:controller RoleController
   ```

   Implement methods to manage roles (CRUD operations).

2. **Update User Model**: Add a relationship to the Role model in the `User` model.

   ```php
   public function role()
   {
       return $this->belongsTo(Role::class);
   }
   ```

### Step 5: Create CRUD Operations for Admins

1. **Create ProductController**:

   ```bash
   php artisan make:controller ProductController --resource
   ```

   Implement methods for creating, reading, updating, and deleting products.

2. **Define Routes**: In `routes/web.php`, define routes for products and roles.

   ```php
   Route::resource('products', ProductController::class)->middleware('auth');
   Route::resource('roles', RoleController::class)->middleware('auth');
   ```

### Step 6: Product Display for Users

1. **Create Views**: Create Blade views for displaying products. Use Bootstrap for styling.

   Example of a product index view (`resources/views/products/index.blade.php`):

   ```html
   @extends('layouts.app')

   @section('content')
   <div class="container">
       <h1>Products</h1>
       <div class="row">
           @foreach($products as $product)
               <div class="col-md-4">
                   <div class="card">
                       <div class="card-body">
                           <h5 class="card-title">{{ $product->name }}</h5>
                           <p class="card-text">{{ $product->description }}</p>
                           <p class="card-text">${{ $product->price }}</p>
                           <a href="#" class="btn btn-primary">View</a>
                       </div>
                   </div>
               </div>
           @endforeach
       </div>
   </div>
   @endsection
   ```

### Step 7: Invoice Generation

1. **Install a PDF package**: You can use a package like `dompdf` or `snappy` for generating PDFs.

   For example, to install `dompdf`:

   ```bash
   composer require barryvdh/laravel-dompdf
   ```

2. **Create an InvoiceController**:

   ```bash
   php artisan make:controller InvoiceController
   ```

   Implement a method to generate invoices.

3. **Create a view for the invoice** and use the PDF package to generate it.

### Step 8: Finalize and Test

1. **Test your application**: Run the application using:

   ```bash
   php artisan serve
   ```

   Visit `http://localhost:8000` in your browser and test the features.

2. **Add Bootstrap**: Ensure you include Bootstrap in your layout file (`resources/views/layouts/app.blade.php`):

   ```html
   <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
   ```

### Conclusion

This guide provides a basic structure for creating a product inventory management system in Laravel. You can expand upon this by adding features such as user notifications, advanced search, and filtering options, as well as improving the UI/UX with more Bootstrap components.