<?php namespace Ifnot\Describable;

/**
 * Class Description
 * @package Ifnot\Describable
 */
class Description {

	public $datas = [];

	/**
	 * @param array $datas
	 */
	public function __construct($datas = [])
	{
		$this->datas = $datas;
	}

	/**
	 * @return array
	 */
	public function toArray()
	{
		return $this->datas;
	}

	/**
	 * @return string
	 */
	public function toJson()
	{
		return json_encode($this->datas);
	}

	/**
	 * @return string
	 */
	public function __toString()
	{
		return $this->toJson();
	}
}