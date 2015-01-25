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

```
"requirements": {
  "morch/maybe": "dev-master"
}
```

## Usage

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

As shown above, whatever is returned by the call of `getOtherObject()` is wrapped within an optional value. Any subsequent method invocations made on the optional value, are made throug the wrapper. If value now wrapped within the optional is not null, the method called will simply be called on the wrapped value. Otherwise nothing will happen and no error occurs. 
