## Project Setup Guide

To set up the project, follow these steps:

1. Clone the repository:

    ```sh
    git clone <repository-url>
    ```

2. Set the environment file:

    ```sh
    cp .env.example .env
    ```

3. Install PHP dependencies:

    ```sh
    composer install
    ```

4. Install JavaScript dependencies:

    ```sh
    npm install
    ```

5. Build the assets:

    ```sh
    npm run build
    ```

6. Run database migrations:

    ```sh
    php artisan migrate
    ```

7. Seed the database:
    ```sh
    php artisan db:seed
    ```

### Log Credentials

The log credentials are:

-   Username: `test@example.com`
-   Password: `12345678`
