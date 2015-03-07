# MandrillMailerBundle

The MandrillMailerBundle add support fot Mandrill API Swiftmailer.

```
                            _      _ _ _              _ _
      /\/\   __ _ _ __   __| |_ __(_) | | /\/\   __ _(_) | ___ _ __
     /    \ / _` | '_ \ / _` | '__| | | |/    \ / _` | | |/ _ \ '__|
    / /\/\ \ (_| | | | | (_| | |  | | | / /\/\ \ (_| | | |  __/ |
    \/    \/\__,_|_| |_|\__,_|_|  |_|_|_\/    \/\__,_|_|_|\___|_|

```

Features include:
* ...

Caution: This bundle is under development with no warranty.

[![Total Stars](https://img.shields.io/github/stars/Remiii/remiii-mandrill-mailer-bundle.svg?style=flat-square)](https://packagist.org/packages/remiii/mandrill-mailer-bundle)

[![Build Status](https://img.shields.io/travis/Remiii/remiii-mandrill-mailer-bundle.svg?style=flat-square)](https://travis-ci.org/Remiii/remiii-mandrill-mailer-bundle)

[![Coverage Status](https://img.shields.io/coveralls/Remiii/remiii-mandrill-mailer-bundle.svg?style=flat-square)](https://coveralls.io/r/Remiii/remiii-mandrill-mailer-bundle)

[![SensioLabsInsight](https://img.shields.io/sensiolabs/i/dcf88206-86e6-4c52-b99e-dd184ab69b3c.svg?style=flat-square)](https://insight.sensiolabs.com/projects/dcf88206-86e6-4c52-b99e-dd184ab69b3c)

## Requirement

Mandrill API Key - https://mandrillapp.com/

## Installation

### Step 1: Download MandrillMailerBundle using composer

Add MandrillMailerBundle by running the command:

```sh
$ php composer.phar require remiii/mandrill-mailer-bundle "remiii/google-translate": "dev-master"
```

Composer will install the bundle to your project's `vendor` directory.

### Step 2: Enable the bundle

Enable the bundle in the kernel:

```php
<?php

// app/AppKernel.php

public function registerBundles()
{
    $bundles = array(
        // ...
        new remiii\MandrillMailerBundle\remiiiMandrillMailerBundle(),
    );
}
```

### Step 3: Config `config.yml`

```yml
// app/config/config.yml

#...

# MandrillMailer
remiii_mandrill_mailer:
    api_key: YOUR_MANDRILL_API_KEY
    async: false
```

### Step 4: Config `param.yml`

```yml
// app/config/parameters.yml

parameters:
    #...
    mailer_transport: remiii_mandrill_mailer
```

## Version

[![Latest Stable Version](https://img.shields.io/packagist/v/remiii/mandrill-mailer-bundle.svg?style=flat-square)](https://packagist.org/packages/remiii/mandrill-mailer-bundle)

## License

This bundle is under the MIT license. See the complete license in LICENSE.md

[![License](https://img.shields.io/badge/license-MIT-blue.svg?style=flat-square)](https://packagist.org/packages/remiii/mandrill-mailer-bundle)

## Authors

* Rémi Barbe (aka Remiii)

## Bug report and Help

For bug reports open a Github ticket. Patches gratefully accepted. :-)

