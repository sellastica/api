<?php
namespace Sellastica\Api\Mapping;

use Sellastica\Core\Collection;
use Sellastica\Entity\Configuration;
use Sellastica\Entity\Entity\EntityCollection;

/**
 * @property TApiDibiMapper $mapper
 * @method EntityCollection getEntitiesFromCacheOrStorage(array $idsArray, $first = null, $second = null)
 */
trait TApiDao
{
	/**
	 * @param Collection $filters
	 * @param Configuration $configuration
	 * @return EntityCollection
	 */
	public function filterByApiEndpointFilters(
		Collection $filters,
		Configuration $configuration = null
	): EntityCollection
	{
		$idsArray = $this->mapper->filterByApiEndpointFilters($filters, $configuration);
		return $this->getEntitiesFromCacheOrStorage($idsArray);
	}

	/**
	 * @param Collection $filters
	 * @return int
	 */
	function findCountByApiEndpointFilters(Collection $filters): int
	{
		return $this->mapper->findCountByApiEndpointFilters($filters);
	}
}