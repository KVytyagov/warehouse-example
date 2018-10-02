<?php

declare(strict_types=1);

namespace KVytyagov\WarehouseExample\EventListener;

use Doctrine\Common\Annotations\AnnotationReader;
use KVytyagov\WarehouseExample\Annotation\WarehouseAuth;
use KVytyagov\WarehouseExample\Exception\WarehouseAuthException;
use KVytyagov\WarehouseExample\Model\LoginInterface;
use KVytyagov\WarehouseExample\Service\Authorization\AuthServiceInterface;
use ReflectionObject;
use Symfony\Component\HttpKernel\Event\FilterControllerEvent;
use Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException;
use Symfony\Component\HttpKernel\Exception\HttpExceptionInterface;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;

class WarehouseAuthAnnotationListener
{
    /**
     * @var AnnotationReader
     */
    private $reader;

    /**
     * @var TokenStorageInterface
     */
    private $tokenStorage;

    /**
     * @var AuthServiceInterface
     */
    private $authService;

    /**
     * WarehouseAuthAnnotationListener constructor.
     *
     * @param AnnotationReader      $reader
     * @param TokenStorageInterface $tokenStorage
     * @param AuthServiceInterface  $authService
     */
    public function __construct(AnnotationReader $reader, TokenStorageInterface $tokenStorage, AuthServiceInterface $authService)
    {
        $this->reader = $reader;
        $this->tokenStorage = $tokenStorage;
        $this->authService = $authService;
    }

    /**
     * @param FilterControllerEvent $event
     */
    public function onKernelController(FilterControllerEvent $event)
    {
        $login = $this->getLogin();

        $controller = $event->getController();
        if (!\is_array($controller)) {
            return;
        }

        $annotation = $this->findWarehouseAuthAnnotation($controller[0], $controller[1]);

        if (null === $annotation) {
            return;
        }

        try {
            $this->authService->auth($annotation->type, $login);
        } catch (WarehouseAuthException $e) {
            throw $this->createAccessDeniedException($e->getMessage(), $e);
        }
    }

    /**
     * @throws HttpExceptionInterface
     *
     * @return LoginInterface
     */
    private function getLogin(): LoginInterface
    {
        $token = $this->tokenStorage->getToken();
        $user = null === $token ? null : $token->getUser();

        if (!$user instanceof LoginInterface) {
            throw $this->createAccessDeniedException('You need to log in');
        }

        return $user;
    }

    /**
     * @param object $controller
     * @param string $methodName
     *
     * @return WarehouseAuth|null
     */
    private function findWarehouseAuthAnnotation(object $controller, string $methodName): ?WarehouseAuth
    {
        $annotationClass = WarehouseAuth::class;

        $controllerReflection = new ReflectionObject($controller);
        $annotation = $this->reader->getClassAnnotation($controllerReflection, $annotationClass);

        if (null === $annotation) {
            $reflectionMethod = $controllerReflection->getMethod($methodName);
            $annotation = $this->reader->getMethodAnnotation($reflectionMethod, $annotationClass);
        }

        return $annotation;
    }

    /**
     * @param string          $msg
     * @param \Throwable|null $previous
     *
     * @return HttpExceptionInterface
     */
    private function createAccessDeniedException(string $msg, \Throwable $previous = null): HttpExceptionInterface
    {
        return new AccessDeniedHttpException($msg, $previous);
    }
}
