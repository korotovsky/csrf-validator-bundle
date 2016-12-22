<?php

namespace Krtv\Bundle\CsrfValidatorBundle\Annotations;


use Doctrine\Common\Annotations\Annotation;

/**
 * Csrf reader from HTTP Headers
 *
 * @Annotation
 * @Target("METHOD")
 *
 * @package Krtv\Bundle\CsrfValidatorBundle\Annotations
 */
class CsrfHeader extends Annotation
{
    /**
     * @var string Intention for CSRF token
     */
    public $intention;

    /**
     * @var string HTTP header to read CSRF token
     */
    public $httpHeader = 'X-CSRF-Token';
}
