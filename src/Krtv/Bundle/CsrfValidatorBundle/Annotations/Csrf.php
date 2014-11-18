<?php

namespace Krtv\Bundle\CsrfValidatorBundle\Annotations;


use Doctrine\Common\Annotations\Annotation;

/**
 * Class Csrf
 * @package Krtv\Bundle\CsrfValidatorBundle\Annotations
 * @Annotation
 * @Target("METHOD")
 */
final class Csrf extends Annotation
{
    /**
     * @var string Intention for CSRF token
     */
    public $intention;

    /**
     * @var string
     */
    public $param = 'token';
}