<?php

namespace Krtv\Bundle\CsrfValidatorBundle\ReaderManager;

use Krtv\Bundle\CsrfValidatorBundle\Annotations\Csrf;
use Doctrine\Common\Annotations\Reader;
use Doctrine\Common\Annotations\Annotation;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\Security\Csrf\CsrfToken;
use Symfony\Component\Security\Csrf\CsrfTokenManagerInterface;

/**
 * Implements basic methods for other reader managers
 *
 * @package Krtv\Bundle\CsrfValidatorBundle\ReaderManager
 */
abstract class AbstractReaderManager implements ReaderManagerInterface
{

    /**
     * @var RequestStack
     */
    protected $requestStack;

    /**
     * @var CsrfTokenManagerInterface
     */
    protected $csrfManager;

    /**
     * @var Reader
     */
    protected $reader;

    /**
     * @var string Class to be supported by reader
     */
    protected $annotationClass;

    /**
     * @param RequestStack              $requestStack
     * @param Reader                    $reader
     * @param CsrfTokenManagerInterface $csrfManager
     */
    public function __construct(RequestStack $requestStack, CsrfTokenManagerInterface $csrfManager, Reader $reader)
    {
        $this->requestStack = $requestStack;
        $this->csrfManager =  $csrfManager;
        $this->reader =       $reader;
    }

    /**
     * @param \ReflectionMethod $action
     * @return bool|Annotation
     */
    public function supports(\ReflectionMethod $action)
    {
        $annotation = $this->reader->getMethodAnnotation($action, $this->annotationClass);
        if ($annotation !== null) {
            return $annotation;
        }

        return false;
    }

    /**
     * Validates CSRF token from controller annotation.
     *
     * @param Annotation $annotation
     *
     * @return bool
     */
    abstract public function validate(Annotation $annotation);
}
