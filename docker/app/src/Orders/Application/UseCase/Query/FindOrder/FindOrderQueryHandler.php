<?php

declare(strict_types=1);

namespace App\Orders\Application\UseCase\Query\FindOrder;

use App\Orders\Application\DTO\Order\OrderDTOTransformer;
use App\Orders\Domain\Repository\OrderRepositoryInterface;
use App\Shared\Application\Query\QueryHandlerInterface;

readonly class FindOrderQueryHandler implements QueryHandlerInterface
{
    public function __construct(
        private OrderRepositoryInterface $orderRepository,
        private OrderDTOTransformer      $orderDTOTransformer,
    )
    {
    }

    public function __invoke(FindOrderQuery $query): FindOrderQueryResult
    {
        $order = $this->orderRepository->findOneByUserId($query->id, $query->userId);
        if (!$order) {
            return new FindOrderQueryResult(null);
        }
        $orderDTO = $this->orderDTOTransformer->fromAccountEntity($order);

        return new FindOrderQueryResult($orderDTO);
    }
}
