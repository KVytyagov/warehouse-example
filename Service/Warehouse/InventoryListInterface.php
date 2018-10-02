<?php

declare(strict_types=1);

namespace KVytyagov\WarehouseExample\Service\Warehouse;

use KVytyagov\WarehouseExample\Model\InventoryInterface;
use KVytyagov\WarehouseExample\Model\WarehouseInterface;

interface InventoryListInterface
{
    /**
     * @param WarehouseInterface $warehouse
     *
     * @return iterable|InventoryInterface[]
     */
    public function getInventoryList(WarehouseInterface $warehouse): iterable;
}
