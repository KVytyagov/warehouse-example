<?php

declare(strict_types=1);

namespace KVytyagov\WarehouseExample\Security\WarehouseAccessVoteHandler;

interface HandlerInterface
{
    /**
     * @param mixed $subject
     *
     * @return int
     */
    public function vote($subject): int;
}
