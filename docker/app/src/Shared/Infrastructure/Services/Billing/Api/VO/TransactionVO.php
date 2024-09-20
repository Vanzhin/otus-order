<?php
declare(strict_types=1);


namespace App\Shared\Infrastructure\Services\Billing\Api\VO;

readonly class TransactionVO implements \JsonSerializable
{
    public function __construct(private float $sum, private string $document_id, private string $type)
    {
    }

    public function getSum(): float
    {
        return $this->sum;
    }

    public function getDocumentId(): string
    {
        return $this->document_id;
    }

    public function getType(): string
    {
        return $this->type;
    }

    #[\Override] public function jsonSerialize(): array
    {
        return get_object_vars($this);
    }
}