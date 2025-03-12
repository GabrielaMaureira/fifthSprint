# Nombre del proyecto (puedes cambiarlo si quieres)
PROJECT_NAME=dicesgame

# Container aliases
CONTAINER_APP=laravel-app

# Build Docker image without cache
build:
	docker-compose build --no-cache

# Bring up containers in detached mode (-d)
up:
	docker-compose up -d

# Stop containers without removing them
stop:
	docker-compose stop

# Resume stopped containers
start:
	docker-compose start

# Stop and remove containers + volumes
down:
	docker-compose down -v

# Restart containers
restart: down up

# Access the Laravel container terminal
shell:
	docker exec -it $(CONTAINER_APP) sh
