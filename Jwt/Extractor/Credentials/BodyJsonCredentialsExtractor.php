<?php

namespace Kpeu3i\JwtBundle\Jwt\Extractor\Credentials;

use Symfony\Component\HttpFoundation\ParameterBag;
use Symfony\Component\HttpFoundation\Request;

/**
 * Class BodyJsonCredentialsExtractor
 *
 * @package Kpeu3i\JwtBundle\Jwt\Extractor\Credentials
 */
class BodyJsonCredentialsExtractor extends AbstractCredentialsExtractor
{
    /**
     * @param Request $request
     * @param mixed|null $default
     * @return mixed|null
     */
    public function extractUsername(Request $request, $default = null)
    {
        return $this->doExtract($request, $this->usernameParameter, $default);
    }

    /**
     * @param Request $request
     * @param mixed|null $default
     * @return mixed|null
     */
    public function extractPassword(Request $request, $default = null)
    {
        return $this->doExtract($request, $this->passwordParameter, $default);
    }

    /**
     * @param Request $request
     * @param $parameterName
     * @param mixed|null $default
     * @return mixed|null
     */
    protected function doExtract(Request $request, $parameterName, $default = null)
    {
        $data = json_decode($request->getContent(), true);
        if (is_array($data)) {
            $parameterBag = new ParameterBag($data);

            return $parameterBag->get($parameterName, $default, true);
        }

        return $default;
    }
}
