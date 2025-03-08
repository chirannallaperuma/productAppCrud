# Product Crud Filament App

This is a Product Crud Filament App that includes SQLite, Livewire, and Filament. It supports product management with tables for product colors, categories, products, and types. The project also includes seeded data and a custom theme.

## Features

- Laravel 12 with SQLite
- Livewire integration
- Filament for admin panel
- Product management with colors, categories, and types
- Seeded data for initial setup
- Custom themes for styling

## Installation

Follow the steps below to set up the project on your local machine:

### Prerequisites

- PHP (>=8.1)
- Composer
- Node.js & NPM (for frontend assets)

### Setup Instructions

1. **Clone the Repository**  
    git clone https://github.com/chirannallaperuma/productAppCrud
    cd <project-folder>

2. **Install Dependencies**  
    composer install
    npm install

3. **Environment Setup**  
    cp .env.example .env

4. **Run Migrations and Seeders**
    php artisan migrate --seed

5. **Start Development Server**
    php artisan serve

5. **login to the system**
    email: chirannad@gmail.com
    password: 12345678


