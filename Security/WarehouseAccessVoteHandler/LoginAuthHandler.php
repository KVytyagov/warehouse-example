<?php

declare(strict_types=1);

namespace KVytyagov\WarehouseExample\Security\WarehouseAccessVoteHandler;

use KVytyagov\WarehouseExample\Model\LoginInterface;
use Symfony\Component\Security\Core\Authorization\Voter\VoterInterface;

class LoginAuthHandler implements HandlerInterface
{
    /**
     * {@inheritdoc}
     */
    public function vote($subject): int
    {
        return $subject instanceof LoginInterface
            ? VoterInterface::ACCESS_GRANTED
            : VoterInterface::ACCESS_DENIED
        ;
    }
}
