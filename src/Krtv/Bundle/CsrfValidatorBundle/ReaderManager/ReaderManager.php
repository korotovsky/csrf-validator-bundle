<?php

namespace Krtv\Bundle\CsrfValidatorBundle\ReaderManager;

use Krtv\Bundle\CsrfValidatorBundle\Annotations\Csrf;

use Doctrine\Common\Annotations\Annotation;
use Symfony\Component\Security\Csrf\CsrfToken;

/**
 * Class ReaderManager
 *
 * Read CSRF token from request params.
 *
 * @package Krtv\Bundle\CsrfValidatorBundle\ReaderManager
 */
class ReaderManager extends AbstractReaderManager
{
    /**
     * @var string Class to be supported by reader
     */
    protected $annotationClass = Csrf::class;

    /**
     * @inheritdoc
     */
    public function validate(Annotation $annotation)
    {
        $token = $this->requestStack->getMasterRequest()->get($annotation->param);

        return $this->csrfManager->isTokenValid(
            new CsrfToken($annotation->intention, $token)
        );
    }
} 
