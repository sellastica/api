<?php
namespace Sellastica\Api\Mapping;

use Sellastica\Entity\Configuration;
use Sellastica\Entity\Entity\EntityCollection;

/**
 * @property TApiDao $dao
 * @method initialize($entities, $first = null, $second = null)
 */
trait TApiRepository
{
	/**
	 * @param \Sellastica\Core\Model\Collection $filters
	 * @param Configuration $configuration
	 * @return \Sellastica\Entity\Entity\EntityCollection
	 */
	public function filterByApiEndpointFilters(
		\Sellastica\Core\Model\Collection $filters,
		Configuration $configuration = null
	): EntityCollection
	{
		$entities = $this->dao->filterByApiEndpointFilters($filters, $configuration);
		return $this->initialize($entities);
	}

	/**
	 * @param \Sellastica\Core\Model\Collection $filters
	 * @return int
	 */
	public function findCountByApiEndpointFilters(\Sellastica\Core\Model\Collection $filters): int
	{
		return $this->dao->findCountByApiEndpointFilters($filters);
	}
}