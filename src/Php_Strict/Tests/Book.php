<?php
/**
 * Created by PhpStorm.
 * User: sabloger
 * Date: 7/10/17
 * Time: 1:26 PM
 */

namespace Php_Strict\Tests;

use Php_Strict\BaseObject;
use Php_Strict\Object;

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
            'title' => 'string',
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
     * @return bool
     */
    protected function isUndefinedSettingAllowed()
    {
        return false;
    }
}