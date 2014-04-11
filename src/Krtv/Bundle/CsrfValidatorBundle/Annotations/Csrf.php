<?php
/**
 * Created by PhpStorm.
 * User: Krtv
 * Date: 4/11/14
 * Time: 9:51 AM
 */

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