# Slim-Doctrine-Demo

[![Build Status](https://scrutinizer-ci.com/g/1ma/Slim-Doctrine-Demo/badges/build.png?b=master)](https://scrutinizer-ci.com/g/1ma/Slim-Doctrine-Demo/build-status/master) [![Code Coverage](https://scrutinizer-ci.com/g/1ma/Slim-Doctrine-Demo/badges/coverage.png?b=master)](https://scrutinizer-ci.com/g/1ma/Slim-Doctrine-Demo/?branch=master) [![Scrutinizer Code Quality](https://scrutinizer-ci.com/g/1ma/Slim-Doctrine-Demo/badges/quality-score.png?b=master)](https://scrutinizer-ci.com/g/1ma/Slim-Doctrine-Demo/?branch=master)

A project to demonstrate how to integrate Doctrine into Slim. This is the companion
code for the Cookbook entry [Using Doctrine with Slim] in Slim's documentation.

## Requirements

- PHP 7.3+
- PHP SQLite extension
- [Composer]

## Overview

The Slim-Doctrine-Demo project is a small REST API that allows its clients to
create and retrieve lists of users.

- GET /users    -> Retrieves a list of all users created so far.
- POST /users   -> Creates a new user (does not accept any parameters, fake data is autogenerated).

At its core, Doctrine's `EntityManager` is used to persist and retrieve these
users from an SQLite database.

## Project structure

```
Slim-Doctrine-Demo
├── public
│   └── index.php           -- HTTP front controller (requires ../bootstrap.php)
├── src
│   ├── Action              -- Slim request handlers
│   │   ├── CreateUser.php
│   │   └── ListUsers.php
│   ├── DI
│   │   ├── Doctrine.php    -- EntityManager service definition
│   │   └── Slim.php        -- Slim request handlers service definitions
│   └── Domain              -- Annotated entity classes
│       └── User.php
├── tests/                  -- Automated tests
├── var
│   ├── coverage/           -- Test coverage results in HTML
│   ├── doctrine/           -- Doctrine metadata cache
│   └── database.sqlite     -- Development database
├── bootstrap.php           -- DI container setup (requires ./settings.php)
├── composer.json
├── LICENSE
├── phpunit.xml.dist
├── README.md
├── settings.php            -- Settings currently in use (not committed to Git)
└── settings.php.dist       -- Sample settings file for development (committed to Git)
```

## Running the app

Typing `composer serve` in a console will install the project dependencies, create the database and open
the API at `http://localhost:8000`. Once it is running you can make requests against it with a browser,
curl or similar tools.

```bash
$ curl -s -X POST localhost:8000/users | jq .
{
  "registered_at": "2017-11-11T15:33:56+01:00",
  "username": "Dr. Salvatore Beahan",
  "id": 2
}

$ curl -s -X GET localhost:8000/users | jq .
[
  {
    "registered_at": "2017-11-11T15:32:46+01:00",
    "username": "Lyda Romaguera",
    "id": 1
  },
  {
    "registered_at": "2017-11-11T15:33:56+01:00",
    "username": "Dr. Salvatore Beahan",
    "id": 2
  }
]
```

## Using the Doctrine Command Line Interface

Run `php vendor/bin/doctrine` (this script needs the project dependencies, so run `composer install` first).

## Running the tests

Similarly, typing `composer test` will take care of loading the testing environment and running PHPUnit. If the XDebug exension is enabled code coverage results will be available at `var/coverage/` after running the tests.


[Composer]: https://getcomposer.org/
[Using Doctrine with Slim]: https://www.slimframework.com/docs/v3/cookbook/database-doctrine.html
