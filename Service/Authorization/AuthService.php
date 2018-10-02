<?php

declare(strict_types=1);

namespace KVytyagov\WarehouseExample\Service\Authorization;

use KVytyagov\WarehouseExample\Exception\WarehouseAuthException;
use KVytyagov\WarehouseExample\Model\LoginInterface;
use Symfony\Component\Security\Core\Authorization\AuthorizationCheckerInterface;

class AuthService implements AuthServiceInterface
{
    /**
     * @var AuthorizationCheckerInterface
     */
    private $authChecker;

    /**
     * {@inheritdoc}
     */
    public function __construct(AuthorizationCheckerInterface $authChecker)
    {
        $this->authChecker = $authChecker;
    }

    /**
     * {@inheritdoc}
     */
    public function auth(string $type, LoginInterface $login): void
    {
        if (!$this->authChecker->isGranted([$type], $login)) {
            throw new WarehouseAuthException(\sprintf(
                'User %s has not access to warehouse type %s',
                $login->getUsername(),
                $type
            ));
        }
    }
}
