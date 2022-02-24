# The RetroBox's API   

![Github Actions](https://github.com/retrobox/api/workflows/Continuous%20integration/badge.svg)  

## Requirements

- Php 8.0 or higher
- MySQL 5 or higher
- [Jobatator](https://github.com/lefuturiste/jobatator) to manage queue/jobs
- Redis or a Redis compatible server like [KeyValuer](https://github.com/lefuturiste/keyvaluer)

## Install

- Clone this repo
- Run `composer install`
- Use `.env.example` to create your own `.env`
- Start the api with `php -S 127.0.0.1:8000 -t public`

## Debug setup

Recommended environment variables values:

- In development: `SENTRY_ENABLE=0` because you don't want to float sentry and `APP_DEBUG=1` to get the nice pretty whoops guard web interface to debug.
- In production: 'SENTRY_ENABLE=1' to get log to sentry and `APP_DEBUG=0` to hide details of exception, but still if APP_DEBUG is false you will get some kind of details in JSON when the server fail

## Working with the database

This project use phinx as a database migration/seed manager.

Migrate the database up to the latest version: `vendor/bin/phinx migrate`

Run a seed/fixture: `vendor/bin/phinx seed:run -s GameSeeder`

## Working with stripe

To get a webhook event if you are in local, you want to use [Stripe CLI](https://stripe.com/docs/stripe-cli)

Use: `stripe listen --forward-to localhost:8000/stripe/execute --events checkout.session.completed`

## Description route API

### 1. Basics

| Route | Type | Auth | Params | Description |
|--|--|--|--|--|
| / | GET | No | | Affiche les infos générales sur l'api : env, version... |
| /ping | GET | No | | Pong ! |
| /newsletter/subscribe | POST | No | `email` | Inscrire une adresse mail |
| /newsletter/event | GET | No | | Vérification si la route existe bien apr Mailchimp |
| /newsletter/event | POST | No | | Route appelée par Mailchimp, envoi un webhook Discord. |

### 2. GraphQL

| Route | Type | Auth | Params | Description |
|--|--|--|--|--|
| /graphql | POST | Yes (Bearer) | yourBearerToken | |

#### To see all schema with all descriptions, you can check [here](https://github.com/retrobox/api/blob/master/graphql_schema.md).

This is a schema generated automatically by `graphql-markdown` ([here](https://github.com/exogen/graphql-markdown)).

Script command (add to your package.json) :

```js
node ./src/index.js --header \"Authorization=Bearer yourToken\" https://api.retrobox.tech/graphql > schema.md
```

#### How to get your Bearer Token ?

1. Be sure that you are well connected with your stail.eu account
2. Press `F12`, go to the `Console` tab
3. Write this function in the prompt `getToken()`
4. Then it will return your unique Bearer token

### 3. Paiements

| Route | Type | Auth | Params | Description |
|--|--|--|--|--|
| /stripe/execute | POST | Yes | `token`  `items`  `shipping_country`  `shipping_method` | Appelée par le front avec un token Stripe |
| /stripe/create | POST | Yes | `token`  `items`  `shipping_country`  `shipping_method` | Créer la session de paiement |
| /paypal/get-url | POST | Yes | `items`  `shipping_country`  `shipping_method` | Récuperer l'url fin de paiement |
| /paypal/execute | GET | No | `items`  `shipping_country`  `shipping_method` | Appelée par le front une fois redirigé par Paypal |

#### ⚠️ Deprecated :

| Route | Type | Auth | Params | Description |
|--|--|--|--|--|
| /paysafecard/capture_payments | POST | No | | Appelée par PSC |
| /paysafecard/success | GET | No | | Redirection de l'utilisateur en cas de paiement réussi |
| /paysafecard/failure | GET | No | | Redirection de l'utilisateur en cas de d'un échec |
| /paysafecard/get_url | GET | No | | Récuperer l'url fin de paiement |

### 4. Accounts Controller

| Route | Type | Auth | Params | Description |
|--|--|--|--|--|
| /info | GET | Yes | | Récuperer les infos de l'user connecté actuellement |
| /login | GET | No | | Avoir l'url de stail.eu |
| /register | GET | No | | Avoir l'url de stail.eu |
| /login-desktop | GET | No | | Lien pour lier l'app desktop |
| /login-desktop | POST | Yes | `token` | Appelée par le front pour lier avec le compte |
| /execute | GET/POST | Yes | `code` | Executer une connexion stail.eu |

### 5. Dashboard Controller

| Route | Type | Auth | Params | Description |
|--|--|--|--|--|
| [/] | GET | Yes | | Renvoi les infos user, les commandes et les consoles |
| /upload | POST | Yes | `file` | Upload d'un rom (WIP) |
| /delete | GET | Yes | | Supprimer son compte |

### 6. Shop Controller

| Route | Type | Auth | Params | Description |
|--|--|--|--|--|
| /storage-prices | GET | No | | Avoir les différents prix d'une console |
| /shipping-prices | GET | No | | Avoir les prix des FDP en fonction du poids et du contry code |
| /{locale}/categories | GET | No | | Avoir les catégories en fonction des locales |
| /{locale}/item/{slug} | GET | No | | Avoir les nom des objets en fonction des locales |
| /cache/shop/generate | GET | No | | Regenerer le cache du shop |

### 7. Others

| Route | Type | Auth | Params | Description |
|--|--|--|--|--|
| /console/verify | POST | No | `console_id`  `console_token` | Appelée par la console pour initialiser l'overlay |
| /downloads | GET | No | | Renvoyer les liens pour telechager l'app desktop |
| /docs/{locale}/{slug} | GET | No | | /deprecated\ Retourne le markdown en fonction de la locales |
| /websocket/connexions | GET | is-admin | | Retourne les différentes connexions ouvertes sur le serveur web-socket |
| /countries/{locale} | GET | No | | Retourne la liste de tous les pays dans la locale spécifiée |
| /health | GET | No | | Voir l'état des connexions avec les services externes (MySQL, Redis, Web-Socket, Jobatator) |
| /test-send-email-event | GET | No | | Envoyer un email de test |
| /dangerously-truncate-table | GET | No | | Fonctionne seulement dans l'env "test" |
