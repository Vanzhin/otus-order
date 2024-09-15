<?php
declare(strict_types=1);

namespace App\Orders\Infrastructure\Controller;


use App\Billings\Application\UseCase\Command\CreateAccount\CreateAccountCommand;
use App\Billings\Application\UseCase\Query\FindAccount\FindAccountQuery;
use App\Orders\Application\UseCase\Command\CreateOrder\CreateOrderCommand;
use App\Shared\Application\Command\CommandBusInterface;
use App\Shared\Application\Query\QueryBusInterface;
use App\Shared\Domain\Service\AssertService;
use App\Shared\Domain\Service\RequestHeadersService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/order', name: 'app_api_order')]
class OrderController extends AbstractController
{
    public function __construct(
        private readonly QueryBusInterface     $queryBus,
        private readonly CommandBusInterface   $commandBus,
        private readonly RequestHeadersService $headersService,
    )
    {
    }

    #[Route('', name: 'create', methods: ['POST'])]
    public function add(Request $request): JsonResponse
    {
        $data = json_decode($request->getContent(), true);
        $sum = $data['sum'] ?? null;
        AssertService::numeric($sum, 'No order\'s sum provided');
        $userUlid = $this->headersService->getUserUlid();
        AssertService::notNull($userUlid, 'No user\'s id provided.');
        $command = new CreateOrderCommand($userUlid, $sum);
        $result = $this->commandBus->execute($command);

        return new JsonResponse($result);
    }

    #[Route('', name: 'find_by_user_id', methods: ['GET'])]
    public function getByUserId(): JsonResponse
    {
        $userUlid = $this->headersService->getUserUlid();
        AssertService::notNull($userUlid, 'No user\'s id provided.');
        $query = new FindAccountQuery($userUlid);
        $result = $this->queryBus->execute($query);

        return new JsonResponse($result);
    }
}