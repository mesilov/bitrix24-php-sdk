bitrix24-php-sdk documentation
=============================================

## Authorisation
- use [incoming webhooks](Core/Auth/auth.md).
- use OAuth2.0 for applications.

## List of all supported methods
[All methods list](Services/bitrix24-php-sdk-methods.md), this list build automatically.  

## Application development
If you build application based on bitrix24-php-sdk You can use some domain contracts for interoperability. 
They store in folder `src/Application/Contracts`.

Available contracts
- [Bitrix24Accounts](/src/Application/Contracts/Bitrix24Accounts/Docs/Bitrix24Accounts.md) – store auth tokens and provides methods for work with Bitrix24 account.
- [ApplicationInstallations](/src/Application/Contracts/ApplicationInstallations/Docs/ApplicationInstallations.md) – Store information about application installation, linked with Bitrix24 Account with auth tokens.
- [ContactPersons](/src/Application/Contracts/ContactPersons/Docs/ContactPersons.md) – Store information about person who installed application.
- [Bitrix24Partners](/src/Application/Contracts/Bitrix24Partners/Docs/Bitrix24Partners.md) – Store information about Bitrix24 Partner who supports client portal and install or configure application.