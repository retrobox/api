# Retrobox's api

[![CircleCI](https://circleci.com/gh/retrobox/api.svg?style=svg)](https://circleci.com/gh/retrobox/api)

## Requirement

- Php 7.1 or higher
- Mysql server

## Install

- clone this repo
- composer install
- add all env vars you needss in `.env` file

## Ressources

- game
- editor
- genre
- media
- platform
- post

soon:

- team member

## todo

- game ressource

## Payment status

- `not-payed`
- `payed`
- `failed`
- `shipped`
- `closed`

## How to get the status of a console

first, when the user will have many consoles, we will not display 
the status at all, we will just display basic information in order 
that the user will select the console.

when we want to known more about a console we will request the 
websocket server to get the status of this console.
