.PHONY: upd
upd:
	docker-compose up -d --build

.PHONY: down
down:
	docker-compose down

.PHONY: ssh
ssh:
	docker-compose exec php /bin/sh
