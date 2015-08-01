<?php
namespace Morch\Maybe;

/**
 * Represents the abscence of a value in an optional. Any operations attempted
 * on the optional, will return a new 'None' optional. Attempting to unwrap the
 * underlying value causes an exception to be thrown.
 */
final class None extends Maybe
{
	/**
	 * Handle method calls.
	 *
	 * @param  string $method
	 * @param  array $parameters
	 * @return \Morch\Maybe\None
	 * @throws \Morch\Maybe\UnwrappingException
	 */
	public function __call($method, $parameters)
	{
		return $this->invoke($method);
	}

	/**
	 * Handle get operations.
	 *
	 * @param  string $attribute
	 * @return \Morch\Maybe\None
	 * @throws \Morch\Maybe\UnwrappingException
	 */
	public function __get($attribute)
	{
		return $this->invoke($attribute);
	}

	/**
	 * Handle set operations.
	 *
	 * @param  string $attribute
	 * @param  mixed $value
	 * @return void
	 * @throws \Morch\Maybe\UnwrappingException
	 */
	public function __set($attribute, $value)
	{
		$this->invoke($attribute);
	}

	/**
	 * Handle the invokation of an operation.
	 *
	 * @param  string $name
	 * @return \Morch\Maybe\None
	 * @throws \Morch\Maybe\UnwrappingException
	 */
	private function invoke($name)
	{
		if ($this->unwrapping($name))
		{
			throw new UnwrappingException('Attempting to force unwrapping of a none-value.');
		}

		return new None;
	}

	/**
	 * Unwrap the optional value.
	 *
	 * @return mixed
	 * @throws \Morch\Maybe\UnwrappingException
	 */
	public function unwrap()
	{
		if ($default = array_pop(func_get_args())) return $default;

		throw new UnwrappingException('Unwrapping a none-value.');
	}

	/**
	 * Determine wether the optional contains a value.
	 *
	 * @return boolean
	 */
	public function is()
	{
		return false;
	}
}
