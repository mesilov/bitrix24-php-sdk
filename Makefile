default:
	@echo "make needs target:"
	@egrep -e '^\S+' ./Makefile | grep -v default | sed -r 's/://' | sed -r 's/^/ - /'

lint-phpstan:
	vendor/bin/phpstan --memory-limit=1G analyse
lint-rector:
	vendor/bin/rector process --dry-run
lint-rector-fix:
	vendor/bin/rector process

test-unit:
	vendor/bin/phpunit --testsuite unit_tests --display-warnings

# integration tests with granularity by api-scope
test-integration-scope-telephony:
	vendor/bin/phpunit --testsuite integration_tests_scope_telephony
test-integration-scope-workflows:
	vendor/bin/phpunit --testsuite integration_tests_scope_workflows
test-integration-scope-user:
	vendor/bin/phpunit --testsuite integration_tests_scope_user
test-integration-core:
	vendor/bin/phpunit --testsuite integration_tests_core