<?php

namespace nx;

use nx\Exception\NotFound;

class Container implements \ArrayAccess, \Countable{
	private array $keys = [];
	private array $values = [];
	private array $shared = [];
	public function __construct(array|Container $setup=[]){
		foreach($setup as $key => $value){
			$this[$key] =$value;
		}
	}
	public function __invoke(...$args){
		switch(func_num_args()){
			case 0:// =$this() get
				return $this->values;
			case 1:// $this($x) set
				$this->keys = $this->values = [];
				$this->cur = 0;
				foreach($args[0] as $key => $value){
					$this->keys[$key] = true;
					$this->values[$key] = $value;
				}
			//$this->data=$args[0];
			default:// =$this($x, $y, $z , ...)
				//todo nothing
				//$r=[];
				//foreach($args as $arg){
				//	$r[$arg]=$this->data[$arg] ?? null;
				//}
				//return $r;
		}
	}
	public function count(): int{
		return count($this->keys);
	}
	/**
	 * @inheritDoc
	 */
	public function &offsetGet($offset): mixed{
		if(!isset($this->keys[$offset])){
			$a =null;
			return $a;
		//	throw new NotFound(sprintf("key '%s' not found.", $offset));
		}
		if(is_callable($this->values[$offset])
		|| (is_object($this->values[$offset]) && method_exists($this->values[$offset], '__invoke'))){
			$a =$this->values[$offset]($this);
			return $a;
		}
		return $this->values[$offset];
	}
	/**
	 * @inheritDoc
	 */
	public function offsetSet($offset, $value): void{
		$this->keys[$offset] = true;
		$this->values[$offset] = $value;
	}
	/**
	 * @inheritDoc
	 */
	public function offsetExists($offset): bool{
		return array_key_exists($offset, $this->keys);
	}
	/**
	 * @inheritDoc
	 */
	public function offsetUnset($offset): void{
		//todo value是对象并存在需销毁 或 直接上 WeakMap
		unset($this->keys[$offset], $this->values[$offset]);
	}
}