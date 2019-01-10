## Roles

By default, all users are locked out from accessing anything in the system. Roles gives users permission to access certain parts of the system based on URL rules.

## Install

```
composer install cradlephp/cradle-role
bin/cradle cradlephp/cradle-role install
bin/cradle cradlephp/cradle-role sql-populate
```

## Updating to 0.1.* From 0.0.1

```
composer update
cradle cradlephp/cradle-role update
bin/cradle cradlephp/cradle-role sql-populate
```

----

<a name="contributing"></a>
# Contributing to Cradle PHP

Thank you for considering to contribute to Cradle PHP.

Please DO NOT create issues in this repository. The official issue tracker is located @ https://github.com/CradlePHP/cradle/issues . Any issues created here will *most likely* be ignored.

Please be aware that master branch contains all edge releases of the current version. Please check the version you are working with and find the corresponding branch. For example `v1.1.1` can be in the `1.1` branch.

Bug fixes will be reviewed as soon as possible. Minor features will also be considered, but give me time to review it and get back to you. Major features will **only** be considered on the `master` branch.

1. Fork the Repository.
2. Fire up your local terminal and switch to the version you would like to
contribute to.
3. Make your changes.
4. Always make sure to sign-off (-s) on all commits made (git commit -s -m "Commit message")

## Making pull requests

1. Please ensure to run [phpunit](https://phpunit.de/) and
[phpcs](https://github.com/squizlabs/PHP_CodeSniffer) before making a pull request.
2. Push your code to your remote forked version.
3. Go back to your forked version on GitHub and submit a pull request.
4. All pull requests will be passed to [Travis CI](https://travis-ci.org/CradlePHP/cradle-profile) to be tested. Also note that [Coveralls](https://coveralls.io/github/CradlePHP/cradle-profile) is also used to analyze the coverage of your contribution.
