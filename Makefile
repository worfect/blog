d-up:
	docker-compose up -d

d-down:
	docker-compose down

d-build:
	docker-compose up --build -d

d-list:
	docker ps -a

d-exec:
	docker exec -it $(p) bash

cli:
	docker exec -it cli bash

npm-watch:
	docker exec -it node npm run watch

npm-i:
	docker exec -it node npm i $(p)

composer-up:
	docker exec -it cli composer update

cache-clear:
	docker exec -it cli php artisan optimize:clear

m-r-s:
	docker exec -it cli php artisan migrate:refresh --seed

m-r:
	docker exec -it cli php artisan migrate:refresh

psalm:
	docker exec -it cli ./vendor/bin/psalm

lint:
	docker exec -it cli ./vendor/bin/phplint

csfix:
	docker exec -it cli ./vendor/bin/php-cs-fixer --config=.php-cs-fixer.php --allow-risky=yes fix -- --dry-run --diff

test:
	docker exec -it cli php vendor/bin/codecept run
