<?php

namespace Libs;

use Libs\HttpQueryString;
use ArrayObject;

class LengthAwarePaginator extends ArrayObject
{
	public int $onEachSide = 3;
	public int $lastPage = 1;
	public string $queryString = "";
	public string|null $fragment = null;

	public function __construct(
		public array $records,
		public int $total,
		public int $perPage = 10,
		public int $currentPage = 1,
	) {
		$this->setData();
	}

	protected function setData(): void {
		foreach($this->records as $record) {
			$this->append($record);
		}
		unset($this->records);
		$this->lastPage = (int) ceil($this->total / $this->perPage);
		if ($this->currentPage > $this->lastPage) {
			$this->currentPage = $this->lastPage > 0 ? $this->lastPage : 1;
		}
		$this->setQueryString();
	}

	protected function setQueryString(): void
	{
		$queries = (new HttpQueryString)->get() ?? [];
		unset($queries["page"]);
		$queryString = http_build_query($queries);
		$queryString = strlen($queryString) > 0 ? $queryString  . "&" : "";
		$this->queryString = $queryString;
	}

	public function onEachSide(int $onEachSide): self
	{
		$this->onEachSide = $onEachSide;
		return $this;
	}

	public function fragment(string|null $fragment = null): self
	{
		$this->fragment = $fragment;
		return $this;
	}

	public function links(): void
	{
		view("pagination", ["total" => $this->total, "linkItems" => $this->linkItems()])->render();
	}

	public function getPageUrl(int $page): string
	{
		return "?" . $this->queryString . "page=" . $page . (is_null($this->fragment) ? "" : "#" . $this->fragment);
	}

	public function linkItems(): array
	{
		// Previous
		$linkItems = [new LinkItem([
			"url" => $this->currentPage === 1 ? null : $this->getPageUrl($this->currentPage - 1),
			"label" => "&laquo; Previous",
			"active" => false,
		])];
		// Each pages
		for ($i = 1; $i <= $this->lastPage; $i++) {
			if ($i < $this->currentPage - $this->onEachSide - 1 || $i > $this->currentPage + $this->onEachSide + 1) {
				continue;
			}
			if ($i === $this->currentPage - $this->onEachSide - 1 || $i === $this->currentPage + $this->onEachSide + 1) {
				$linkItems[] = new LinkItem(["url" => null, "label" => "...", "active" => false]);
				continue;
			}
			$linkItems[] = new LinkItem([
				"url" => $this->getPageUrl($i), "label" => (string) $i, "active" => $i === $this->currentPage]);
		}
		// Next
		$linkItems[] = new LinkItem([
			"url" => $this->currentPage >= $this->lastPage ? null : $this->getPageUrl($this->currentPage + 1),
			"label" => "Next &raquo;",
			"active" => false,
		]);
		return $linkItems;
	}
}
