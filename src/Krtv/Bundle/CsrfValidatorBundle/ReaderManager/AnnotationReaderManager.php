<?php
/**
 * Created by PhpStorm.
 * User: Krtv
 * Date: 4/11/14
 * Time: 9:55 AM
 */

namespace Krtv\Bundle\CsrfValidatorBundle\ReaderManager;

use Krtv\Bundle\CsrfValidatorBundle\Annotations\Csrf;

use Doctrine\Common\Annotations\Reader;
use Doctrine\Common\Annotations\Annotation;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\Form\Extension\Csrf\CsrfProvider\CsrfTokenManagerAdapter;
use Symfony\Component\HttpFoundation\Request;
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
    protected $reader;

    /**
     * @var Request
     */
    protected $request;

    /**
     * @var
     */
    protected $csrfManager;

    /**
     * @var string
     */
    protected $annotationClass = Csrf::class;

    /**
     * Inject service container to avoid troubles with request object in acceptance tests
     * @param Reader $reader
     * @param $csrfManager
     * @param \Symfony\Component\DependencyInjection\ContainerInterface $container
     */
    public function __construct(Reader $reader, $csrfManager, ContainerInterface $container)
    {
        $this->request = $container->get('request');

        $this->csrfManager = $csrfManager;
        $this->reader = $reader;
    }

    /**
     * @param Request $request
     */
    public function setRequest(Request $request = null)
    {
        $this->request = $request;
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
        $token = $this->request->get($annotation->param);
        $intention = $annotation->intention;

        if ($this->csrfManager instanceof CsrfTokenManagerAdapter) {
            return $this->csrfManager->isCsrfTokenValid($intention, $token);
        } elseif ($this->csrfManager instanceof CsrfTokenManagerInterface) {
            $tokenObject = new CsrfToken($annotation->intention, $token);

            return $this->csrfManager->isTokenValid($tokenObject);
        } else {
            throw new \RuntimeException('Invalid CSRF token manager provided');
        }
    }
} 