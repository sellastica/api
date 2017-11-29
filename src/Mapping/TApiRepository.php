<?php
namespace Sellastica\Api\Mapping;

use Sellastica\Core\Collection;
use Sellastica\Entity\Configuration;
use Sellastica\Entity\Entity\EntityCollection;

/**
 * @property TApiDao $dao
 * @method initialize($entities, $first = null, $second = null)
 */
trait TApiRepository
{
	/**
	 * @param Collection $filters
	 * @param Configuration $configuration
	 * @return \Sellastica\Entity\Entity\EntityCollection
	 */
	public function filterByApiEndpointFilters(
		Collection $filters,
		Configuration $configuration = null
	): EntityCollection
	{
		$entities = $this->dao->filterByApiEndpointFilters($filters, $configuration);
		return $this->initialize($entities);
	}

	/**
	 * @param Collection $filters
	 * @return int
	 */
	public function findCountByApiEndpointFilters(Collection $filters): int
	{
		return $this->dao->findCountByApiEndpointFilters($filters);
	}
}