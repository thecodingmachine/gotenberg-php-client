# start workspace.
workspace:
	docker-compose run --rm php bash

# run all linters.
lint:
	docker-compose run --rm -T php composer install
	docker-compose run --rm -T php composer run csfix
	docker-compose run --rm -T php composer run cscheck
	docker-compose run --rm -T php composer run phpstan

# run all tests.
test:
	docker-compose up -d gotenberg
	docker-compose run --rm -T php composer run phpunit
	docker-compose down