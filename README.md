TangoMan DQL Helper Bundle
==========================

**TangoMan DQL Helper Bundle** provides an easy way to add front elements to your pages.
**TangoMan DQL Helper Bundle** makes building back-office for your app a brease.

Installation
============

Step 1: Download the Bundle
---------------------------

Open a command console, enter your project directory and execute the
following command to download the latest stable version of this bundle:

```bash
$ composer require tangoman/dql-helper-bundle
```

This command requires you to have Composer installed globally, as explained
in the [installation chapter](https://getcomposer.org/doc/00-intro.md)
of the Composer documentation.

Step 2: Enable the Bundle
-------------------------

Then, enable the bundle by adding it to the list of registered bundles
in the `app/AppKernel.php` file of your project:

```php
<?php
// app/AppKernel.php

// ...
class AppKernel extends Kernel
{
    // ...

    public function registerBundles()
    {
        $bundles = array(
            // ...
            new TangoMan\DqlHelperBundle\TangoManDqlHelperBundle(),
        );

        // ...
    }
}
```

Usage
=====

inside your repository:
```php
    /**
     * @param integer $fromLat
     * @param integer $fromLon
     *
     * @return mixed
     */
    public function getPlaces($fromLat, $fromLon)
    {
        $dql = $this->createQueryBuilder('places');
        $dql->select('places', 'p')
            ->where('DISTANCE(:fromLat, :fromLon, p.Lat, p.Lon') < 100')
            ->setParameter(':fromLat', $fromLat)
            ->setParameter(':fromLon', $fromLon)
        ;

        return $dql->getQuery()->getResult();
    }
```

Note
====

If you find any bug please report here : [Issues](https://github.com/TangoMan75/DqlHelperBundle/issues/new)

License
=======

Copyrights (c) 2017 Matthias Morin

[![License][license-MIT]][license-url]
Distributed under the MIT license.

If you like **TangoMan DQL Helper Bundle** please star!
And follow me on GitHub: [TangoMan75](https://github.com/TangoMan75)
... And check my other cool projects.

[tangoman.free.fr](http://tangoman.free.fr)

[license-GPL]: https://img.shields.io/badge/Licence-GPLv3.0-green.svg
[license-MIT]: https://img.shields.io/badge/Licence-MIT-green.svg
[license-url]: LICENSE
[twig-error]: Resources/doc/error-invalid-json.jpg