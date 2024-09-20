<?php
declare(strict_types=1);


namespace App\Shared\Infrastructure\Services\Billing\Contracts;

use App\Shared\Infrastructure\Services\Billing\Api\VO\TransactionVO;
use Psr\Http\Message\ResponseInterface;

interface ApiInterface
{
    public function getAccount(string $userId): ResponseInterface;

    public function addAccountTransaction(TransactionVO $transactionVO, string $userId): ResponseInterface;
}