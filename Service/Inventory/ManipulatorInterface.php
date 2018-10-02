<?php

declare(strict_types=1);

namespace KVytyagov\WarehouseExample\Service\Inventory;

use KVytyagov\WarehouseExample\Exception\ProductAmountException;
use KVytyagov\WarehouseExample\Model\InventoryInterface;

interface ManipulatorInterface
{
    /**
     * @param InventoryInterface $inventory
     * @param int                $amountModification
     *
     * @throws ProductAmountException
     *
     * @return InventoryInterface
     */
    public function modifyAmount(InventoryInterface $inventory, int $amountModification): InventoryInterface;
}
