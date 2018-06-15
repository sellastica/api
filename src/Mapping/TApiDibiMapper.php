<?php
namespace Sellastica\Api\Mapping;

use Sellastica\Api\Exception\InvalidApiParameterException;
use Sellastica\Api\Model\EndpointFilter;
use Sellastica\Core\Model\Collection;
use Sellastica\Entity\Configuration;
use Sellastica\Entity\Exception\StorageException;
use Sellastica\Utils\Strings;

/**
 * @method applyConfiguration(\Dibi\Fluent $resource, Configuration $configuration = null)
 * @method fetchArray(\Dibi\Fluent $resource, array $dependentEntities = [])
 * @method \Dibi\Fluent getResourceWithIds(Configuration $configuration = null)
 */
trait TApiDibiMapper
{
	/**
	 * @param Collection $filters
	 * @param Configuration $configuration
	 * @return array
	 * @throws \Sellastica\Api\Exception\InvalidApiParameterException
	 * @throws StorageException
	 */
	public function filterByApiEndpointFilters(
		Collection $filters,
		Configuration $configuration = null
	)
	{
		$resource = $this->getApiResource($filters);
		try {
			$this->applyConfiguration($resource, $configuration);
			return $this->fetchArray($resource);
		} catch (\Dibi\DriverException $e) {
			throw new StorageException($e->getMessage(), $e->getCode(), $e->getPrevious());
		}
	}

	/**
	 * @param Collection $filters
	 * @return int
	 * @throws StorageException
	 */
	public function findCountByApiEndpointFilters(Collection $filters): int
	{
		$resource = $this->getApiResource($filters);
		try {
			return $resource->count();
		} catch (\Dibi\DriverException $e) {
			throw new StorageException($e->getMessage(), $e->getCode(), $e->getPrevious());
		}
	}

	/**
	 * @param Collection $filters
	 * @return \Dibi\Fluent
	 * @throws InvalidApiParameterException
	 */
	protected function getApiResource(Collection $filters)
	{
		$resource = $this->getResourceWithIds();
		foreach ($filters as $filter) {
			/** @var EndpointFilter $filter */
			$column = Strings::toCamelCase(preg_replace('~(.+)(_min|_max)~', '$1', $filter->getField()));
			if ($column === 'createdAt' || $column === 'updatedAt') {
				$column = Strings::before($column, 'At');
			}

			switch ($filter->getType()) {
				case EndpointFilter::INT:
					if (is_numeric($filter->getValue())) {
						$resource->where(
							sprintf('%s %s %s', '%n', $filter->getComparator(), '%i'), $column, $filter->getValue() //%n = %i
						);
						continue;
					}

					throw new InvalidApiParameterException($filter->getField(), EndpointFilter::INT);

					break;
				case EndpointFilter::FLOAT:
					if (is_numeric($filter->getValue())) {
						$resource->where(
							sprintf('%s %s %s', '%n', $filter->getComparator(), '%f'), $column, $filter->getValue() //%n = %f
						);
						continue;
					}

					throw new InvalidApiParameterException($filter->getField(), EndpointFilter::FLOAT);

					break;
				case EndpointFilter::BOOL:
					switch ($filter->getValue()) {
						case 'false':
							$value = false;
							break;
						default:
							$value = (bool)$filter->getValue();
							break;
					}

					$resource->where(
						sprintf('%s = %s', '%n', '%i'), $column, $value //%n = %i
					);
					continue;

					break;
				case EndpointFilter::STRING:
					if (is_string($filter->getValue()) || is_numeric($filter->getValue())) {  //ommit arrays
						$resource->where(
							sprintf('%s %s %s', '%n', $filter->getComparator(), '%s'), $column, $filter->getValue() //%n = %s
						);
						continue;
					}

					throw new InvalidApiParameterException($filter->getField(), EndpointFilter::STRING);

					break;
				default:
					break;
			}
		}

		return $resource;
	}
}