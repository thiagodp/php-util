php-util
========

Some useful PHP libraries.

## Warning

THIS PROJECT IS BEING SEPARATED INTO SUBPROJECTS AND SHALL BECOME DEPRECATED IN A NEAR FUTURE.

These subprojects are:
- [phputil/JSON](https://github.com/thiagodp/json)
- [phputil/PDOWrapper](https://github.com/thiagodp/pdowrapper)
- [phputil/RTTI](https://github.com/thiagodp/rtti)
- [phputil/session](https://github.com/thiagodp/session)
- [phputil/datatables](https://github.com/thiagodp/datatables)

We also recommend you to take a look at [other interesting repositories](https://github.com/thiagodp?tab=repositories).

## Installation

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
