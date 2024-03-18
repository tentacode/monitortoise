.PHONY: help

help:
	@grep -E '^[a-zA-Z_-]+:.*?## .*$$' $(MAKEFILE_LIST) | sort | awk 'BEGIN {FS = ":.*?## "}; {printf "\033[36m%-30s\033[0m %s\n", $$1, $$2}'

install: ## Project setup
	composer install
	pnpm install
	pnpm run dev

watch: ## Watch assets
	pnpm run watch

serve: ## Local project run
	symfony serve -d

reset: ## Reset database
	bin/console postgres:close-connections
	bin/console doctrine:database:drop --force --if-exists
	bin/console doctrine:database:create
	bin/console doctrine:migration:migrate --no-interaction
	bin/console doctrine:fixture:load --append

reset-test: ## Reset test database
	bin/console postgres:close-connections --env=test
	bin/console doctrine:database:drop --force --if-exists --env=test
	bin/console doctrine:database:create --env=test
	bin/console doctrine:migration:migrate --no-interaction --env=test
	bin/console doctrine:fixture:load --append --env=test

cs: ## Fix coding style
	bin/ecs --fix

stan: ## Static analysis
	bin/phpstan --memory-limit=1G

e2e: ## Run end-to-end tests
	pnpm exec cypress open

unit: ## Run unit tests
	bin/phpunit --testdox

test: ## Run all tests
	bin/phpstan --memory-limit=1G
	bin/phpunit --testdox
	bin/console lint:twig templates
	bin/ecs

provision-server: ## Provision server
	ansible-playbook -i ansible/hosts ansible/provision-server.yml --extra-vars="@ansible/monitortoise-vars.yml"

deploy: ## Deploy main to server
	ansible-playbook -i ansible/hosts ansible/deploy.yml --extra-vars="@ansible/monitortoise-vars.yml"