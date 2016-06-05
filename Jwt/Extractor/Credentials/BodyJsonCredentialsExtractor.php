<?php

namespace Kpeu3i\JwtBundle\Jwt\Extractor\Credentials;

use Symfony\Component\HttpFoundation\ParameterBag;
use Symfony\Component\HttpFoundation\Request;

class BodyJsonCredentialsExtractor extends AbstractCredentialsExtractor
{
    public function extractUsername(Request $request, $default = null)
    {
        return $this->doExtract($request, $this->usernameParameter, $default);
    }

    public function extractPassword(Request $request, $default = null)
    {
        return $this->doExtract($request, $this->passwordParameter, $default);
    }

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
