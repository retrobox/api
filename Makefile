.SILENT:
.PHONY: server serve help test dev
PORT?=8000
HOST?=0.0.0.0

serve: server
dev: server
server:
	php -S $(HOST):$(PORT) -t public
test:
	php ./vendor/bin/phpunit --stop-on-failure tests
