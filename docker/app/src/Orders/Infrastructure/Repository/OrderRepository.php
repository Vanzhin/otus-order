<?php
declare(strict_types=1);

namespace App\Orders\Infrastructure\Repository;

use App\Billings\Domain\Aggregate\Account\Account;
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

    public function findByUserId(string $userId): ?Account
    {
        return $this->findOneBy(['userId' => $userId]);
    }

    public function findOneById(string $id): ?Account
    {
        return $this->find($id);
    }

}