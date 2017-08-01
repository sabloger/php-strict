<?php
/**
 * Created by PhpStorm.
 * User: sabloger
 * Date: 7/10/17
 * Time: 1:26 PM
 */

namespace Php_Strict\Tests;

use Php_Strict\BaseObject;

/**
 * Class Book
 * @package App\Objects
 * @method setBook()
 */
class Book extends BaseObject
{

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

    /**
     * @return array
     */
    public function getFieldsStub()
    {
        return [
            'title' => 'str',
            'author' => 'string',
            'year' => 'integer'
        ];
    }
}