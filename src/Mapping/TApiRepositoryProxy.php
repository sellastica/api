<?php
namespace Sellastica\Api\Mapping;

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
		\Sellastica\Core\Model\Collection $filters,
		Configuration $configuration = null
	): EntityCollection
	{
		return $this->getRepository()->filterByApiEndpointFilters($filters, $configuration);
	}

	/**
	 * {@inheritDoc}
	 */
	public function findCountByApiEndpointFilters(\Sellastica\Core\Model\Collection $filters): int
	{
		return $this->getRepository()->findCountByApiEndpointFilters($filters);
	}
}