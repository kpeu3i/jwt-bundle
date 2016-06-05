<?php

namespace Kpeu3i\JwtBundle\Event;

final class Events
{
    /**
     * Private constructor. This class is not meant to be instantiated.
     */
    private function __construct()
    {
    }

    const ON_AUTHENTICATION_SUCCESS = 'kpeu3i_jwt.on_authentication_success';

    const ON_AUTHENTICATION_FAILURE = 'kpeu3i_jwt.on_authentication_failure';

    const ON_JWT_AUTHENTICATION_SUCCESS = 'kpeu3i_jwt.on_jwt_authentication_success';

    const ON_JWT_AUTHENTICATION_FAILURE = 'kpeu3i_jwt.on_jwt_authentication_failure';

    const ON_JWT_CREATE = 'kpeu3i_jwt.on_jwt_create';

    const ON_JWT_VALIDATE = 'kpeu3i_jwt.on_jwt_validate';
}
