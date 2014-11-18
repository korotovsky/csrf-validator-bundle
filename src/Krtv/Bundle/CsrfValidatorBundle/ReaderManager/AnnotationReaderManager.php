<?php

namespace Krtv\Bundle\CsrfValidatorBundle\ReaderManager;

use Krtv\Bundle\CsrfValidatorBundle\Annotations\Csrf;

use Doctrine\Common\Annotations\Reader;
use Doctrine\Common\Annotations\Annotation;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\Security\Csrf\CsrfToken;
use Symfony\Component\Security\Csrf\CsrfTokenManagerInterface;

/**
 * Class AnnotationReaderManager
 * @package Krtv\Bundle\CsrfValidatorBundle\ReaderManager
 */
class AnnotationReaderManager
{
    /**
     * @var Reader
     */
    private $reader;

    /**
     * @var RequestStack
     */
    private $requestStack;

    /**
     * @var CsrfTokenManagerInterface
     */
    private $csrfManager;

    /**
     * @var string
     */
    private $annotationClass = Csrf::class;

    /**
     * @param Reader $reader
     * @param CsrfTokenManagerInterface $csrfManager
     * @param RequestStack $requestStack
     */
    public function __construct(Reader $reader, CsrfTokenManagerInterface $csrfManager, RequestStack $requestStack)
    {
        $this->reader = $reader;
        $this->csrfManager = $csrfManager;
        $this->requestStack = $requestStack;
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
     * @param Annotation $annotation
     * @throws \RuntimeException
     * @return bool
     */
    public function validate(Annotation $annotation)
    {
        $request = $this->requestStack->getCurrentRequest();
        if ($request === null) {
            throw new \RuntimeException('Can not validate CSRF token without Request object');
        }

        $token = $request->get($annotation->param);
        $intention = $annotation->intention;

        if ($this->csrfManager instanceof CsrfTokenManagerInterface) {
            $tokenObject = new CsrfToken($intention, $token);

            return $this->csrfManager->isTokenValid($tokenObject);
        } else {
            throw new \RuntimeException('Invalid CSRF token manager provided');
        }
    }
} 