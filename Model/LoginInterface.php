<?php

declare(strict_types=1);

namespace KVytyagov\WarehouseExample\Model;

use Symfony\Component\Security\Core\User\UserInterface;

interface LoginInterface extends UserInterface, IdModelInterface
{
    /**
     * @return AccessCardInterface|null
     */
    public function getAccessCard(): ?AccessCardInterface;
}
