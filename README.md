# Devops_project

This will contain a description of how to install and use the system

## About the project

// Todo
Make a description of why the system has been developed

## Built with

* [Symfony](https://symfony.com)
* [EasyAdmin](https://github.com/EasyCorp/EasyAdminBundle)

## Getting started

To get a local copy up and running follow these steps.

### Prerequisites

* [Docker](https://docs.docker.com/install/)
* [Docker Compose](https://docs.docker.com/compose/install/)

### Installation

1. Clone the repo

   ```shell
   git clone git@github.com:Thomann1992/devops_project.git devops_projekt
   ```

2. Enter the newly created project directory

   ```shell
   cd devops_projekt
   ```

3. Start docker containers

   ```shell
   docker-compose up -d
   ```

4. Run database migrations

   ```sh
   docker-compose exec phpfpm bin/console doctrine:migrations:migrate --no-interaction
   ```

5. Load fixtures

   ```sh
   php bin/console hautelook:fixtures:load
   ```

You should now be able to browse to the application

```sh
symfony server:start -d
```

## Admin user

A user with admin permissions gets created when fixtures are run.
It's credentials are:\
Username: admin@admin.com\
Password: 123123

## Coding standards

Check the coding standards with:

```sh
docker-compose exec phpfpm composer check-coding-standards
```

Apply coding standards to php-files:

```sh
docker-compose exec phpfpm composer apply-coding-standards
```

Check markdown docs:

```sh
yarn coding-standards-check/markdownlint
```

Apply coding standards to docs:

```sh
yarn coding-standards-apply/markdownlint
```

## Code analysis

Analyse code with the following commands:

With phpstan:

```sh
docker-compose exec phpfpm composer code-analysis/phpstan
```

with psalm:

```sh
docker-compose exec phpfpm composer code-analysis/psalm
```

with both:

```sh
docker-compose exec phpfpm composer code-analysis
```
