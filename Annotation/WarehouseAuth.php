<?php

declare(strict_types=1);

namespace KVytyagov\WarehouseExample\Annotation;

/**
 * Class WarehouseAuth.
 *
 * @Annotation
 */
final class WarehouseAuth
{
    public const CARD_ACCESS = 'WAREHOUSE_CARD_ACCESS';
    public const GRANDMA_ACCESS = 'WAREHOUSE_GRANDMA_ACCESS';

    /**
     * @return array
     */
    public static function getAccessTypes(): array
    {
        return [
            self::CARD_ACCESS,
            self::GRANDMA_ACCESS,
        ];
    }

    /**
     * @var string
     */
    public $type;
}
