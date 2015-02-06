<?php namespace Ifnot\Describable;

use Ifnot\Describable\Exceptions\DescriberException;

/**
 * Class DescribableTrait
 * @package Ifnot\Describable
 */
trait DescribableTrait {
	/**
	 * View Describer instance
	 *
	 * @var mixed
	 */
	protected $describerInstance;

	/**
	 * Prepare a new or cached Describer instance
	 *
	 * @param array $options
	 * @return mixed
	 * @throws DescriberException
	 */
	public function describe()
	{
		if (!$this->describerInstance) {
			$this->describerInstance = new Describer($this);
		}

		return $this->describerInstance;
	}
}