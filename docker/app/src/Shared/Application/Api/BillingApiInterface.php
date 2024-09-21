<?php
declare(strict_types=1);


namespace App\Shared\Application\Api;

use App\Shared\Infrastructure\Api\Billing\VO\TransactionVO;
use Psr\Http\Message\ResponseInterface;

interface BillingApiInterface
{
    public function getAccount(string $userId): ResponseInterface;

    public function addAccountTransaction(TransactionVO $transactionVO, string $userId): ResponseInterface;
}