<?php namespace Ifnot\Describable;

/**
 * Class Describer
 * @package Ifnot\Describable
 */
class Describer {
	/**
	 * @var mixed
	 */
	protected $entity;

	/**
	 * @param $description
	 *
	 * @return mixed
	 */
	public static function getModel($description)
	{
		if(is_a($description, 'Ifnot\Describable\Description'))
			$description = $description->toArray();

		$class = $description['entity-class'];
		$id = $description['entity-id'];

		return $class::find($id);
	}

	/**
	 * @param $description
	 * @param $value
	 */
	public static function setProperty($description, $value)
	{
		if(is_a($description, 'Ifnot\Describable\Description'))
			$description = $description->toArray();

		$property = $description['entity-property'];

		$model = self::getModel($description);
		$model->$property = $value;
		$model->save();
	}

	/**
	 * @param $description
	 *
	 * @return mixed
	 */
	public static function getProperty($description)
	{
		if(is_a($description, 'Ifnot\Describable\Description'))
			$description = $description->toArray();

		$property = $description['entity-property'];

		$model = self::getModel($description);
		return $model->$property;
	}

	/**
	 * @param      $entity
	 */
	public function __construct($entity)
	{
		$this->entity = $entity;
	}

	/**
	 * @param $method
	 * @param $arguments
	 *
	 * @return Description
	 */
	public function __call($method, $arguments)
	{
		return $this->describeProperty($method);
	}

	/**
	 * @param $property
	 *
	 * @return Description
	 */
	public function __get($property)
	{
		return $this->describeProperty($property);
	}

	/**
	 * @param $property
	 *
	 * @return Description
	 */
	protected function describeProperty($property)
	{
		return new Description(array_merge($this->describeModel()->toArray(), [
			'entity-property' => $property
		]));
	}

	/**
	 * @return Description
	 */
	protected function describeModel()
	{
		return new Description([
			'entity-class' => get_class($this->entity),
			'entity-id' => $this->entity->id,
			'entity-meta' => $this->getCustomMetas()
		]);
	}

	/**
	 * @param null $property
	 *
	 * @return array
	 */
	protected function getCustomMetas($property = null)
	{
		if(method_exists($this->entity, 'getDescribeMetas')) {
			return $this->entity->getDescribeMetas($property);
		}
		elseif(isset($this->entity->describeMetas)) {
			return $this->entity->describeMetas;
		}
		else {
			return [];
		}
	}
}