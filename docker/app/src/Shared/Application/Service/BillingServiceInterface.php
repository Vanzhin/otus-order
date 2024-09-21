<?php
declare(strict_types=1);


namespace App\Shared\Application\Service;

use App\Shared\Domain\Service\Billing\Response\BasicResponse;
use App\Shared\Infrastructure\Api\Billing\VO\TransactionVO;

interface BillingServiceInterface
{
    public function getAccount(string $userId): BasicResponse;

    public function getAccountBalance(string $userId): BasicResponse;

    public function withdrawFromAccount(TransactionVO $transactionVO, string $userId): BasicResponse;

    public function refundIntoAccount(TransactionVO $transactionVO, string $userId): BasicResponse;

}