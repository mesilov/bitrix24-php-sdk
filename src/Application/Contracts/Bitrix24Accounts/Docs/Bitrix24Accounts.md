# Bitrix24 account entity

| Method                        | Return Type             | Description                                                 | Throws                   |
|-------------------------------|-------------------------|-------------------------------------------------------------|--------------------------|
| ` getId()                   ` | `Uuid                 ` | Returns the unique account ID.                              | -                        |
| ` getBitrix24UserId()       ` | `int                  ` | Returns the Bitrix24 user ID who installed the application. | -                        |
| ` isBitrix24UserAdmin()     ` | `bool                 ` | Checks if the Bitrix24 user has admin rights.               | -                        |
| ` getMemberId()             ` | `string               ` | Returns the unique portal ID.                               | -                        |
| ` getDomainUrl()            ` | `string               ` | Returns the portal domain URL.                              | -                        |
| ` getStatus()               ` | `Bitrix24AccountStatus` | Returns the account status.                                 | -                        |
| ` getAuthToken()            ` | `AuthToken            ` | Returns the authentication token.                           | -                        |
| ` renewAuthToken()          ` | `void                 ` | Renews the authentication token.                            | -                        |
| ` getApplicationVersion()   ` | `int                  ` | Returns the application version.                            | -                        |
| ` getApplicationScope()     ` | `Scope                ` | Returns the application scope (permissions).                | -                        |
| ` changeDomainUrl()         ` | `void                 ` | Changes the domain URL after a portal rename.               | -                        |
| ` applicationInstalled()    ` | `void                 ` | Sets the account status to "active".                        | InvalidArgumentException |
| ` applicationUninstalled()  ` | `void                 ` | Sets the account status to "deleted".                       | InvalidArgumentException |
| ` isApplicationTokenValid() ` | `bool                 ` | Checks if the provided application token is valid.          | -                        |
| ` getCreatedAt()            ` | `CarbonImmutable      ` | Returns the account creation date and time.                 | -                        |
| ` getUpdatedAt()            ` | `CarbonImmutable      ` | Returns the last account update date and time.              | -                        |
| ` updateApplicationVersion()` | `void                 ` | Updates the application version.                            | InvalidArgumentException |
| ` markAsActive()            ` | `void                 ` | Changes the account status to active.                       | InvalidArgumentException |
| ` markAsBlocked()           ` | `void                 ` | Changes the account status to blocked.                      | InvalidArgumentException |
| ` getComment()              ` | `?string              ` | Returns the comment for this account.                       | -                        |


## Bitrix24 account state diagram

```mermaid
stateDiagram-v2
    [*] --> New: New account when\ninstallation started
    New --> Active : Installation completed successfully
    New --> Blocked : Installation aborted 
    Active --> Blocked : Connection lost or\nforcibly deactivated
    Active --> Deleted : Application\n uninstalled
    Blocked --> Active : Reconnected or\nreactivated
    Blocked --> Deleted : Delete blocked account 
    Deleted --> [*]: Account can be removed\n from persistence storage
```

## Repository methods

- `save(Bitrix24AccountInterface $bitrix24Account): void`
    - use case Activate
    - use case Block
    - use case ChangeDomainUrl
    - use case InstallStart
    - use case InstallFinish
    - use case RenewAuthToken
    - use case Uninstall
    - use case UpdateVersion
- `getById(Uuid $uuid): Bitrix24AccountInterface`
    - use case Activate
    - use case Block
- `delete(Uuid $uuid)`
    - use case Uninstall
- `findByMemberId(string $memberId, ?Bitrix24AccountStatus $status = null, ?bool $isAdmin = null): array`
    - use case InstallStart
    - use case InstallFinish
    - use case RenewAuthToken
    - use case Uninstall
    - use case UpdateVersion (what about multiple accounts???)
- `findByDomain(string $domainUrl, ?Bitrix24AccountStatus $status = null, ?bool $isAdmin = null): array`
    - use case ChangeDomainUrl
- `findOneAdminByMemberId(string $memberId): ?Bitrix24AccountInterface`  
