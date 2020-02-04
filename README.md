Sample Yii2 / Active Record ORM application talking to two separate databases.

Source entity defines `user_details` table for Source database, and Destination entity defines `customer_details` table for Destination database.

## Running app

First of all copy `.env.dist` to `.env`, there is no need to update anything here.
Secondly add a `yii2.local` to your `/etc/hosts`, pointing to `127.0.0.1`.

### To start Docker containers type:

```bash
docker-compose up -d
```

This will create all needed containers.

### Composer

Next you need to run `composer` to get all needed packages.

```bash
composer install
```

## CLI commands

App was designed only as a CLI client, but still has some default HTTP frontend.

All commands can be executed through composer, or through the Yii console.

### Migrations

Migrations make sure all the database table shcemas are executed properly.
Run them first.

```bash
composer run-migrations
```

OR

```bash
php yii migrate --migrationPath=@app/migrations/source --db=source_db --interactive=0
php yii migrate --migrationPath=@app/migrations/destination --db=destination_db --interactive=0
```

### Source database data

This command will generate 55 random entries in the Source database table.
It's using `fzaninotto/faker` library that generates fake data for you.

```bash
composer generate-random-rows
```

OR

```bash
php yii app/generate-rows 55
```

### Moving data

Next step for this application is to move data from one database to another.
This command maps and copies rows from Source database table to Destination.

```bash
composer move-data
```

OR

```bash
php yii app/move-data
```

### Cleanup databases

When doing multiple tests a quick cleanup is a nice to have.
This destroys all data and table structures in both Source and Destination databases. Running migrations is required after Cleanup.

```bash
composer clean-databases
```

OR

```bash
php yii migrate/down --migrationPath=@app/migrations/source --db=source_db --interactive=0
php yii migrate/down --migrationPath=@app/migrations/destination --db=destination_db --interactive=0
```
