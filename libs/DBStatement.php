<?php

namespace Libs;

use Libs\LengthAwarePaginator;
use PDOStatement;

/**
 * PDOStatement のラッパー
 * 
 * pagination対応が目的
 */
class DBStatement extends PDOStatement
{
	public function paginate(int $perPage = 10, int $currentPage = 0): LengthAwarePaginator|null
	{
		$page = (int) ($_GET["page"] ?? null);
		$lastPage = (int) ceil($this->rowCount() / $perPage);
		$page = $page > $lastPage ? $lastPage : $page;
		if ($currentPage === 0) {
			$currentPage = $page > 0 ? $page : 1;
		}
		$records = [];
		$offset = $perPage * ($currentPage - 1);
		$total = $this->rowCount();
		foreach (array_slice($this->fetchAll(), $offset, $perPage) as $row) {
			$records[] = $row;
		}
		return new LengthAwarePaginator($records, $total, $perPage, $currentPage);
	}
}
