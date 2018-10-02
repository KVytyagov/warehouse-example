<?php

declare(strict_types=1);

namespace KVytyagov\WarehouseExample\Service\Warehouse;

use KVytyagov\WarehouseExample\Model\ProductInterface;
use KVytyagov\WarehouseExample\Model\WarehouseInterface;

interface StorageInterface
{
    /**
     * @param WarehouseInterface $warehouse
     * @param ProductInterface   $product
     * @param int                $amount
     *
     * @return StorageInterface
     */
    public function store(WarehouseInterface $warehouse, ProductInterface $product, int $amount): StorageInterface;
}
