.SILENT:
.DEFAULT_GOAL: install

install:
	composer install --ignore-platform-reqs

format:
	vendor/bin/phpcs

format-fix:
	vendor/bin/phpcbf

analyse:
	vendor/bin/phpinsights analyse -n

test:
	XDEBUG_MODE=coverage vendor/bin/phpunit --testdox

coverage:
	XDEBUG_MODE=coverage vendor/bin/phpunit --coverage-text
