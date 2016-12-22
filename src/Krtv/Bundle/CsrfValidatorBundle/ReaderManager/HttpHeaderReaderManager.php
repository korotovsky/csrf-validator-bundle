<?php

namespace Krtv\Bundle\CsrfValidatorBundle\ReaderManager;

use Doctrine\Common\Annotations\Annotation;
use Krtv\Bundle\CsrfValidatorBundle\Annotations\CsrfHeader;
use Symfony\Component\Security\Csrf\CsrfToken;

/**
 * Read CSRF token from HTTP header
 *
 * @package Krtv\Bundle\CsrfValidatorBundle\ReaderManager
 */
class HttpHeaderReaderManager extends AbstractReaderManager
{
    /**
     * @var string Class to be supported by reader
     */
    protected $annotationClass = CsrfHeader::class;

    /**
     * @inheritdoc
     */
    public function validate(Annotation $annotation)
    {
        /** @var CsrfHeader $annotation */
        $token = $this->requestStack->getMasterRequest()->headers->get($annotation->httpHeader);

        return $this->csrfManager->isTokenValid(
            new CsrfToken($annotation->intention, $token)
        );
    }
}
