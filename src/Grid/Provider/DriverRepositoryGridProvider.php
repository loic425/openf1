<?php

namespace App\Grid\Provider;

use App\Repository\DriverRepository;
use App\Resource\DriverResource;
use Pagerfanta\Adapter\FixedAdapter;
use Pagerfanta\Pagerfanta;
use Pagerfanta\PagerfantaInterface;
use Sylius\Component\Grid\Data\DataProviderInterface;
use Sylius\Component\Grid\Definition\Grid;
use Sylius\Component\Grid\Parameters;
use Symfony\Component\HttpFoundation\RequestStack;

final readonly class DriverRepositoryGridProvider implements DataProviderInterface
{
    public function __construct(
        private RequestStack $requestStack,
        private DriverRepository $driverRepository,
    ) {
    }

    public function getData(Grid $grid, Parameters $parameters): PagerFantaInterface
    {
        $page = $this->requestStack?->getCurrentRequest()->query->getInt('page', 1) ?? 1;
        $itemsPerPage = $this->requestStack?->getCurrentRequest()->query->getInt('limit', 10) ?? 10;
        $criteria = $parameters->get('criteria');

        $paginator = $this->getDriversPaginator($page, $itemsPerPage, $criteria);

        $data = [];

        foreach ($paginator as $row) {
            $data[] = new DriverResource(
                number: $row['driver_number'],
                firstName: $row['first_name'],
                lastName: $row['last_name'],
                countryCode: $row['country_code'],
                teamName: $row['team_name'],
                image: $row['headshot_url'],
            );
        }

        return new Pagerfanta(new FixedAdapter($paginator->count(), $data));
    }

    public function getDriversPaginator(int $page, int $itemsPerPage, ?array $criteria): PagerfantaInterface
    {
        $driverRepository = $this->driverRepository;

        if (!empty($criteria['country'] ?? null)) {
            $driverRepository = $driverRepository->withCountryCode($criteria['country']);
        }

        $driverRepository = $driverRepository->withPagination($page, $itemsPerPage);

        return $driverRepository->paginator();
    }
}
