<?php
namespace Morch\Maybe;

/**
 * Represents an optional with an existing value. Any operations performed on
 * the optional will be passed on to the underlying value.
 */
final class Some extends Maybe
{
	/**
	 * @var mixed
	 */
	private $value;

	/**
	 * Constructor.
	 * 
	 * @param mixed $value
	 */
	public function __construct($value)
	{
		$this->value = $value;
	}

	/**
	 * Pass calls on to the underlying value.
	 * 
	 * @param  string $method
	 * @param  array $parameters
	 * @return mixed
	 */
	public function __call($method, $parameters)
	{
		list($unwrap, $method) = $this->prepare($method);

		$value = call_user_func_array([$this->value, $method], $parameters);

		return $this->result($value, $unwrap);
	}

	/**
	 * Pass a get on to the underlying value.
	 * 
	 * @param  string $attribute
	 * @return mixed
	 */
	public function __get($attribute)
	{
		list($unwrap, $attribute) = $this->prepare($attribute);

		$value = $this->value->{$attribute};

		return $this->result($value, $unwrap);
	}

	/**
	 * Pass a set on to the underlying value.
	 * 
	 * @param  string $attribute
	 * @param  mixed $value
	 * @return void
	 */
	public function __set($attribute, $value)
	{
		list(, $attribute) = $this->prepare($attribute);

		$this->value->{$attribute} = $value;
	}

	/**
	 * Find out if the return value should be unwrapped, and clean the name of
	 * the method/attribute.
	 * 
	 * @param  string $name
	 * @return array
	 */
	private function prepare($name)
	{
		if ($unwrap = $this->unwrapping($name))
		{
			$name = substr($name, 0, -1);	
		}

		return [$unwrap, $name];
	}

	/**
	 * Get the results of the operation. If unwrapping, the value will be
	 * returned. Otherwise a new optional will be returned.
	 * 
	 * @param  mixed $value
	 * @param  boolean $unwrap 
	 * @return mixed
	 */
	private function result($value, $unwrap)
	{
		return $unwrap ? $value : Maybe::wrap($value);
	}

	/**
	 * Unwrap the optional value.
	 * 
	 * @return mixed
	 * @throws \Morch\Maybe\UnwrappingException
	 */
	public function unwrap()
	{
		return $this->value;
	}

	/**
	 * Determine wether the optional contains a value.
	 * 
	 * @return boolean
	 */
	public function is()
	{
		return true;
	}
}