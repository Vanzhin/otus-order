<?php
declare(strict_types=1);


namespace App\Shared\Infrastructure\Services\Billing\Api;

use App\Shared\Infrastructure\Services\Billing\Api\VO\TransactionVO;
use App\Shared\Infrastructure\Services\Billing\Contracts\ApiInterface;
use GuzzleHttp\RequestOptions;
use Psr\Http\Message\ResponseInterface;

final class Api extends \GuzzleHttp\Client implements ApiInterface
{
    private const string URI_CREATE_ACCOUNT_TRANSACTION = '/billing/account/transaction';
    private const string URI_GET_ACCOUNT = '/billing/account';


    #[\Override] public function addAccountTransaction(TransactionVO $transactionVO, string $userId): ResponseInterface
    {
        return $this->post(self::URI_CREATE_ACCOUNT_TRANSACTION,
            [
                RequestOptions::HEADERS => $this->addXUserHeader($userId),
                RequestOptions::BODY => $transactionVO
            ]
        );
    }

    #[\Override] public function getAccount(string $userId): ResponseInterface
    {
        return $this->get(self::URI_GET_ACCOUNT,
            [
                RequestOptions::HEADERS => $this->addXUserHeader($userId),
            ]
        );
    }

    private function addXUserHeader(string $userId, array $headers = [],): array
    {
        $headers['X-User'] = json_encode(['ulid' => $userId]);
        return $headers;
    }
}