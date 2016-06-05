<?php

namespace Kpeu3i\JwtBundle\Jwt\Codec;

use Kpeu3i\JwtBundle\Exception\UnsupportedAlgorithmException;
use Kpeu3i\JwtBundle\Exception\UnsupportedValidationClaimException;
use Kpeu3i\JwtBundle\Jwt\Claim\ClaimCollectionInterface;
use Kpeu3i\JwtBundle\Jwt\Claim\ClaimInterface;
use Kpeu3i\JwtBundle\Jwt\Claim\Factory\ClaimFactory;
use Kpeu3i\JwtBundle\Jwt\Claim\Factory\ClaimFactoryInterface;
use Lcobucci\JWT\Builder;
use Lcobucci\JWT\Parser;
use Lcobucci\JWT\Signer;
use Lcobucci\JWT\Signer\Key;
use Lcobucci\JWT\Token;
use Lcobucci\JWT\ValidationData;

class AbstractJwtCodec implements JwtCodecInterface
{
    /**
     * @var string
     */
    protected $key;

    /**
     * @var string
     */
    protected $passphrase;

    /**
     * @var string
     */
    protected $algorithm;

    /**
     * @var ClaimFactoryInterface
     */
    protected $claimFactory;

    /**
     * @var array
     */
    protected $signersCache = [];

    public function __construct(
        $key,
        $passphrase = null,
        $algorithm = self::ALGORITHM_HS256,
        ClaimFactoryInterface $claimFactory = null
    )
    {
        $claimFactory = $claimFactory ?: new ClaimFactory();

        $this
            ->setKey($key)
            ->setPassphrase($passphrase)
            ->setAlgorithm($algorithm)
            ->setClaimFactory($claimFactory)
        ;
    }

    /**
     * @param string $key
     * @return $this
     */
    public function setKey($key)
    {
        $this->key = $key;

        return $this;
    }

    /**
     * @param string $passphrase
     * @return $this
     */
    public function setPassphrase($passphrase)
    {
        $this->passphrase = $passphrase;

        return $this;
    }

    /**
     * @param $algorithm
     * @return $this
     */
    public function setAlgorithm($algorithm)
    {
        $const = sprintf('self::ALGORITHM_%s', $algorithm);

        if (!defined($const)) {
            throw new \InvalidArgumentException('Unsupported algorithm');
        }

        $this->algorithm = $algorithm;

        return $this;
    }

    public function setClaimFactory(ClaimFactoryInterface $claimFactory)
    {
        $this->claimFactory = $claimFactory;

        return $this;
    }

    protected function createParser()
    {
        return new Parser();
    }

    protected function createKey($key, $passphrase = null)
    {
        return new Key($key, $passphrase);
    }

    protected function createSigner($algorithm)
    {
        if (isset($this->signersCache[$algorithm])) {
            return $this->signersCache[$algorithm];
        }

        switch ($algorithm) {
            // HMAC
            case self::ALGORITHM_HS256:
                $signer = new Signer\Hmac\Sha256();
                break;
            case self::ALGORITHM_HS384:
                $signer = new Signer\Hmac\Sha384();
                break;
            case self::ALGORITHM_HS512:
                $signer = new Signer\Hmac\Sha512();
                break;

            // RSA
            case self::ALGORITHM_RS256:
                $signer = new Signer\Rsa\Sha256();
                break;
            case self::ALGORITHM_RS384:
                $signer = new Signer\Rsa\Sha384();
                break;
            case self::ALGORITHM_RS512:
                $signer = new Signer\Rsa\Sha512();
                break;

            // ECDSA
            case self::ALGORITHM_ES256:
                $signer = new Signer\Ecdsa\Sha256();
                break;
            case self::ALGORITHM_ES384:
                $signer = new Signer\Ecdsa\Sha384();
                break;
            case self::ALGORITHM_ES512:
                $signer = new Signer\Ecdsa\Sha512();
                break;

            default:
                throw new UnsupportedAlgorithmException();
        }

        $this->signersCache[$algorithm] = $signer;

        return $signer;
    }

    protected function createBuilder(ClaimCollectionInterface $claims = null)
    {
        $builder = new Builder();

        if ($claims) {
            foreach ($claims as $claim) {
                /* @var ClaimInterface $claim */
                $builder->set($claim->getName(), $claim->getValue());
            }
        }

        return $builder;
    }

    protected function createValidationData(ClaimCollectionInterface $validationClaims = null)
    {
        $validationData = new ValidationData();

        if ($validationClaims) {
            foreach ($validationClaims as $claim) {
                /* @var ClaimInterface $claim */
                switch ($claim->getName()) {
                    case ClaimInterface::CLAIM_NAME_JTI:
                        $validationData->setId($claim->getValue());
                        break;
                    case ClaimInterface::CLAIM_NAME_ISS:
                        $validationData->setIssuer($claim->getValue());
                        break;
                    case ClaimInterface::CLAIM_NAME_AUD:
                        $validationData->setAudience($claim->getValue());
                        break;
                    case ClaimInterface::CLAIM_NAME_SUB:
                        $validationData->setSubject($claim->getValue());
                        break;
                    default:
                        throw new UnsupportedValidationClaimException();
                }
            }
        }

        return $validationData;
    }

    protected function createClaimCollection(Token $token)
    {
        $claimCollection = $this->claimFactory->createClaimCollection();

        foreach ($token->getClaims() as $claim) {
            /* @var \Lcobucci\JWT\Claim $claim */
            $claimCollection->set($this->claimFactory->createClaim($claim->getName(), $claim->getValue()));
        }

        return $claimCollection;
    }
}
