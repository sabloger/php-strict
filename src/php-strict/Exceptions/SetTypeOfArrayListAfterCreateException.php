<?php
/**
 * Created by PhpStorm.
 * User: sabloger
 * Date: 7/11/17
 * Time: 11:07 AM
 */

namespace App\Exceptions;


use Throwable;

class SetTypeOfArrayListAfterCreateException extends \Exception
{
    public function __construct($message = "", $code = 0, Throwable $previous = null)
    {
        if(empty($message))
            $message = 'Setting type of Array List after creation is now allowed!';
        parent::__construct($message, $code, $previous);
    }

}