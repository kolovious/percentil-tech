LOCAL_UID := $(shell id -u)
LOCAL_GID := $(shell id -g)

.PHONY: build install up down shell fix-perms phpv composerv npm-install front-build front-dev front-test

build:
	LOCAL_UID=$(LOCAL_UID) LOCAL_GID=$(LOCAL_GID) docker compose build app

install:
	docker compose run --rm app composer install

up:
	docker compose up

down:
	docker compose down --remove-orphans

shell:
	docker compose exec app sh

fix-perms:
	sudo chown -R $(LOCAL_UID):$(LOCAL_GID) .

phpv:
	docker compose run --rm app php -v

composerv:
	docker compose run --rm app composer --version

npm-install:
	LOCAL_UID=$(LOCAL_UID) LOCAL_GID=$(LOCAL_GID) docker compose run --rm node npm install

front-build:
	LOCAL_UID=$(LOCAL_UID) LOCAL_GID=$(LOCAL_GID) docker compose run --rm node npm run build

front-dev:
	LOCAL_UID=$(LOCAL_UID) LOCAL_GID=$(LOCAL_GID) docker compose run --rm node npm run dev

front-test:
	LOCAL_UID=$(LOCAL_UID) LOCAL_GID=$(LOCAL_GID) docker compose run --rm node npm run test:unit
