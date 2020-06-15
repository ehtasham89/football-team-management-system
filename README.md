## About Football Team Management System

### Laravel 7 | MySQL | VueJS | VueX | REST API | Bootstrap | JWT

### Docs:

name: Laravel
    
    steps:
    - name: Copy .env
      run: php -r "file_exists('.env') || copy('.env.example', '.env');"
    - name: Install Dependencies
      run: composer install -q --no-ansi --no-interaction --no-scripts --no-progress --prefer-dist
    - name: Generate key
      run: php artisan key:generate
      run: php artisan jwt:secret
    - name: Directory Permissions
      run: chmod -R 777 storage bootstrap/cache
    - name: Set APP_URL 
      env:
        APP_URL: http://127.0.0.0:8000
    - name: Create Database In MySQL
    - name: Set database connection host | user | password | address in .env file
      env:
        DB_CONNECTION: mysql
        DB_HOST: http://localhost
    - name: to start application 
      run: php artisan serve
