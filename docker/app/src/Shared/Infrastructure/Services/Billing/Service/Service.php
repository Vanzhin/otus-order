<?php
declare(strict_types=1);


namespace App\Shared\Infrastructure\Services\Billing\Service;

use App\Shared\Infrastructure\Services\Billing\Api\VO\TransactionVO;
use App\Shared\Infrastructure\Services\Billing\Contracts\ApiInterface;
use App\Shared\Infrastructure\Services\Billing\Contracts\ServiceInterface;
use App\Shared\Infrastructure\Services\Billing\Service\Mappers\ResponseMapper;
use App\Shared\Infrastructure\Services\Billing\Service\Response\BasicResponse;

class Service implements ServiceInterface
{
    public function __construct(private readonly ApiInterface $api, private readonly ResponseMapper $mapper)
    {
    }


    #[\Override] public function withdrawFromAccount(TransactionVO $transactionVO, string $userId): BasicResponse
    {
        $request = new TransactionVO(
            -abs($transactionVO->getSum()),
            $transactionVO->getDocumentId(),
            $transactionVO->getType()
        );
        $response = $this->api->addAccountTransaction($request, $userId);

        return $this->mapper->buildBasicResponse($response);
    }

    #[\Override] public function refundIntoAccount(TransactionVO $transactionVO, string $userId): BasicResponse
    {
        $request = new TransactionVO(
            abs($transactionVO->getSum()),
            $transactionVO->getDocumentId(),
            $transactionVO->getType()
        );
        $response = $this->api->addAccountTransaction($request, $userId);

        return $this->mapper->buildBasicResponse($response);
    }

    #[\Override] public function getAccount(string $userId): BasicResponse
    {
        $response = $this->api->getAccount($userId);

        return $this->mapper->buildBasicResponse($response);
    }

    #[\Override] public function getAccountBalance(string $userId,): BasicResponse
    {
        $response = $this->api->getAccount($userId);
        return $this->mapper->buildGetAccountBalanceResponse($response);
    }
}