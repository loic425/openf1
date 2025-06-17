<?php

declare(strict_types = 1);

namespace App\State;

use App\Resource\SessionResource;
use Sylius\Resource\Context\Context;
use Sylius\Resource\Context\Option\RequestOption;
use Sylius\Resource\Metadata\Operation;
use Sylius\Resource\State\ProviderInterface;
use Symfony\Contracts\HttpClient\HttpClientInterface;
use Webmozart\Assert\Assert;

class SessionItemProvider implements ProviderInterface
{
    public function __construct(
        private HttpClientInterface $openF1Client,
    )
    {
    }

    public function provide(Operation $operation, Context $context): SessionResource|null
    {
        $request = $context->get(RequestOption::class)?->request();
        Assert::notNull($request);

        $id = $request->attributes->getString('id');

        $query['session_key'] = $id;

        $result = $this->openF1Client->request(method: 'GET', url: '/v1/sessions', options: ['query' => $query])->toArray()[0];

        return  new SessionResource(
                id: $result['session_key'],
                year: (string) $result['year'],
                location: $result['location'],
                countryCode: $result['country_code'],
                circuitShortName: $result['circuit_short_name'],
                sessionName: $result['session_name'],
                startsAt: new \DateTimeImmutable($result['date_start']),
                endsAt: new \DateTimeImmutable($result['date_end']),
            );
    }
}