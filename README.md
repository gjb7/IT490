# Misdirected Delivieries, Inc.

This is the final project for NJIT's IT 490 course.

## Requirements

- PHP 5.3 or higher.
- [Composer](http://getcomposer.org/)

## Getting Started

*NOTE: Instructions subject to change.*

1. Install the required libraries. This can be done by running `composer install`.
2. Upload to your webserver.
3. Copy `app/database.sample.php` to `app/database.php` and modify for your database info.
4. Run `php -f migrate.php` to setup the database.
	4.1. If you're running this on NJIT's AFS, then you need to use `/usr/local/bin/php` instead of `php`, as they are two separate versions and the default one doesn't any MySQL functionality.
5. Go!

## Further Documentation

For more details about the implementation of the system, go check out the [http://grantjbutler.gom/IT490/](documentation). It has more details about the architecture of this system as well as details about how to add new parts to it. It is **highly recommended** that you read all the documentation before you start making modifications.