<?php
namespace Sellastica\Api;

use Sellastica\Api\Model\EndpointFilter;
use Sellastica\Core\Collection;

class Utils
{
	/**
	 * @param array $entityFilterDefinitions e.g. array('id' => ['int'], 'full_name' => 'string', ...)
	 * @return array
	 */
	public static function resolveEndpointFilters(array $entityFilterDefinitions): array
	{
		$filters = [];
		foreach ($entityFilterDefinitions as $filter => $type) {
			if (is_array($type)) {
				$type = (string)$type[0];
				$filters[$filter . '_min'] = $type;
				$filters[$filter . '_max'] = $type;
			}

			$filters[$filter] = (string)$type;
		}

		return $filters;
	}

	/**
	 * @param array $candidates
	 * @param array $entityFilterDefinitions
	 * @return \Sellastica\Core\Collection
	 */
	public static function getEndpointFilters(
		array $candidates,
		array $entityFilterDefinitions
	): Collection
	{
		$filters = new Collection();
		$allEntityFilters = self::resolveEndpointFilters($entityFilterDefinitions);
		$validUrlFilters = array_intersect_key($candidates, $allEntityFilters);

		foreach ($validUrlFilters as $field => $value) {
			if ((string)$value !== '') { //avoid filters with empty value
				$filters = $filters->add(new Model\EndpointFilter($field, $value, $allEntityFilters[$field]));
			}
		}

		return $filters;
	}
}