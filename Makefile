# Define environment variables
DB_CONTAINER=questionnaire_db
APP_CONTAINER=questionnaire_app
ENV_FILE=.env

include $(ENV_FILE)
export $(shell sed 's/=.*//' $(ENV_FILE))

# Default target
.PHONY: help
help:
	@echo "Available commands:"
	@echo "  make setup            - Setup the application (builds and starts containers, initializes the database)"
	@echo "  make start            - Start the application"
	@echo "  make stop             - Stop the application"
	@echo "  make restart          - Restart the application"
	@echo "  make destroy          - Stop and remove all containers and volumes"
	@echo "  make logs             - View application logs"
	@echo "  make db-shell         - Access the MySQL database shell"
	@echo "  make app-shell        - Access the PHP container shell"
	@echo "  make migrate          - Run database migrations"
	@echo "  make migrate-rollback - Rollback the last migration"
	@echo "  make migrate-create   - Create a new migration (Usage: make migrate-create name=MigrationName)"
	@echo "  make db-dump          - Export the database to a SQL file"
	@echo "  make db-import        - Import a database dump (Usage: make db-import file=backup.sql)"
	@echo "  make build            - Build the application"
	@echo "  make clean            - Clean up Docker resources"
	@echo "  make test             - Run all PHPUnit tests"
	@echo "  make test-file        - Run a specific PHPUnit test file (Usage: make test-file file=tests/app/ExampleTest.php)"
	@echo "  make test-filter      - Run a specific test method (Usage: make test-filter filter=testMethodName)"
	@echo "  make test-coverage    - Run tests with coverage reporting"

# Setup the application
.PHONY: setup
setup:
	@if [ ! -f $(ENV_FILE) ]; then cp env .env; fi
	docker-compose down --volumes
	docker-compose up --build -d

# Start the application
.PHONY: start
start:
	docker-compose up -d

# Stop the application
.PHONY: stop
stop:
	docker-compose down

# Restart the application
.PHONY: restart
restart:
	docker-compose down
	docker-compose up -d

# Destroy containers and volumes
.PHONY: destroy
destroy:
	docker-compose down --volumes --remove-orphans

# View application logs
.PHONY: logs
logs:
	docker-compose logs -f

# Access the MySQL database shell
.PHONY: db-shell
db-shell:
	@docker exec -it $(DB_CONTAINER) mysql -u$(DB_USER) -p$(DB_PASS) $(DB_NAME)

# Access the PHP application shell
.PHONY: app-shell
app-shell:
	docker exec -it $(APP_CONTAINER) sh

# Run database migrations
.PHONY: migrate
migrate:
	docker exec -it $(APP_CONTAINER) php spark migrate

# Rollback database migrations
.PHONY: migrate-rollback
migrate-rollback:
	docker exec -it $(APP_CONTAINER) php spark migrate:rollback

# Create a new migration
.PHONY: migrate-create
migrate-create:
	docker exec -it $(APP_CONTAINER) php spark migrate:create $(name)

# Export database dump
.PHONY: db-dump
db-dump:
	docker exec -it $(DB_CONTAINER) mysqldump -u$(DB_USER) -p$(DB_PASS) $(DB_NAME) > backup.sql

# Import database dump
.PHONY: db-import
db-import:
	docker exec -i $(DB_CONTAINER) mysql -u$(DB_USER) -p$(DB_PASS) $(DB_NAME) < $(file)

# Build the application
.PHONY: build
build:
	docker-compose build

# Clean up Docker resources
.PHONY: clean
clean:
	docker system prune -f

# Run all tests
.PHONY: test
test:
	docker exec -it $(APP_CONTAINER) php vendor/bin/phpunit --testdox

# Run a specific test file (Usage: make test-file file=tests/app/ExampleTest.php)
.PHONY: test-file
test-file:
	docker exec -it $(APP_CONTAINER) php vendor/bin/phpunit --testdox $(file)

# Run a specific test by method name (Usage: make test-filter filter=testMethodName)
.PHONY: test-filter
test-filter:
	docker exec -it $(APP_CONTAINER) php vendor/bin/phpunit --testdox --filter $(filter)

# Run tests with code coverage
.PHONY: test-coverage
test-coverage:
	docker exec -it $(APP_CONTAINER) php vendor/bin/phpunit --coverage-text