<?php
/**
 * Created by PhpStorm.
 * User: sabloger
 * Date: 7/11/17
 * Time: 11:38 AM
 */

namespace Php_Strict\Exceptions;


use Throwable;

class InvalidItemTypeException extends \Exception
{
    public function __construct($itemType , $exceptedType)
    {
        $message = 'Invalid item type exception: Excepted type was "exp_type" given "item_type"!';
        $message = str_replace('exp_type' , $exceptedType , $message);
        $message = str_replace('item_type' , $itemType , $message);
        parent::__construct($message);
    }
}