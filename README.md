php-util
========

Some useful PHP libraries.

This project is enabled to work with <a href="https://getcomposer.org/" >Composer</a> and had been published at <a href="https://packagist.org/" >Packagist</a>.

For installing using <a href="https://getcomposer.org/" >Composer</a>, create a <code>composer.json</code> file in your project root, with the following content:
<pre><code class="language-javascript" >
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
</code></pre>
Then, go to your project directory and type the following command:
<pre><code>
composer install
</code></pre>
For more information on how using Composer, please see its <a href="https://getcomposer.org/doc/" >Documentation</a> page.