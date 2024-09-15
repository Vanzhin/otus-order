<?php

declare(strict_types=1);

namespace App\Orders\Domain\Aggregate\Order;

enum OrderStatus: string
{
    /*
     * Оформлен.
     */
    case ISSUED = 'issued';

    /*
     * Оплачен.
     */
    case PAID = 'paid';

    /*
     * Доставляется.
     */
    case TRANSFER = 'transfer';
    /*
     * Готов к выдаче.
     */
    case READY_TO_PICK_UP = 'ready to peak up';
    /*
     * Выдан.
     */
    case PICKED_UP = 'peaked up';
    /*
     * Отменен.
     */
    case CANCELED = 'canceled';

    public static function values(): array
    {
        return array_column(self::cases(), 'value');
    }
}
