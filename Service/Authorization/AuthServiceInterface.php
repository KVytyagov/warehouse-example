<?php

declare(strict_types=1);

namespace KVytyagov\WarehouseExample\Service\Authorization;

use KVytyagov\WarehouseExample\Exception\WarehouseAuthException;
use KVytyagov\WarehouseExample\Model\LoginInterface;

interface AuthServiceInterface
{
    /**
     * @param string         $type
     * @param LoginInterface $login
     *
     * @throws WarehouseAuthException
     */
    public function auth(string $type, LoginInterface $login): void;
}
