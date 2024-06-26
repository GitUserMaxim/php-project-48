install:
	composer install
validate:
	composer validate
lint:
	composer exec --verbose phpcs -- --standard=PSR12 src bin
beauty:
	composer exec --verbose phpcbf -- --standard=PSR12 src bin
up:
	composer update
test:
	composer exec --verbose phpunit tests