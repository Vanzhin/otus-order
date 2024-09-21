<?php

declare(strict_types=1);


namespace App\Orders\Application\UseCase\Query\FindOrder;

use App\Orders\Application\DTO\Order\OrderDTO;

readonly class FindOrderQueryResult
{
    public function __construct(public ?OrderDTO $order)
    {
    }
}
