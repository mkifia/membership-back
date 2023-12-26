start:
	symfony server:start -d && docker-compose start
stop:
	symfony server:stop && docker-compose stop
up:
	symfony server:start -d && docker-compose up -d
down:
	symfony server:stop && docker-compose down
log:
	docker-compose logs -f
status:
	symfony server:status && docker-compose ps
