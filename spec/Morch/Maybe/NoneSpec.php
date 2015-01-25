<?php

namespace spec\Morch\Maybe;

use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class NoneSpec extends ObjectBehavior
{
	public function it_returns_none_when_a_method_is_called()
	{
		$this->someMethod()->shouldReturnAnInstanceOf('\Morch\Maybe\None');
	}

    public function it_throw_an_exception_when_unwrapped()
    {
    	$this->shouldThrow('\Morch\Maybe\UnwrappingException')->during('unwrap');
    }

    public function it_throw_an_exception_when_forcing_unwrapping_return_value()
    {
    	$this->shouldThrow('\Morch\Maybe\UnwrappingException')->during('someMethod_');
    }

    public function it_return_none_when_accessing_an_attribute()
    {
    	$this->callOnWrappedObject('__get', ['foo'])->shouldReturnAnInstanceOf('\Morch\Maybe\None');
    }

    public function it_throws_an_exception_when_forcing_unwrapping_of_attribute()
    {
    	$this->shouldThrow('\Morch\Maybe\UnwrappingException')->during('__get', ['foo_']);	
    }
}
