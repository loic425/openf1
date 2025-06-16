<?php

namespace App\Grid\Provider;

use App\Resource\DriverResource;
use App\Resource\TeamRadioResource;
use Pagerfanta\Adapter\ArrayAdapter;
use Pagerfanta\Pagerfanta;
use Pagerfanta\PagerfantaInterface;
use Sylius\Component\Grid\Data\DataProviderInterface;
use Sylius\Component\Grid\Definition\Grid;
use Sylius\Component\Grid\Parameters;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Contracts\HttpClient\HttpClientInterface;

final readonly class TeamRadioApiGridProvider implements DataProviderInterface
{
    public function __construct(
        private HttpClientInterface $openF1Client,
    ) {
    }

    public function getData(Grid $grid, Parameters $parameters): PagerFantaInterface
    {
        $criteria = $parameters->get('criteria', []);

        $teamRadios = iterator_to_array($this->getTeamRadios($criteria));

        // start with an empty paginator
        return new Pagerfanta(new ArrayAdapter($teamRadios));
    }


    private function getTeamRadios(array $criteria): iterable
    {
        $query = ['session_key' => '9158'];

        if (!empty($criteria['driver_number']['value'] ?? null)) {
            $query['driver_number'] = $criteria['driver_number']['value'];
        }

        $responseData = $this->openF1Client->request(method: 'GET', url: '/v1/team_radio', options: ['query' => $query])->toArray();

        foreach ($responseData as $row) {
            yield new TeamRadioResource(
                date: new \DateTimeImmutable($row['date']),
                driverNumber: $row['driver_number'],
                recordingUrl: $row['recording_url'],
            );
        }
    }
}
