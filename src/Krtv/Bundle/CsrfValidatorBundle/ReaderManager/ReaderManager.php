<?php

namespace Krtv\Bundle\CsrfValidatorBundle\ReaderManager;

use Krtv\Bundle\CsrfValidatorBundle\Annotations\Csrf;

use Doctrine\Common\Annotations\Reader;
use Doctrine\Common\Annotations\Annotation;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\Form\Extension\Csrf\CsrfProvider\CsrfTokenManagerAdapter;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\Security\Csrf\CsrfToken;
use Symfony\Component\Security\Csrf\CsrfTokenManagerInterface;

/**
 * Class ReaderManager
 * @package Krtv\Bundle\CsrfValidatorBundle\ReaderManager
 */
class ReaderManager implements ReaderManagerInterface
{
    /**
     * @var RequestStack
     */
    protected $requestStack;

    /**
     * @var
     */
    protected $csrfManager;

    /**
     * @var Reader
     */
    protected $reader;

    /**
     * @var string
     */
    protected $annotationClass = Csrf::class;

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
     * @param Annotation $annotation
     * @return bool
     */
    public function validate(Annotation $annotation)
    {
        $token = $this->requestStack->getMasterRequest()->get($annotation->param);

        return $this->csrfManager->isTokenValid(
            new CsrfToken($annotation->intention, $token)
        );
    }
} 