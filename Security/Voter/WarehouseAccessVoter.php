<?php

declare(strict_types=1);

namespace KVytyagov\WarehouseExample\Security\Voter;

use KVytyagov\WarehouseExample\Annotation\WarehouseAuth;
use KVytyagov\WarehouseExample\Security\WarehouseAccessVoteHandler\HandlerInterface;
use Psr\Container\ContainerInterface;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Authorization\Voter\VoterInterface;

class WarehouseAccessVoter implements VoterInterface
{
    /**
     * @var ContainerInterface
     */
    private $accessHandlers;
    /**
     * @var int
     */
    private $defaultDecision;

    /**
     * WarehouseAccessVoter constructor.
     *
     * @param ContainerInterface $accessHandlers
     * @param int                $defaultDecision
     */
    public function __construct(ContainerInterface $accessHandlers, int $defaultDecision)
    {
        $this->accessHandlers = $accessHandlers;
        $this->defaultDecision = $defaultDecision;
    }

    /**
     * {@inheritdoc}
     */
    public function vote(TokenInterface $token, $subject, array $attributes)
    {
        $warehouseAuthTypes = \array_intersect(WarehouseAuth::getAccessTypes(), $attributes);
        if (empty($warehouseAuthTypes)) {
            return self::ACCESS_ABSTAIN;
        }

        $decision = $this->defaultDecision;
        foreach ($warehouseAuthTypes as $authType) {
            if (!$this->accessHandlers->has($authType)) {
                continue;
            }

            $handler = $this->accessHandlers->get($authType);
            if (!$handler instanceof HandlerInterface) {
                throw new \LogicException(\sprintf('Voter handler must implements "%s"', HandlerInterface::class));
            }

            $decision = $handler->vote($subject);
            if (self::ACCESS_DENIED === $decision) {
                break;
            }
        }

        return $decision;
    }
}
