<?php
namespace Sellastica\Api\Mapping;

use Sellastica\Api\Mapping\TApiRepository;
use Sellastica\Core\Collection;
use Sellastica\Entity\Configuration;
use Sellastica\Entity\Entity\EntityCollection;

/**
 * @method TApiRepository getRepository()
 */
trait TApiRepositoryProxy
{
	/**
	 * {@inheritDoc}
	 */
	public function filterByApiEndpointFilters(
		Collection $filters,
		Configuration $configuration = null
	): EntityCollection
	{
		return $this->getRepository()->filterByApiEndpointFilters($filters, $configuration);
	}

	/**
	 * {@inheritDoc}
	 */
	public function findCountByApiEndpointFilters(Collection $filters): int
	{
		return $this->getRepository()->findCountByApiEndpointFilters($filters);
	}
}