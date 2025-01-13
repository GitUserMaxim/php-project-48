install:
	composer install
validate:
	composer validate
lint:
	composer exec --verbose phpcs -- --standard=PSR12 --colors src bin tests
beauty:
	composer exec --verbose phpcbf -- --standard=PSR12 src bin tests
up:
	composer update
test:
	XDEBUG_MODE=coverage composer exec --verbose phpunit tests
test-coverage:
	XDEBUG_MODE=coverage composer exec --verbose phpunit tests -- --coverage-clover build/logs/clover.xml
test-coverage-html:
	XDEBUG_MODE=coverage composer exec --verbose phpunit tests -- --coverage-html build/coverage/html
shit:
	vendor/bin/phpstan analyse --level 5 src