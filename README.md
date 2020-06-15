## About Football Team Management System

### Laravel 7 | MySQL | VueJS | VueX | REST API | Bootstrap | JWT

### Docs:
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
    - name: run database migration and seedings
      env: php artisan migrate
      env: php artisan db:seed --class=Teams
    - name: to start application 
      run: php artisan serve

###Use Case:

1) Register new user (if database connection is configured then it will work)
2) Login with email and password
3) Create new team by clicking on 'Add New Team' button
4) Click on Player List button
5) Add new player by clicking on button
6) Click on un-assign button to remove player from team
7) Click on assign button from un-assigned player list and it will ask for which type of player you want. (player or subtitute player)
8) Click in import player button
9) Select .csv file only and click on upload button. 
10) Go to header menu and click on logout and application session will destroyed on server and client app.

###CSV file formate:

```
name,type,status
jawad,player,1
Nomi,player,1
```

------------------------------- Thank You --------------------------------
