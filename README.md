# Slim3 template API

This is simple template of slimframework 3 and integrations of others php librarys.

## Quick install

Just run a:

`composer create-project lefuturiste/slim3-template-api`

## The console

This template include console powered by symfony console:

The console allowed this commands:

### Local dev server

- php console serve -> for run a local dev server with php cli

## Maintenance mode

(not finish)

Maintenance mode allow a independent maintenance mode from your web application.

Maintenance mode is made for rename index.php file in web root directory (public) by _index.php and rename maintenance.php file by index.php file and vice versa.

- php console maintenance open -> for enable maintenance mode
- php console maintenance close -> for disable maintenance mode