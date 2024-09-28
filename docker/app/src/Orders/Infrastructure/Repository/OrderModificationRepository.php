<?php
declare(strict_types=1);

namespace App\Orders\Infrastructure\Repository;

use App\Orders\Domain\Aggregate\Order\OrderModification;
use App\Orders\Domain\Repository\OrderModificationRepositoryInterface;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

class OrderModificationRepository extends ServiceEntityRepository implements OrderModificationRepositoryInterface
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, OrderModification::class);
    }

    public function add(OrderModification $orderModification): void
    {
        $this->getEntityManager()->persist($orderModification);
        $this->getEntityManager()->flush();
    }

}