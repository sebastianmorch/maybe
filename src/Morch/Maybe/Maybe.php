<?php
namespace Morch\Maybe;

/**
 * Represents an optional value, which can either exist or be null. Any
 * operations performed on the optional, will be handled occording to whether a
 * value exists or not.
 */
abstract class Maybe
{
	/**
	 * Wrap a value in an optional variable.
	 * 
	 * @param  mixed $value
	 * @return \Morch\Maybe\Maybe       
	 */
	static function wrap($value)
	{
		if (is_null($value))
		{
			return new None;
		}

		return new Some($value);
	}

	/**
	 * Determine wether a method call, accessor or mutator forces unwrapping of
	 * the optional value.
	 * 
	 * @param  string $name
	 * @return boolean
	 */
	protected function unwrapping($name)
	{
		return substr($name, -1) === '_';
	}

	/**
	 * Unwrap the optional value.
	 * 
	 * @return mixed
	 * @throws \Morch\Maybe\UnwrappingException
	 */
	abstract public function unwrap();

	/**
	 * Determine wether the optional contains a value.
	 * 
	 * @return boolean
	 */
	abstract public function is();
}