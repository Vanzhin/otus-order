<?php
declare(strict_types=1);


namespace App\Orders\Infrastructure\Serializer;

use App\Orders\Domain\Message\ExternalMessageToForward;
use App\Shared\Domain\Message\MessageInterface;
use Symfony\Component\Messenger\Envelope;
use Symfony\Component\Messenger\Exception\MessageDecodingFailedException;
use Symfony\Component\Messenger\Transport\Serialization\SerializerInterface as MessageSerializerInterface;
use Symfony\Component\Serializer\SerializerInterface;

class ExternalMessageToForwardSerializer implements MessageSerializerInterface
{

    public function __construct(private readonly SerializerInterface $serializer)
    {
    }

    #[\Override] public function decode(array $encodedEnvelope): Envelope
    {
        $body = $encodedEnvelope['body'];
        $headers = $encodedEnvelope['headers'];
        try {
            $message = $this->serializer->deserialize($body, ExternalMessageToForward::class, 'json');
        } catch (\Throwable $throwable) {
            throw new MessageDecodingFailedException($throwable->getMessage());
        }
        $stamps = [];
        if (!empty($headers['stamps'])) {
            $stamps = unserialize($headers['stamps']);
        }

        return new Envelope($message, $stamps);
    }

    #[\Override] public function encode(Envelope $envelope): array
    {
        $message = $envelope->getMessage();
        $stamps = $envelope->all();
        if ($message instanceof MessageInterface) {
            $data = [
                'event_type' => $message->getEventType(),
                'event_data' => $message->getEventData(),

            ];
        } else {
            throw new \Exception(sprintf('Serializer does not support message of type %s.', $message::class));
        }

        return [
            'body' => json_encode($data),
            'headers' => [
                'stamps' => serialize($stamps)
            ]
        ];
    }
}