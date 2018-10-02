<?php

declare(strict_types=1);

namespace KVytyagov\WarehouseExample\Service\Warehouse;

use KVytyagov\WarehouseExample\Exception\LogicException;
use KVytyagov\WarehouseExample\Exception\NotFoundException;
use KVytyagov\WarehouseExample\Model\InventoryInterface;
use KVytyagov\WarehouseExample\Model\ProductInterface;
use KVytyagov\WarehouseExample\Model\WarehouseInterface;
use KVytyagov\WarehouseExample\Repository\InventoryRepositoryInterface;
use KVytyagov\WarehouseExample\Service\Inventory\ManipulatorInterface;

class WarehouseService implements InventoryListInterface, RetrieverInterface, StorageInterface
{
    /**
     * @var InventoryRepositoryInterface
     */
    private $inventoryRepo;
    /**
     * @var ManipulatorInterface
     */
    private $manipulator;

    /**
     * WarehouseService constructor.
     *
     * @param InventoryRepositoryInterface $inventoryRepo
     * @param ManipulatorInterface         $manipulator
     */
    public function __construct(InventoryRepositoryInterface $inventoryRepo, ManipulatorInterface $manipulator)
    {
        $this->inventoryRepo = $inventoryRepo;
        $this->manipulator = $manipulator;
    }

    /**
     * {@inheritdoc}
     */
    public function getInventoryList(WarehouseInterface $warehouse): iterable
    {
        return $this->inventoryRepo->getListByWarehouse($warehouse);
    }

    /**
     * {@inheritdoc}
     */
    public function retrieve(WarehouseInterface $warehouse, ProductInterface $product, int $amount): RetrieverInterface
    {
        if ($amount < 0) {
            throw $this->createAmountLogicException('retrieve', $amount);
        }
        $inventory = $this->getInventory($warehouse, $product);
        $this->manipulator->modifyAmount($inventory, -$amount);

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function store(WarehouseInterface $warehouse, ProductInterface $product, int $amount): StorageInterface
    {
        if ($amount < 0) {
            throw $this->createAmountLogicException('store', $amount);
        }
        $inventory = $this->getInventory($warehouse, $product);
        $this->manipulator->modifyAmount($inventory, $amount);

        return $this;
    }

    /**
     * @param WarehouseInterface $warehouse
     * @param ProductInterface   $product
     *
     * @throws NotFoundException
     *
     * @return InventoryInterface
     */
    private function getInventory(WarehouseInterface $warehouse, ProductInterface $product): InventoryInterface
    {
        return $this->inventoryRepo->getProductByWarehouse($warehouse, $product);
    }

    /**
     * @param string $action
     * @param int    $amount
     *
     * @return LogicException
     */
    private function createAmountLogicException(string $action, int $amount): LogicException
    {
        return new LogicException(\sprintf('You can\'t %s negative amount %d', $action, $amount));
    }
}
