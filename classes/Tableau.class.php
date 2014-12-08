<?php
class TableauException extends Exception{}

class Tableau implements IteratorAggregate, ArrayAccess {

	private $items;

	public function __construct(array $items) {
		if(!is_array($items)) {
			throw new TableauException("Vous devez renseigner un tableau");
		}

		$this->items = $items;
	}

	public function get($key) {
		if(!$this->has($key)) {
			throw new TableauException("Impossible de trouver '". $key ."' dans le tableau.");
		}

		if(is_array($this->items[$key])) {
			return new Tableau($this->items[$key]);
		}

		return $this->items[$key];
	}

	private function triTableau($key) {

		return function ($a, $b) use ($key) {
			if(
				!is_array($a) OR
				!is_array($b) OR
				!array_key_exists($key, $a) OR
				!array_key_exists($key, $b)

			) {
				return 0;
			}

			return strnatcmp($a[$key], $b[$key]);
		};

	}

	public function sortBy($key) {

		$tab = $this->items;
		
		$isSort = usort($tab, $this->triTableau($key));

		if(!$isSort) {
			return false;
		}

		return new Tableau($tab);

	}

	public function listBy($key) {
		$tab = [];
		foreach ($this->items as $key2 => $value) {
			
			if(is_array($value) AND array_key_exists($key, $value)) {

				$the_key = $value[$key];
				unset($value[$key]);
				$tab[$the_key] = $value;

			}

		}

		return new Tableau($tab);

	}

	public function set($key, $value) {
		$this->items[$key] = $value;
	}

	public function has($key) {
		return array_key_exists($key, $this->items);
	}


	// Implementation Iterator
	public function getIterator(){
		return new ArrayIterator($this->items);
	}

	//	Implementation ArrayAccess
	public function offsetExists($offset) {
		return $this->has($offset);
	}

	public function offsetGet($offset) {
		return $this->get($offset);
	}

	public function offsetSet($offset, $value) {
		return $this->set($offset, $value);
	}

	public function offsetUnset($offset) {
		if(!$this->has($offset)) {
			return false;
		}
		unset($this->items[$offset]);
	}

}

?>