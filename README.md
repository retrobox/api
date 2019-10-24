# Retrobox's api

[![CircleCI](https://circleci.com/gh/retrobox/api.svg?style=svg)](https://circleci.com/gh/retrobox/api)

## Requirement

- Php 7.3 or higher
- Mysql 5 or higher server
- Rabbit-MQ
- Redis server

## Install

- clone this repo
- composer install
- Use `.env.example` to create your own `.env`

## Ressources

- game
- editor
- genre
- media
- platform
- post

## Description route API

### 1. Basics

| Route | Type | Auth | Params | Description | 
|--|--|--|--|--|
| / | GET | No |  | Affiche les infos générales sur l'api : env, version... |
| /ping | GET | No |  | Pong ! |
| /newsletter/subscribe | POST | No | `email` | Inscrire une adresse mail |
| /newsletter/event | GET | No |  | Vérification si la route existe bien apr Mailchimp |
| /newsletter/event | POST | No |  | Route appelée par Mailchimp, envoi un webhook Discord. |

### 2. GraphQL


| Route | Type | Auth | Params | Description | 
|--|--|--|--|--|
| /graphql | POST | Yes |  |  |


### 3. Paiements

| Route | Type | Auth | Params | Description | 
|--|--|--|--|--|
| /stripe/execute | POST | Yes | `token` `items` `shipping_country` `shipping_method` | Appelée par le front avec un token Stripe |
| /paypal/get-url | POST | Yes | `items` `shipping_country` `shipping_method` | Récuperer l'url fin de paiement |
| /paypal/execute | GET | No | `items` `shipping_country` `shipping_method` | Appelée par le front une fois redirigé par Paypal |

#### ⚠ Deprecated :

| Route | Type | Auth | Params | Description | 
|--|--|--|--|--|
| /paysafecard/capture_payments | POST | No |  | Appelée par PSC |
| /paysafecard/success | GET | No |  | Redirection de l'utilisateur en cas de paiement réussi |
| /paysafecard/failure | GET | No |  | Redirection de l'utilisateur en cas de d'un échec |
| /paysafecard/get_url | GET | No |  | Récuperer l'url fin de paiement |

### 4. Accounts Controller

| Route | Type | Auth | Params | Description | 
|--|--|--|--|--|
| /info | GET | Yes |  | Récuperer les infos de l'user connecté actuellement |
| /login | GET | No |  | Avoir l'url de stail.eu |
| /register | GET | No |  | Avoir l'url de stail.eu |
| /login-desktop | GET | No |  | Lien pour lier l'app desktop |
| /login-desktop | POST | Yes | `token` | Appelée par le front pour lier avec le compte |
| /execute | GET/POST | Yes | `code` | Executer une connexion stail.eu |

### 5. Dashboard Controller

| Route | Type | Auth | Params | Description | 
|--|--|--|--|--|
| [/] | GET | Yes |  | Renvoi les infos user, les commandes et les consoles |
| /upload | POST | Yes | `file` | Upload d'un rom (WIP) |
| /delete | GET | Yes |  | Supprimer son compte |

### 6. Shop Controller

| Route | Type | Auth | Params | Description | 
|--|--|--|--|--|
| /storage-prices | GET | No |  | Avoir les différents prix d'une console |
| /shipping-prices | GET | No |  | Avoir les prix des FDP en fonction du poids et du contry code |
| /{locale}/categories | GET | No |  | Avoir les catégories en fonction des locales |
| /{locale}/item/{slug} | GET | No |  | Avoir les nom des objets en fonction des locales |

### 7. Others

| Route | Type | Auth | Params | Description | 
|--|--|--|--|--|
| /console/verify | POST | No | `console_id` `console_token` | Appelée par la console pour initialiser l'overlay |
| /downloads | GET | No |  | Renvoyer les liens pour telechager l'app desktop |
| /docs/{locale}/{slug} | GET | No |  | /deprecated\ Retourne le markdown en fonction de la locales |
| /websocket/connexions | GET | is-admin |  | Retourne les différentes connexions ouvertes sur le serveur web-socket |
| /countries/{locale} | GET | No |  | Retourne la liste de tous les pays dans la locale spécifiée |
| /health | GET | No |  | Voir l'état des connexions avec les services externes (MySQL, Redis, Web-Socket, Rabbit-MQ) |

