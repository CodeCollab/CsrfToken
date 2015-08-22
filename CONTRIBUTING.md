# Contributing

## Feature requests or bug reports

If you would like to see a feature or you have found a bug please open [an issue][issues].

## Contributing code

### Create a pull request

- Submit one pull request per fix or feature
- If your changes are not up to date - rebase your branch on master
- Follow the conventions used in the project

### Unit tests

This project has unit tests for most code. When adding a new feature or when fixing a bug and sending over a PR adding (passing) test(s) is required and will make it easier to merge code.

### Code style

This project uses the following code style conventions / standards:

- [PSR-1: Basic Coding Standard][psr1]
- [PSR-2: Coding Style Guide][psr2]
- [PSR-4: Autoloading Standard][psr4]

Additionally all code needs to be run in strict mode. The strict mode declaration must be on the first line of the file with a single space between the PHP opening tag and `declare()`:

    <?php declare(strict_types=1);

[issues]: https://github.com/CodeCollab/CsrfToken/issues
[psr1]: https://github.com/php-fig/fig-standards/blob/master/accepted/PSR-1-basic-coding-standard.md
[psr2]: https://github.com/php-fig/fig-standards/blob/master/accepted/PSR-2-coding-style-guide.md
[psr4]: https://github.com/php-fig/fig-standards/blob/master/accepted/PSR-4-autoloader.md
