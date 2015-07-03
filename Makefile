clean:
		rm -f composer.phar
		rm -rf vendor

install:
		curl -sS https://getcomposer.org/installer | php
		./composer.phar install

test:
		./vendor/bin/phpunit
