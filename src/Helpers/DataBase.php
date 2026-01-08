<?php

namespace Nigr\Chat\Helpers;

class DataBase
{
	/**
	 * @param array $queryParams
	 * @param string $key
	 * @return string
	 */
	public function getQueryStringFromQueryParams(array $queryParams, string $key = "select"): string
	{
		if ($queryParams === []) {
			return"";
		}
		if (array_is_list($queryParams)) {
			return "";
		}

		if ($key === "insert") {
			$queryString = $this->formingRequestRowInsert($queryParams);
		} else {
			$queryString = $this->formingRequestRowSelect($queryParams);
		}

		return $queryString;
	}

	/**
	 * @param $queryParams
	 * @return string
	 */
	private function formingRequestRowSelect($queryParams): string
	{
		$queryString = "WHERE ";

		foreach ($queryParams as $key => $param) {
			$queryString .= "$key=:$key AND ";
		}

		return trim($queryString, "AND ");
	}

	/**
	 * @param $queryParams
	 * @return string
	 */
	private function formingRequestRowInsert($queryParams): string
	{
		$columns = "";
		$values = "";

		foreach ($queryParams as $key => $param) {
			$columns .= "$key, ";
			$values .= ":$key, ";
		}

		$columns = trim($columns, ", ");
		$values = trim($values, ", ");

		return "($columns) values($values)";
	}
}
