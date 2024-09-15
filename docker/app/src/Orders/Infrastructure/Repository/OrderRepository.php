<?php
declare(strict_types=1);

namespace App\Orders\Infrastructure\Repository;

use App\Orders\Domain\Aggregate\Order\Order;
use App\Orders\Domain\Repository\OrderRepositoryInterface;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

class OrderRepository extends ServiceEntityRepository implements OrderRepositoryInterface
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Order::class);
    }

    public function add(Order $order): void
    {
        $this->getEntityManager()->persist($order);
        $this->getEntityManager()->flush();
    }

    public function findOneByUserId(string $id, string $userId): ?Order
    {
        return $this->findOneBy(['userId' => $userId, 'id' => $id]);
    }

    public function findOneById(string $id): ?Order
    {
        return $this->find($id);
    }

}