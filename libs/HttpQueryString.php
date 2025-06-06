<?php

namespace Libs;

class HttpQueryString
{
	/**
	 * @var	array<string, mixed>	$values
	 */
	protected array $values;

	public function __construct()
	{
		$this->setValues();
	}

	protected function setValues(): void
	{
		$this->values = [];
		if (isset($_GET)) {
			foreach($_GET as $key => $val) {
				$this->values[$key] = $val;
			}
		}
	}

	public function get(string|null $key = null): array|string|null
	{
		if (is_null($key)) {
			return $this->values;
		}
		return $this->has($key) ? $this->values[$key] : null;
	}
}
