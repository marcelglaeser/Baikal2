# Baïkal Server

This is an incomplete **development version** of Baïkal Server 2 - NOT FOR PRODUCTION USE - seriously.

Baïkal2 is based on SabreDAV and Symfony2.

## Installation (for the braves)

```bash
composer install
php app/console doctrine:database:create
php app/console doctrine:schema:create
php app/console assetic:dump
php app/console assets:install
```

Then edit app/config/security.yml to change the password (and the username if you feel like it) for the static user "staticadmin" (default pass is "password", so better do it before anything else).

## Usage

Baïkal now features a frontend and an admin (hosted at /admin)

You may log in frontend or backend.

When the database is freshly created, no users are available. You then have to log in using "staticadmin" / "password" (or whatever you changed it to) to create an admin user (with admin role).

## State of the dev

As of 2013-10-27, DAV is served, admin is somewhat functionnal. Frontend is not coded at all.

Admin features a visual "Calendar view" (functionnal, but lacks features) and an "Addressbook view" (not functionnal).

## Roadmap

* Add unit tests
* Finish backend
* Finish Calendar and Addressbook View
* Code frontend
* Add "Todo list" feature
* Add "Notes" feature ?
* Add Import
* Add export
* Add calendar sharing
* Add JSON api.
* Review B1 github feature requests, and implement the most demanded ones.

If you are willing to participate, and know your way in whatever domain you want to help, please feel free to mail me at mail@jeromeschneider.fr (I have little time so please do not lose your patience if I don't answer :p)