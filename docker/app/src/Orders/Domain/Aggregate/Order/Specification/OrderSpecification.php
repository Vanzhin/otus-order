<?php
declare(strict_types=1);


namespace App\Orders\Domain\Aggregate\Order\Specification;

use App\Shared\Domain\Specification\SpecificationInterface;

readonly class OrderSpecification implements SpecificationInterface
{
    public function __construct()
    {
    }
}