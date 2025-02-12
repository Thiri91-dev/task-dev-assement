

To Set Up the application run the following in the application directory
```
composer install
./vendor/bin/sail up
```
then in a new terminal run
```
docker exec -it <laravel container name> php artisan migrate
docker exec -it <laravel container name> php artisan db:seed
npm install
npm run watch
```

