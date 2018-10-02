<?php

declare(strict_types=1);

namespace KVytyagov\WarehouseExample\Repository;

use KVytyagov\WarehouseExample\Exception\NotFoundException;
use KVytyagov\WarehouseExample\Model\InventoryInterface;
use KVytyagov\WarehouseExample\Model\ProductInterface;
use KVytyagov\WarehouseExample\Model\WarehouseInterface;

interface InventoryRepositoryInterface
{
    /**
     * @param WarehouseInterface $warehouse
     * @param iterable           $products
     *
     * @return iterable|InventoryInterface[]
     */
    public function getListByWarehouse(WarehouseInterface $warehouse, iterable $products = []): iterable;

    /**
     * @param WarehouseInterface $warehouse
     * @param ProductInterface   $product
     *
     * @throws NotFoundException
     *
     * @return InventoryInterface
     */
    public function getProductByWarehouse(WarehouseInterface $warehouse, ProductInterface $product): InventoryInterface;
}
