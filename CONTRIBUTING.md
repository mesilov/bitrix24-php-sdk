# A quick guide to contribute to the project:

## Installing the dev environment

1.  Fork the repo
2.  Clone the repo to local
3.  Install dependencies: `composer update` (this assumes you have 'composer' aliased to wherever your composer.phar lives)
4.  Run the tests. We only take pull requests with passing tests, and it's great to know that you have a clean slate.

## Adding new features

Pull requests with new features needs to be created against master branch. 

If new feature require BC Break please note that in your PR comment, it will added in next major version.
New features that does not have any BC Breaks are going to be added in next minor version.

## Codding standards

In order to fix codding standards please execute: 

```shell
make lint-phpstan
make lint-rector
make lint-rector-fix
```

## Patches and bugfixes 

1. Check the oldest version that patch/bug fix can be applied.
2. Create PR against that version 


## The actual contribution

1.  Make the changes/additions to the code, committing often and making clear what you've done
2.  Make sure you write tests for your code, located in the folder structure 
3.  Run your tests (often and while coding)
4.  Create Pull Request on GitHub to against proper branch
