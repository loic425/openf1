<?php

namespace App\Grid\Provider;

use App\Resource\SessionResource;
use Pagerfanta\Adapter\ArrayAdapter;
use Pagerfanta\Pagerfanta;
use Pagerfanta\PagerfantaInterface;
use Sylius\Component\Grid\Data\DataProviderInterface;
use Sylius\Component\Grid\Definition\Grid;
use Sylius\Component\Grid\Parameters;
use Symfony\Contracts\HttpClient\HttpClientInterface;

final readonly class SessionApiGridProvider implements DataProviderInterface
{
    public function __construct(
        private HttpClientInterface $openF1Client,
    ) {
    }

    public function getData(Grid $grid, Parameters $parameters): PagerFantaInterface
    {
        $criteria = $parameters->get('criteria', []);

        $teamRadios = iterator_to_array($this->getSessions($criteria));

        // start with an empty paginator
        return new Pagerfanta(new ArrayAdapter($teamRadios));
    }


    private function getSessions(array $criteria): iterable
    {
        $query = [];

        if (!empty($criteria['year']['value'] ?? null)) {
            $query['year'] = $criteria['year']['value'];
        }

        $responseData = $this->openF1Client->request(method: 'GET', url: '/v1/sessions', options: ['query' => $query])->toArray();

        foreach ($responseData as $row) {
            yield new SessionResource(
                id: $row['session_key'],
                year: (string) $row['year'],
                location: $row['location'],
                sessionName: $row['session_name'],
                circuitShortName: $row['circuit_short_name'],
                countryCode: $row['country_code'],
                startsAt: new \DateTimeImmutable($row['date_start']),
                endsAt: new \DateTimeImmutable($row['date_end']),
            );
        }
    }
}
