# Dashboard de consultas

Para buildar o front end
```
cd appointment-dashboard-app
npm install 
npm run dev
```
Para buildar o back end
```
cd appointment-api
docker compose build
docker compose up ou docker compose up -d
```
Para realizar as migrations 
```
docker exec -it appointmentDashboard-app bash
php artisan migrate
php artisan db:seed
```
Para derrubar a docker 
```
docker compose down
```
