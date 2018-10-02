<?php

declare(strict_types=1);

namespace KVytyagov\WarehouseExample\Model;

interface InventoryInterface
{
    /**
     * @return ProductInterface
     */
    public function getProduct(): ProductInterface;

    /**
     * @return int
     */
    public function getAmount(): int;
}
