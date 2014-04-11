<?php
/**
 * Created by PhpStorm.
 * User: Krtv
 * Date: 4/11/14
 * Time: 9:55 AM
 */

namespace Krtv\Bundle\CsrfValidatorBundle\ReaderManager;


use Doctrine\Common\Annotations\Reader;
use Krtv\Bundle\CsrfValidatorBundle\Annotations\Csrf;

/**
 * Class AnnotationReaderManager
 * @package Krtv\Bundle\CsrfValidatorBundle\ReaderManager
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