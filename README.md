# Appytrack Web Application
Main application on Laravel 5.3 and Angular 1.5

## Table of contents
* [Release notes](#release-notes)
* [Prerequisites](#prerequisites)
* [Get the source code](#get-the-source-code)
* [Deployment on Docker](#deployment-on-docker)
* [Developing](#developing)
* [Tests](#tests)

## Release Notes
Please read the [CHANGELOG](CHANGELOG.md) for details.

## Prerequisites
- Docker >= 17.09
- Docker Compose >= 1.17

## Get the Source Code
Clone the repository:
```bash
git clone git@bitbucket.org:ap/app.git
```

## Deployment on Docker
Create environment file and fill values:
```bash
cp .env.example .env
```

Required values for .env:
```bash
DB_HOST=DB_HOST
REDIS_HOST=REDIS_HOST
```

Create a network for docker services:
```bash
docker network create appytrack
```

Create a volume for docker database service:
```bash
docker volume create --name=appytrack_db_data
```

Run all the docker services:
```bash
docker-compose up -d
```

Open `http://localhost:8081`

## Developing

Watching on styles, js:
```
gulp watch
```

Build the application (compile the scripts, styles, assets):
```
gulp --production
```

## Tests
Run the tests:
```
php phpunit
```