<?php
declare(strict_types=1);


namespace App\Shared\Infrastructure\Services\Billing\Contracts;

use App\Shared\Infrastructure\Services\Billing\Api\VO\TransactionVO;
use App\Shared\Infrastructure\Services\Billing\Service\Response\BasicResponse;

interface ServiceInterface
{
    public function getAccount(string $userId): BasicResponse;

    public function getAccountBalance(string $userId): BasicResponse;

    public function withdrawFromAccount(TransactionVO $transactionVO, string $userId): BasicResponse;

    public function refundIntoAccount(TransactionVO $transactionVO, string $userId): BasicResponse;

}