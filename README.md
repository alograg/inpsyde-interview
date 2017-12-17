# Interview for Inpsyde

Composer package, which serves the functionality working with WordPress Nonces.
Implementing wp_nonce_*() function in an object orientated way.

## Content

- [EditorConfig](#editor-config)
- [Propositions](#propositions)
  - [Stand alone package](#stand-alone-package)
  - [Package for WordPress Packagist](#package-for-word-press-packagist)
  - [Plugin inside a full WordPress instalation](#plugin-inside-a-full-word-press-instalation)

## EditorConfig

Config the base editor with [WordPress PHP Coding Standards](https://make.wordpress.org/core/handbook/best-practices/coding-standards/php/) based on [PEAR Coding Standards](http://pear.php.net/manual/en/standards.php).

## Propositions

I consider that your request has 3 viable solutions.

### Stand alone package

__Stand alone package__ solution is a package witch can work without any thing else like WordPress Nonces functions.
This solution is in the directory ``./stand_alone``.

### Package for [__*WordPress Packagist*__](https://wpackagist.org/)

The packagist solution is developed to be loaded as a package that gives access to WordPress Nonces functions in an OOP manner.
This solution is in the directory ``./packagist``.

### Plugin inside a full WordPress instalation

This solution is the least modular but it works with the [Wordpress Development Templates](http://wordpress-dev.evopiru.com/) solution to implement plugins on installations.
This solution is in the directory ``./using_full_wp``.
