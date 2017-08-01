<?php
/**
 * Created by PhpStorm.
 * User: sabloger
 * Date: 7/11/17
 * Time: 12:46 PM
 */

namespace Php_Strict\Exceptions;


use Throwable;

class SettingUndefinedFieldIsNotAllowed extends \Exception
{
    public function __construct($message = "", $code = 0, Throwable $previous = null)
    {
        if(empty($message))
            $message = 'Setting value for undefined field is not allowed!';
        parent::__construct($message, $code, $previous);
    }

}