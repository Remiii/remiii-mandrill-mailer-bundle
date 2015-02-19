# MandrillMailerBundle

The MandrillMailerBundle add support fot Mandrill API Swiftmailer.

Features include:
* ...

Caution: This bundle is under development with no warranty.

## Requirement

Mandrill API Key - https://mandrillapp.com/

## Installation

### Step 1: Download MandrillMailerBundle using composer

Add MandrillMailerBundle by running the command:

```sh
$ php composer.phar require remiii/mandrill-mailer-bundle ""remiii/google-translate": "dev-master"
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
// app/parameters.yml

parameters:
    #...
    mailer_transport; remiii_mandrill_mailer
```

## License

This bundle is under the MIT license. See the complete license in LICENSE.md

## Authors

* Rémi Barbe (aka Remiii)


