.PHONY: help

help:
	@grep -E '^[a-zA-Z_-]+:.*?## .*$$' $(MAKEFILE_LIST) | sort | awk 'BEGIN {FS = ":.*?## "}; {printf "\033[36m%-30s\033[0m %s\n", $$1, $$2}'

install: ## Project setup
	composer install
	pnpm install

serve: ## Local project run
	symfony serve

reset: ## Reset database
	bin/console postgres:close-connections
	bin/console doctrine:database:drop --force --if-exists
	bin/console doctrine:database:create
	bin/console doctrine:migration:migrate --no-interaction
	bin/console fixtures:load --no-interaction

cs: ## Fix coding style
	bin/ecs --fix

stan: ## Static analysis
	bin/phpstan --memory-limit=1G

test: ## Run all tests
	bin/phpstan --memory-limit=1G
	bin/ecs
	bin/console lint:twig templates