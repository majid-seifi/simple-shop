bash:
	docker exec -it simple_shop_laravel bash
	
composer-install:
	docker exec simple_shop_laravel composer install

yarn-install:
	docker exec simple_shop_laravel yarn install

yarn-dev:
	docker exec simple_shop_laravel yarn dev
	
yarn-build:
	docker exec simple_shop_laravel yarn build

.PHONY: bash composer-install yarn-install yarn-dev yarn-build
