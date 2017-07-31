<?php
/**
 * Created by PhpStorm.
 * User: sabloger
 * Date: 7/11/17
 * Time: 10:35 AM
 */

namespace App\Exceptions;


use Throwable;

class StringOffsetException extends \Exception
{
    public function __construct($message = "", $code = 0, Throwable $previous = null)
    {
        if(empty($message))
            $message = 'String offset is not allowed!';
        parent::__construct($message, $code, $previous);
    }
}