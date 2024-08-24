default:
	@echo "make needs target:"
	@egrep -e '^\S+' ./Makefile | grep -v default | sed -r 's/://' | sed -r 's/^/ - /'

# load default and personal env-variables
ENV := $(PWD)/tests/.env
ENV_LOCAL := $(PWD)/tests/.env.local
include $(ENV)
include $(ENV_LOCAL)

debug-show-env:
	@echo BITRIX24_WEBHOOK $(BITRIX24_WEBHOOK)
	@echo DOCUMENTATION_DEFAULT_TARGET_BRANCH $(DOCUMENTATION_DEFAULT_TARGET_BRANCH)

# build documentation
build-documentation:
	php bin/console b24:util:generate-coverage-documentation --webhook=$(BITRIX24_WEBHOOK) --repository-url=https://github.com/mesilov/bitrix24-php-sdk --repository-branch=$(DOCUMENTATION_DEFAULT_TARGET_BRANCH) --file=docs/EN/Services/bitrix24-php-sdk-methods.md

# linters
lint-phpstan:
	vendor/bin/phpstan --memory-limit=1G analyse
lint-rector:
	vendor/bin/rector process --dry-run
lint-rector-fix:
	vendor/bin/rector process

# unit tests
test-unit:
	vendor/bin/phpunit --testsuite unit_tests --display-warnings

# integration tests with granularity by api-scope
test-integration-scope-telephony:
	vendor/bin/phpunit --testsuite integration_tests_scope_telephony
test-integration-scope-workflows:
	vendor/bin/phpunit --testsuite integration_tests_scope_workflows
test-integration-scope-im:
	vendor/bin/phpunit --testsuite integration_tests_scope_im
test-integration-scope-placement:
	vendor/bin/phpunit --testsuite integration_tests_scope_placement
test-integration-scope-im-open-lines:
	vendor/bin/phpunit --testsuite integration_tests_scope_im_open_lines
test-integration-scope-user:
	vendor/bin/phpunit --testsuite integration_tests_scope_user
test-integration-scope-user-consent:
	vendor/bin/phpunit --testsuite integration_tests_scope_user_consent
test-integration-core:
	vendor/bin/phpunit --testsuite integration_tests_core