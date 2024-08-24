# How to build bitrix24-php-sdk

## How to rebuild documentation

Use cli-command

```shell
make build-documentation
```

## How to add new scope

1. Add new scope in scope enum `src/Core/Credentials/Scope.php`.
2. Add new scope folder in `src/Services/` folder and add services.
3. Add new integration tests in mirror scope folder in `tests/Integration/Services`.
4. Add new scope support in phpunit `phpunit.xml.dist` testsuite list
5. Add new scope support in `Makefile`