<?php

namespace spec\Morch\Maybe;

use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class SomeSpec extends ObjectBehavior
{
	public function let(Value $value)
	{
		$this->beConstructedWith($value);
	}

    public function it_calls_methods_on_its_value(Value $value)
    {
    	$this->someMethod();

    	$value->someMethod()->shouldBeCalled();
    }

    public function it_unwraps_its_value(Value $value)
    {
    	$this->unwrap()->shouldReturn($value);
    }

    public function it_unwraps_its_value_though_given_a_default(Value $value)
    {
        $this->unwrap('foo')->shouldReturn($value);
    }

    public function it_can_tell_if_its_a_value(Value $value)
    {
    	$this->is()->shouldReturn(true);
    }

    public function it_returns_some_when_method_call_has_none_null_result(Value $value)
    {
    	$value->someMethod()->willReturn('some');

    	$this->someMethod()->shouldReturnAnInstanceOf('\Morch\Maybe\Some');
    }

    public function it_returns_none_when_method_call_has_null_result(Value $value)
    {
    	$value->someMethod()->willReturn(null);

    	$this->someMethod()->shouldReturnAnInstanceOf('\Morch\Maybe\None');
    }

    public function it_can_force_unwrapping_of_a_returned_value(Value $value)
    {
    	$value->someMethod()->willReturn('foo');

    	$this->callOnWrappedObject('__call', ['someMethod_', []])->shouldReturn('foo');
    }

    public function it_returns_some_when_accessing_a_none_null_attribute(Value $value)
    {
    	$this->callOnWrappedObject('__get', ['foo'])->shouldReturnAnInstanceOf('Morch\Maybe\Some');
    }

    public function it_returns_none_when_accessing_a_null_attribute(Value $value)
    {
    	$this->callOnWrappedObject('__get', ['bar'])->shouldReturnAnInstanceOf('Morch\Maybe\None');
    }

    public function it_can_force_unwrapping_of_an_attribute(Value $value)
    {
    	$this->callOnWrappedObject('__get', ['foo_'])->shouldReturn('bar');
    }

    public function it_can_set_an_attribute_on_its_value(Value $value)
    {
    	$this->callOnWrappedObject('__set', ['foo', 'baz']);

    	$this->callOnWrappedObject('__get', ['foo_'])->shouldReturn('baz');
    }
}

class Value
{
	public $foo = 'bar';

	public $bar;

	public function someMethod() { return 'foo'; }
}
