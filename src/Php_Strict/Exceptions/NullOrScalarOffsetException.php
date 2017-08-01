<?php
/**
 * Created by PhpStorm.
 * User: sabloger
 * Date: 7/10/17
 * Time: 12:01 PM
 */

namespace Php_Strict\Exceptions;


use Throwable;

class NullOrScalarOffsetException extends \Exception
{
    public function __construct($message = "", $code = 0, Throwable $previous = null)
    {
        if (empty($message))
            $message = 'Cannot set Null or Scalar offset on fields in Object!';
        parent::__construct($message, $code, $previous);
    }
}