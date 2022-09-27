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
A user with admin permissions gets created when fixtures are run. It's credentials are:  
Username: admin@admin.com  
Password: 123123

## Coding standards
To test that the code follows the coding standards decided upon for this project the following command can be used
```sh
docker-compose exec phpfpm composer apply-coding-standards;
```