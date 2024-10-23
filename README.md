# Technical Test Altech Omega

## prerequisites
- PHP ^8.2
- Composer 2.*
- Laravel ^10.*
- Mysql
- Swagger (OpenAPI)

## Installation
1. **Clone the Repository:**

    ```bash 
    git clone https://github.com/ahsanreis/TestLamaran_ahsani_afif.git 
    ``` 

2. **Navigate to Project Directory** 
    ```bash 
    cd project-name 
    ```

3. **Copy `.env.example` to `.env`**

4. **Generate Application Key**
    ```bash 
    php artisan key:generate 
    ```

5. **Setup your database in `.env`**
    ```dotenv 
        DB_CONNECTION=mysql
        DB_HOST=127.0.0.1
        DB_PORT=3306
        DB_DATABASE=yourdatabase
        DB_USERNAME=yourusername
        DB_PASSWORD=yourpassword
    ```
6. **Run Database Migrationn**
    ```bash
   php artisan migrate
   ```
7. **Start the development server:**
   ```bash
   php artisan serve
   ```

## Running Tests
To run the tests, use:
```bash
php artisan test
```
Or if you want specific test, use:
```bash
php artisan test --filter yourTestName
```

## Viewing API Documentation
To view API documentation, See it with Swagger (openAPI).
1. **Install OpenAPI**
    If you using VSCODE, install `OpenAPI(Swagger) Editor by 42Crunch`.
2. **Navigate to File**
    API documentation are in file `doc`.
    ```bash 
    cd doc
    ```
3. **(optional) UI Preview**
    Open Command Palette using ```Ctrl + Shift + P``` (VSCODE default) when opening API documentation file.

# Live-code-test
untuk menjalankan live test, dapat menjalankan ```php artisan serve``` dan proses operasi berada pada ```app > Http > COntrollers > operationController.php```
