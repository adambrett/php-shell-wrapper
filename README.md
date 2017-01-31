PHP Shell Wrapper
=================

[![Build Status](https://travis-ci.org/adambrett/php-shell-wrapper.png?branch=master)](https://travis-ci.org/adambrett/php-shell-wrapper)

PHP Shell Wrapper is a high level object oriented wrapper for accessing the [program execution functions](http://php.net/exec) in PHP.

Its primary purpose is to abstract away low level program execution functions in your application, allowing you to mock PHP Shell Wrapper in your tests, making applications which call shell functions easily testable.

Installation
============

Install composer in your project:

```bash
curl -s https://getcomposer.org/installer | php
```

Create a `composer.json` file in your project root:

```json
{
    "require": {
        "adambrett/shell-wrapper": "dev-master"
    }
}
```

Install via composer:

```bash
php composer.phar install
```

Add this line to your application's `index.php` file:

```php
require 'vendor/autoload.php';
```

Basic Usage
===========

Hello World
-----------

Import the required classes into your namespace:

```php
use AdamBrett\ShellWrapper\Command;
use AdamBrett\ShellWrapper\Command\Param;
use AdamBrett\ShellWrapper\Runners\Exec;
```

Instantiate a new shell runner:

```php
$shell = new Exec();
```

Create the command:

```php
$command = new Command('echo');
```

Add some parameters:

```php
$command->addParam(new Param('Hello World'));
```

Now run the command:

```php
$shell->run($command);
```

Which would run the command:

```bash
echo 'Hello World'
```

Command Builder
---------------

Whilst this library is highly object oriented behind the scenes, you may not want to use it that way, what's where the Command Builder comes in.  The command builder constructs a `Command` object behind the scenes, and then constructs the correct class for each method called, so you don't have to worry about it.

The Command Builder also has a fluent interface for extra syntactical sugar. Here's the above example re-written using the Command Builder:

```php
use AdamBrett\ShellWrapper\Runners\Exec;
use AdamBrett\ShellWrapper\Command\Builder as CommandBuilder;

$shell = new Exec();
$command = new CommandBuilder('echo');
$command->addParam('Hello World');
$shell->run($command);
```

And here's a slightly less trivial example:

```php
use AdamBrett\ShellWrapper\Runners\Exec;
use AdamBrett\ShellWrapper\Command\Builder as CommandBuilder;

$shell = new Exec();
$command = new CommandBuilder('phpunit');
$command->addFlag('v')
    ->addArgument('stop-on-failure')
    ->addArgument('configuration', '~/phpunit.xml')
    ->addParam('~/tests/TestCase.php');
$shell->run($command);
```

Which would run:

```bash
phpunit -v --stop-on-failure --configuration '~/phpunit.xml' '~/tests/TestCase.php'
```

and another:

```php
use AdamBrett\ShellWrapper\Runners\Exec;
use AdamBrett\ShellWrapper\Command\Builder as CommandBuilder;

$shell = new Exec();
$command = new CommandBuilder('/usr/bin/jekyll');
$command->addSubCommand('serve')
    ->addArgument('watch');
$shell->run($command);
```

Which would run:

```bash
/usr/bin/jekyll serve --watch
```

Runners
-------

Runners are paths directly in to the PHP [program execution functions](http://php.net/exec), and map to them by name exactly.  Runners should all implement `\AdamBrett\ShellWrapper\Runners\Runner`, which means you can type hint on that whenever you need to use a shell and they should then all be interchangeable.

Some runners will also implement `\AdamBrett\ShellWrapper\Runners\ReturnValue`, but only where that is appropriate to the low level function.

Some runners (marked *) only emulate command running. This feature useful for testing.

Runner    | Returns               | Flush | getOutput | getReturnValue
----------|-----------------------|-------|-----------|---------------
Exec      | Last Line             |       | x         | x
Passthru  |                       | x     |           | x
ShellExec | Full Output or `null` |       |           |
System    | Last Line or `false`  | x     |           | x
Dry*      | Exit code             |       | x         | x
Fake*     | Exit code             |       | x         | x

Use `FakeRunner` into unit tests for emulate command running. 
Use `DryRunner` when your application gets --dry-run argument and there is need to only print the command 

SubCommands
-----------

### Usage

```php
use AdamBrett\ShellWrapper\Command\SubCommand;

$shell->addSubCommand(new SubCommand($subCommand));
```

Sub commands will not be escaped or modified in anyway, they are intended for use like so:

```php
use AdamBrett\ShellWrapper\Command\Command;
use AdamBrett\ShellWrapper\Command\SubCommand;

$command = new Command('jekyll')
$shell->addSubCommand(new SubCommand('build'));
```

Which would run the command `jekyll build`.

Arguments
---------

### Usage

```php
use AdamBrett\ShellWrapper\Command\Argument;

$shell->addArgument(new Argument($name, $value));
```

`$value` will be automatically escaped behind the scenes, but `$name` will not, so make sure you never have user input in `$name`, or if you do, escape it yourself.

If you want multiple arguments of the same name, then `$value` can be an array, like so:

```php
use AdamBrett\ShellWrapper\Command\Argument;

$shell->addArgument(new Argument('exclude', ['.git*', 'cache'])); 
```

Which would result in the following:

```bash
somecommand --exclude '.git*' --exclude 'cache'
```

Flags
-----

### Usage

```php
use AdamBrett\ShellWrapper\Command\Flag;

$shell->addFlag(new Flag($flag));
```

`$flag` will not be escaped, but can be a string rather than a single character, so `new Flag('lla')` is perfectly valid.

Params
------

### Usage

```php
use AdamBrett\ShellWrapper\Command\Param;

$shell->addParam(new Param($param));
```

`$param` will be automatically escaped behind the scenes, but will otherwise be un-altered.


Requirements
============

  * PHP >=5.4

Contributing
============

Pull Requests
-------------

  1. Fork the php-shell-wrapper repository
  2. Create a new branch for each feature or improvement
  3. Send a pull request from each feature branch to the **develop** branch

Style Guide
-----------

This package is compliant with [PSR-0][], [PSR-1][], and [PSR-2][]. If you
notice compliance oversights, please send a patch via pull request.

[PSR-0]: https://github.com/php-fig/fig-standards/blob/master/accepted/PSR-0.md
[PSR-1]: https://github.com/php-fig/fig-standards/blob/master/accepted/PSR-1-basic-coding-standard.md
[PSR-2]: https://github.com/php-fig/fig-standards/blob/master/accepted/PSR-2-coding-style-guide.md

Tests
-----

The library is developed using test driven development.  All pull requests should be accompanied by passing unit tests with 100% coverage.  [phpunit][] is used for testing and [mockery][] is used for mocks.  [faker][] is available as a random data generator if required.

[phpunit]: http://phpunit.de/manual/current/en/index.html
[mockery]: https://github.com/padraic/mockery
[faker]: https://github.com/fzaninotto/Faker

Creating Builds
---------------

Some build tools are included via composer if required, you can run them using .  `./vendor/bin/phing` from the root of the project.  The output will be stored in `./build` and will include code coverage and code browser output.  Inspect the contents of `build.xml` to see what's happening underneath.

Authors
=======

Adam Brett - http://twitter.com/sixdaysad - http://adamcod.es

License
=======

php-shell-wrapper is licensed under the BSD-3-Clause License - see the LICENSE file for details
