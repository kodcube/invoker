# Invoker for Callable Classes & Methods

This can construct & call a method on a passed passed *classname::method* string. 

This library is great for command bus, event bus or message bus processing, where by just passing a class name and method as a string can be instanciated and executed.


**Examples:** 
"MyClass" is the same as

```PHP
$class = new MyClass();
$class();
```

"MyClass::myMethod" is the same as

```PHP
$class = new MyClass();
$class->myMethod();
```
or if a static method

```PHP
MyClass::myMethod();
```

## Usage

### Construct

```PHP
$invoker = new KodCube\Invoker\Invoker();
```
### Callable Object
```PHP
$invoker = new KodCube\Invoker\Invoker();

$result = $invoker('MyClass');
```
is the same as 

```PHP
$class = new MyClass();
$result = $class();
```


### Public Method on Object

```PHP
$invoker = new KodCube\Invoker\Invoker();

$result = $invoker('MyClass::myMethod');
```
is the same as 

```PHP
$class = new MyClass();
$result = $class->myMethod();
```
### Public Method on Object with constructor arguments

```PHP
$invoker = new KodCube\Invoker\Invoker();

$result = $invoker('MyClass::myMethod',null,['arg1','arg2']);
```
is the same as 

```PHP
$class = new MyClass('arg1','arg2');
$result = $class->myMethod();
```

### Public Method on Object with method arguments

```PHP
$invoker = new KodCube\Invoker\Invoker();

$result = $invoker('MyClass::myMethod',['arg1','arg2']);
```
is the same as 

```PHP
$class = new MyClass();
$result = $class->myMethod('arg1','arg2');
```


### Public Static Method

```PHP
$invoker = new KodCube\Invoker\Invoker();

$result = $invoker('MyClass::myMethod');
```
is the same as 

```PHP
$result = MyClass::myMethod();
```
