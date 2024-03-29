default:
	@echo "make needs target:"
	@egrep -e '^\S+' ./Makefile | grep -v default | sed -r 's/://' | sed -r 's/^/ - /'

phpstan:
	vendor/bin/phpstan analyse

test-unit:
	vendor/bin/phpunit --testsuite unit_tests