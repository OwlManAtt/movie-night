# Movie Night [![Build Status](https://travis-ci.org/OwlManAtt/movie-night.svg?branch=master)](https://travis-ci.org/OwlManAtt/movie-night) [![Coverage Status](https://coveralls.io/repos/github/OwlManAtt/movie-night/badge.svg?branch=master)](https://coveralls.io/github/OwlManAtt/movie-night?branch=master)
This is a Movie Night planning app for the Spinach Inquisition's weekly bad movie night. It features:

- Importing movies & series from IMDB
- Scheduling something to watch on Google Calendar
- Polling to see what we should watch next

## Setup
This is a Laravel app and the setup process is fairly standard:

```sh
$ composer install
$ yarn install
$ yarn run prod
```

For Discord auth, do not forget to whitelist your callback URL (e.g. https://whatever.net/login/discord/callback) on the OAuth2 screen.
