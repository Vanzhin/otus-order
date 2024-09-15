<?php

declare(strict_types=1);

namespace App\Orders\Application\DTO\Order;

class OrderDTO
{
    public string $id;
    public string $user_id;
    public float $sum;
    public array $modifications;
}
