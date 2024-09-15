<?php

declare(strict_types=1);


namespace App\Orders\Application\UseCase\Query\FindOrder;

use App\Shared\Application\Query\Query;

readonly class FindOrderQuery extends Query
{
    public function __construct(public string $id, public string $userId)
    {
    }
}
