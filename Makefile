# New docker-compose binary check
ifeq (, $(shell which docker-compose))
	DOCKER_COMPOSE_EXECUTABLE=@docker compose
else
	DOCKER_COMPOSE_EXECUTABLE=@docker-compose
endif

DOCKER_COMPOSE   = $(DOCKER_COMPOSE_EXECUTABLE) -f docker-compose.yml
EXEC_PHP         = $(DOCKER_COMPOSE) exec php
SYMFONY          = $(EXEC_PHP) bin/console
COMPOSER         = $(EXEC_PHP) php -d memory_limit=-1 /usr/local/bin/composer
EXEC_JS          = $(DOCKER_COMPOSE) run --rm nodejs 
YARN             = $(DOCKER_COMPOSE) run --rm nodejs yarn

APP_ENV?=dev


Project:

## Build the project's docker-compose images. Pull them if needed
build:
	$(DOCKER_COMPOSE) pull --quiet --ignore-pull-failures
	$(DOCKER_COMPOSE) build --pull

## Kill the project's live containers and remove the docker network
kill:
	$(DOCKER_COMPOSE) kill || true
	$(DOCKER_COMPOSE) down --volumes --remove-orphans

## Install and start the project
install: build start vendor assets


## Stop and start a fresh install of the project
reset: kill install

## Start the project
start:
	$(DOCKER_COMPOSE) up -d --remove-orphans

## Stop the project
stop:
	$(DOCKER_COMPOSE) stop

## Stop the project and remove generated files
clean: kill
	rm -rf vendor node_modules


# rules based on files
composer.lock: ./app/composer.json

## Install the Symfony project PHP vendors
vendor: ./app/composer.lock
	$(COMPOSER) install --classmap-authoritative --prefer-dist --no-progress --no-scripts --no-interaction

dump-autoload:
	$(COMPOSER) dump-autoload
## Install the Symfony project Node vendors
node_modules: ./app/yarn.lock
	$(YARN) install
	@touch -c node_modules

yarn.lock: ./app/package.json
	$(YARN) install


#################################
Cache:

## Symfony cache clear
cache-clear:
	@$(eval APP_ENV ?=)
	@$(SYMFONY) cache:clear --no-warmup --env=$(APP_ENV)

## Symfony cache clear
cache-warmup:
	@$(eval APP_ENV ?=)
	@$(SYMFONY) cache:warmup --env=$(APP_ENV)


#################################
Assets:

## Run Webpack Encore to compile assets
assets: ./app/node_modules
	$(YARN) run dev || true

## Run Webpack Encore in watch mode
watch: ./app/node_modules
	$(YARN) run watch
