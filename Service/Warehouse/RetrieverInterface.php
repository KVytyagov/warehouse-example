<?php

declare(strict_types=1);

namespace KVytyagov\WarehouseExample\Service\Warehouse;

use KVytyagov\WarehouseExample\Model\ProductInterface;
use KVytyagov\WarehouseExample\Model\WarehouseInterface;

interface RetrieverInterface
{
    /**
     * @param WarehouseInterface $warehouse
     * @param ProductInterface   $product
     * @param int                $amount
     *
     * @return RetrieverInterface
     */
    public function retrieve(WarehouseInterface $warehouse, ProductInterface $product, int $amount): RetrieverInterface;
}
