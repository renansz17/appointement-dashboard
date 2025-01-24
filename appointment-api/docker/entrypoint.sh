composer install

echo "Aguardando o banco de dados iniciar..."
until php artisan db:wait; do
  sleep 2
done

php artisan migrate --force

php artisan serve --host=0.0.0.0 --port=8000
