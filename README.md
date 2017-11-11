# Slim-Doctrine-Demo

[![Build Status](https://scrutinizer-ci.com/g/1ma/Slim-Doctrine-Demo/badges/build.png?b=master)](https://scrutinizer-ci.com/g/1ma/Slim-Doctrine-Demo/build-status/master) [![Code Coverage](https://scrutinizer-ci.com/g/1ma/Slim-Doctrine-Demo/badges/coverage.png?b=master)](https://scrutinizer-ci.com/g/1ma/Slim-Doctrine-Demo/?branch=master) [![Scrutinizer Code Quality](https://scrutinizer-ci.com/g/1ma/Slim-Doctrine-Demo/badges/quality-score.png?b=master)](https://scrutinizer-ci.com/g/1ma/Slim-Doctrine-Demo/?branch=master)

A project to demonstrate how to integrate Doctrine into Slim.

## Requirements

- PHP 7.1+
- PHP SQLite extension
- [Composer](https://getcomposer.org/)

## Overview

The Slim-Doctrine-Demo project is a small REST API that allows its clients to create and retrieve lists of users.

- GET /users    -> Retrieves a list of all users created so far.
- POST /users   -> Creates a new user.

At its core, Doctrine's `EntityManager` is used to persist and retrieve those users from an SQLite database.

## Project structure

```
Slim-Doctrine-Demo
├── bin
│   └── doctrine            -- Doctrine Command Line Interface
├── bootstrap.php           -- DI container setup (requires ./settings.php)
├── composer.json
├── LICENSE
├── phpunit.xml.dist
├── public
│   └── index.php           -- HTTP front controller (requires ../bootstrap.php)
├── README.md
├── settings.php            -- Settings currently in use (not committed to Git)
├── settings_devel.php      -- Settings for development
├── settings_test.php       -- Settings for running the tests
├── src
│   ├── Action              -- Slim request handlers
│   │   ├── CreateUser.php
│   │   └── ListUsers.php
│   ├── Domain              -- Annotated entity classes go here
│   │   └── User.php
│   └── Provider
│       ├── Doctrine.php    -- EntityManager service definition
│       └── Slim.php        -- Slim service definitions
├── tests                   -- Automated tests
│   ├── Functional
│   │   └── AppTest.php
│   ├── FunctionalTestCase.php
│   └── Unit
│       └── UserTest.php
└── var
    ├── coverage/           -- Test coverage results in HTML
    └── database.sqlite     -- Development database
```

## Running the app

Typing `composer serve` in a console will install the project dependecies, create the database and open
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

The Doctrine CLI tool is in the `bin` directory. Just run `php bin/doctrine` (this script needs the project dependencies to run - `composer install`).

## Running the tests

Similarly, typing `composer test` will take care of loading the testing environment and running PHPUnit. If the XDebug exension is enabled code coverage results will be available at `var/coverage/` after running the tests.
