all: clean composer lint phploc phpmd phpcs phpcpd phpunit

clean:
	rm -rf vendor

composer:
	/usr/bin/env composer install --no-progress --prefer-source

lint:
	find ./src -name "*.php" -exec /usr/bin/env php -l {} \; | grep "Parse error" > /dev/null && exit 1 || exit 0
	find ./tests -name "*.php" -exec /usr/bin/env php -l {} \; | grep "Parse error" > /dev/null && exit 1 || exit 0

phploc:
	vendor/bin/phploc src

phpmd:
	vendor/bin/phpmd --suffixes php src/ text codesize,design,naming,unusedcode,controversial

phpcs:
	vendor/bin/phpcs --standard=PSR2 --extensions=php src/ tests/

phpcpd:
	vendor/bin/phpcpd src/

test:
	vendor/bin/phpunit -v --colors --coverage-text

standards: phpmd phpcs phpcpd
