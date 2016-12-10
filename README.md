JwtBundle
=========

Integrates jwt authentication mechanism into Symfony.

## Installation

```sh
composer require kpeu3i/jwt-bundle dev-master
```

#### Enable Bundle

Put in your `AppKernel.php` to enable the bundle

```php
<?php
// app/AppKernel.php

public function registerBundles()
{
    $bundles = array(
        // ...
        new \Kpeu3i\JwtBundle\Kpeu3iJwtBundle()
    );
}
```

#### Configuration

Add default bundle configuration:

```yaml
# app/config/config.yml

kpeu3i_jwt: ~
```

Configure `firewalls` with "kpeu3i_jwt_creation" and "kpeu3i_jwt" sections in your `security.yml`:

```yml
# app/config/security.yml

security:
    encoders:
        Symfony\Component\Security\Core\User\User: plaintext

    providers:
        in_memory:
            memory:
                users:
                    admin:
                        password: demo
                        roles: 'ROLE_ADMIN'

    firewalls:
        dev:
            pattern: ^/(_(profiler|wdt)|css|images|js)/
            security: false

        login:
            pattern: "^/api/login"
            security: true
            anonymous: false
            stateless: true
            kpeu3i_jwt_creation:
                credentials_extractor:
                    type: "body_json"
                    username_parameter: "username"
                    password_parameter: "password"
                encoder:
                    algorithm: "HS256"
                    key: "secret_key"
                    passphrase: ~
                token:
                    claims:
                        issuer: ~
                        subject: ~
                        audience: ~
                        user:
                            name: "[usr][username]"
                            value: "username"
                    ttl: 86400

        api:
            pattern: "^/api/.*"
            security: true
            anonymous: false
            stateless: true
            kpeu3i_jwt:
                token_extractor:
                    type: "headers"
                    parameter_name: "Authorization"
                    token_prefix: "Bearer"
                decoder:
                    algorithm: "HS256"
                    key: "secret_key"
                username_extractor:
                    path: "usr.value.username"
```
