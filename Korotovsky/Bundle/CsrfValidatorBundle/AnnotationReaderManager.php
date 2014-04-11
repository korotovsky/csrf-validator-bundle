<?php
/**
 * Created by PhpStorm.
 * User: korotovsky
 * Date: 4/11/14
 * Time: 9:55 AM
 */

namespace Korotovsky\Bundle\CsrfValidatorBundle;


use Doctrine\Common\Annotations\Reader;
use Korotovsky\Bundle\CsrfValidatorBundle\Annotations\Csrf;

/**
 * Class AnnotationReaderManager
 * @package Korotovsky\Bundle\CsrfValidatorBundle
 */
class AnnotationReaderManager
{
    /**
     * @var Reader
     */
    protected $reader;

    /**
     * @var string
     */
    protected $annotationClass = Csrf::class;

    /**
     * @param Reader $reader
     */
    public function __construct(Reader $reader)
    {
        $this->reader = $reader;
    }
} 