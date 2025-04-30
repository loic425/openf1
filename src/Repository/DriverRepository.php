<?php

namespace App\Repository;

use App\Model\Pokemon;
use App\Resource\PokemonResource;
use Countable;
use Pagerfanta\Adapter\ArrayAdapter;
use Pagerfanta\Adapter\FixedAdapter;
use Pagerfanta\Pagerfanta;
use Pagerfanta\PagerfantaInterface;
use Symfony\Contracts\HttpClient\HttpClientInterface;
use Webmozart\Assert\Assert;

final class DriverRepository
{
    private ?int $page = null;

    private ?int $itemsPerPage = null;

    private ?string $countryCode = null;

    public function withCountryCode(string $countryCode): static
    {
        $cloned = clone $this;
        $cloned->countryCode = $countryCode;

        return $cloned;
    }

    public function withPagination(int $page, int $itemsPerPage): static
    {
        Assert::positiveInteger($page);
        Assert::positiveInteger($itemsPerPage);

        $cloned = clone $this;
        $cloned->page = $page;
        $cloned->itemsPerPage = $itemsPerPage;

        return $cloned;
    }

    public function __construct(
        private HttpClientInterface $openF1Client,
    ) {
    }

    public function paginator(): ?PagerfantaInterface
    {
        if (null === $this->page || null === $this->itemsPerPage) {
            return null;
        }

        $query = ['session_key' => 9158];

        if (null !== $this->countryCode) {
            $query['country_code'] = $this->countryCode;
        }

        $responseData = $this->openF1Client->request(method: 'GET', url: '/v1/drivers?session_key=9158', options: [
            'query' => $query
        ])->toArray();

        $paginator = new Pagerfanta(new ArrayAdapter($responseData));
        $paginator->setMaxPerPage($this->itemsPerPage);
        $paginator->setCurrentPage($this->page);

        return $paginator;
    }
}
