php-util
========

Some useful PHP libraries.

This project works with <a href="https://getcomposer.org/" >Composer</a> and had been published at <a href="https://packagist.org/" >Packagist</a>.

For installing using <a href="https://getcomposer.org/" >Composer</a>:

**Method A**: Type the following command:
```
composer require thiagodp/php-util:dev-master
```

**Method B**: Create a <code>composer.json</code> file in your project root, with the following content:
```
{
    "repositories": [
        {
            "type": "vcs",
            "url": "https://github.com/thiagodp/php-util"
        }
    ],
    "require": {
        "thiagodp/php-util": "dev-master"
    }
}
```
Then, go to your project directory and type the following command:
```
composer install
```

For more information on how using Composer, please see its <a href="https://getcomposer.org/doc/" >Documentation</a> page.
