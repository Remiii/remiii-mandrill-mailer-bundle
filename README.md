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

[![Build Status](https://travis-ci.org/Remiii/remiii-mandrill-mailer-bundle.svg?branch=master)](https://travis-ci.org/Remiii/remiii-mandrill-mailer-bundle)

[![SensioLabsInsight](https://insight.sensiolabs.com/projects/dcf88206-86e6-4c52-b99e-dd184ab69b3c/big.png)](https://insight.sensiolabs.com/projects/dcf88206-86e6-4c52-b99e-dd184ab69b3c)

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

## License

This bundle is under the MIT license. See the complete license in LICENSE.md

## Authors

* Rémi Barbe (aka Remiii)

## Bug report and Help

For bug reports open a Github ticket. Patches gratefully accepted. :-)

