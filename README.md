# php-strict
Strict-typed Object base and Array-List for PHP!

[![License](https://poser.pugx.org/sabloger/php-strict/license.svg)](https://github.com/sabloger/php-strict/blob/master/LICENSE)
[![Packagist](https://img.shields.io/badge/packagist-dev--master-orange.svg)](https://packagist.org/packages/sabloger/php-strict)

## Introduction
- If you need PHP much clearer you'll be happy with Php-Strict!
- If you need a way to pass packed arguments to functions you'll be happy with Php-Strict!
- If you need a way to validate arguments and get rid of exceptions and data-misses on invalid arguments you'll be happy with Php-Strict!
- If you need a strict-typed ArrayList like Java and other strict-typed languages you'll be happy with Php-Strict!

## Installation
Add following code to your `composer.json` and run `composer update`:
```json
{
  "require": {
    "sabloger/php-strict": "dev-master"
  }
}
```

## Usage: Object
First extend one sub class from `BaseObject`, implement parent abstract methods, set predefines, instantiate then use! Finally run `$obj->validate()` for validate data!. For example:
sub-class:
```php
use Php_Strict\BaseObject;

/**
 * Class Book
 * @package Php_Strict
 * @method Book setTitle(string $value)
 * @method Book setAuthor(string $value)
 * @method Book setYear(int $value)
 * @method Book setSome_Object(Object $value)
 * @method string getTitle()
 * @method string getAuthor()
 * @method int getYear()
 * @method Object getSome_Object()
 */
class Book extends BaseObject
{
    /**
     * @return array
     */
    public function getFieldsStub()
    {
        return [
            'title' => 'string', // All of types as you want!!
            'author' => 'string',
            'year' => 'int',
            'some_object' => Object::class
        ];
    }

    /**
     * @return array
     */
    public function getRequiredFields()
    {
        return [
            'title',
            'year'
        ];
    }

    /**
     * If you want to allow setting undefined properties, set it True!
     * @return bool
     */
    protected function isUndefinedSettingAllowed()
    {
        return false;
    }
}
```
* For ease of use and get suggestions on IDE for fields setters and getters, I strongly suggesting write class level docs, as like as above sample.

use:
```php
$book = new Book(["Title" => "Advanced PHP Programming"]); // Its case-insensitive and auto case-correcter!! :)
$book->setAuthor("George Schlossnagle");
$book["Year"] = 2004;

$obj = new Object();
$obj->Foo = "bar";
$obj["foO"] = "BAR"; // Yessss its case-insensitive and auto case-correcter!!  ["Foo": "BAR"]

$book->set("some_object",$obj); // Several access methods!! Use these as you want!!

print $book; // It's echoable!!
//$book->toJson(); // Jsonable :)
//$book->toArray(); // Arrayable :)

foreach ($book as $key => $value) { // Iterateable :)
  echo "key: $key , value: $value \n";
}
/*
Out:
{"title":"Advanced PHP Programming","author":"George Schlossnagle","year":2004,"some_object":{"Foo":"BAR"}}
key: title , value: Advanced PHP Programming 
key: author , value: George Schlossnagle 
key: year , value: 2004 
key: some_object , value: {"Foo":"BAR"} 
*/
```
## LICENSE
This library is released under the [MIT license](https://github.com/sabloger/php-strict/blob/master/LICENSE).
