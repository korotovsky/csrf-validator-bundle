# Intro to KrtvCsrfValidatorBundle

- PHP `>=5.5`
- KrtvCsrfValidatorBundle's `0.4.x` compatible with symfony (`>=2.7` versions).
- Doctrine is required

## Features:

- Add extra annotation for auto validation CSRF-tokens to your controller actions

## Installation and configuration:

Pretty simple with [Composer](http://packagist.org), add:

```json
{
    "require": {
        "korotovsky/csrf-validator-bundle": "0.4.*"
    }
}
```

For latest version (UNSTABLE) use

```json
{
    "require": {
        "korotovsky/csrf-validator-bundle": "~0.4.0@dev"
    }
}
```

<a name="configuration"></a>

### Configuration example

- No specific configuration is needed! 

### Add KrtvCsrfValidatorBundle to your application kernel

```php
// app/AppKernel.php
public function registerBundles()
{
    return array(
        // ...
        new Krtv\Bundle\CsrfValidatorBundle\KrtvCsrfValidatorBundle(),
        // ...
    );
}
```

## Usage examples:

Just add annotation to your controller action

```php
// Acme\MainBundle\Controller\DefaultController.php

use Krtv\Bundle\CsrfValidatorBundle\Annotations as Krtv;

/**
 * @Krtv\Csrf(intention="your_intention")
 * @return Response
 */
public function importantZoneAction()
{
    // some code here ...

    return new Response();
}
```

### View

```jinja
<a href="{{ path('_some_route', {'token': csrf_token('your_intention')}) }}">Subscribe!</a>

```
