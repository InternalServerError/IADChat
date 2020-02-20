install:
	@echo 'Build containers'
	docker-compose up -d
	@echo 'Launch composer tasks'
	docker exec -it iadchat_php_1 composer install
	docker exec -it iadchat_php_1 composer dump-autoload -o
	@echo Creating MariaDB schema
	docker exec -i iadchat_maria_1 mysql -piad_admin iad < database.sql
	@echo Open your preferred web browser and navigate to http://localhost

down:
	@echo 'Stopping containers'
	docker-compose down
	@echo 'Deleting images'
	docker rmi -f iadchat_php:latest
	docker rmi -f nginx:latest
	docker rmi -f mariadb:latest
	docker rmi -f php:7.4-fpm-alpine
	rm -f app/composer.lock
