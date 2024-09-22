<?php
declare(strict_types=1);


namespace App\Shared\Domain\Service\Billing;

use App\Shared\Application\Api\BillingApiInterface;
use App\Shared\Application\Service\BillingServiceInterface;
use App\Shared\Domain\Service\Billing\Mappers\ResponseMapper;
use App\Shared\Domain\Service\Billing\Response\BasicResponse;
use App\Shared\Infrastructure\Api\Billing\VO\TransactionVO;

class BillingService implements BillingServiceInterface
{
    public function __construct(private readonly BillingApiInterface $api, private readonly ResponseMapper $mapper)
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

    #[\Override] public function getAccountBalance(string $userId): BasicResponse
    {
        $response = $this->api->getAccount($userId);

        return $this->mapper->buildGetAccountBalanceResponse($response);
    }
}