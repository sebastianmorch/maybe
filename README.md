# Maybe
Maybe is a package that allows you to use optional variables in your code. Optional values have many benefits. For instance they will allow you to chain method calls without risking invoking a method in a null object. This example is illustrated below.
```php
class MyClass
{
  private $someObject = SomeObject(); 
  
  public function aMethod()
  {
    $this->someObject->getOtherObject()->someMethod();
  }
}
```
If the call to to `getOtherObject()` returns `null` the following call to `someMethod()` would cause an error. To avoid this, you would have to check the value returned from `getOtherObject()` before calling `someMethod()` as shown below.
```php
class MyClass
{
  private $someObject = SomeObject(); 
  
  public function aMethod()
  {
    $otherObject = $this->someObject->getOtherObject();
    
    if ($otherObject)
    {
      $otherObject->someMethod();
    }
  }
}
```
Guarding method calls like this can quickly make your code cluttered and harder to read. You can prevent this using an optional variable as shown below.

## Installation
The package is most easily installed using composer. It can be done through the command line as follows:
```
composer require morch/maybe:dev-master
```
Or by adding it to the requirements in your composer.json file:
```json
"require": {
  "morch/maybe": "dev-master"
}
```

## Usage
An optional will either contain `Some` value or `None`. In other words, in will be an instance of `None` when there is no value, or an instance of `Some`, which will contain the value. Invoking methods or getting and setting attributes on the contained value, is done safely through the optional.

### Wrapping a value
To create an optional, simply wrap something within one, like below.
```php
$optional = Maybe::wrap($value);
```

If `$value` is `null`, the $optional will be a `None`, otherwise it will be a `Some` containing the value.

### Optional method chaining
The problem introduced earlier can be solved unsing optionals an optional method chaining. Wether the optional is a `Some` or a `None`, it can be used without running the risk of errors.
```php
use Morch\Maybe\Maybe 

class MyClass
{
  private $someObject = SomeObject();
  
  public function aMethod()
  {
    Maybe::wrap($this->someObject->getOtherObject())->someMethod();
  }
}
```
As shown above, whatever is returned by the call of `getOtherObject()` is wrapped within an optional value. Any subsequent method invocations made on the optional value, are made throug the wrapper. If the optional is `Some`, the method called will simply be called on the wrapped value. Otherwise nothing will happen and no error occurs.

### Return values
Values returned when getting attributes or calling methods on an optional value, returns an optional value.

If the optional is a `Some` and the method called returns an object, that object will be wrapped in an optional, and a `Some` will be returned containing the object. Conversely, if the method returns `null` a `None` is returned.

Then calling a method on, or getting an attribute from, a `None` will always return a `None`.

### Unwrapping
Sometimes you just need to get to the underlying value of a on optional. The value can be unwrapped as shown below.
```php
$value = $optional->unwrap();
```
When calling a method or getting an attribute, the returned optional can be unwrapped immediately. To do this, you simply add an underscore to the end of the attribute or method name like so:
```php
$result = $optional->someMethod_();
```
When unwrapping an optional, an exception will be thrown, if the optional is a `None`, so unwrapping should only be used when you are sure it contains a value. Sometimes this will be clear from the code, but when it's not, you can call the `is()` method on the optional. It will return `true` if the optional contains a value an `false` if not.
