<?php
/**
 * Created by PhpStorm.
 * User: korotovsky
 * Date: 4/11/14
 * Time: 9:51 AM
 */

namespace Korotovsky\Bundle\CsrfValidatorBundle\Annotations;


use Doctrine\Common\Annotations\Annotation;

/**
 * Class Csrf
 * @package Korotovsky\Bundle\CsrfValidatorBundle\Annotations
 * @Annotation
 * @Target("METHOD")
 */
final class Csrf extends Annotation
{
    /**
     * @var string Intention for CSRF token
     */
    public $intention;
}