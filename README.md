# Leaderboard

## Important

I've created this project in a windows environment without docker. :( 

When installing front end dependencies you might stumble on issues with lightningcss-win32-x64-msvc. You can remove this if you're working in a mac/linux environment.

(this is also the reason the github actions fail since the runner is in linux)

## Installing

### Clone repository
You can simply clone the project to your local storage with following command:
```
git clone https://github.com/moussa112/leaderboard.git
```
### Setup env file
Copy .env.example into .env and configure database credentials

### Install backend
Navigate to the project's root directory using terminal and run:
```
composer install
```
### Setup encryption key
```
php artisan key:generate
```
### Setup database
Run migration and seeders with initial set of users and some games
```
php artisan migrate --seed
```
### Start local server
```
php artisan serve
```
## Install front end
Navigate to the project's root directory using terminal and run:
```
npm install
```
### Start vite server for Laravel frontend
```
npm run dev
```

## Tests
```
php artisan test
```