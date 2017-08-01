<?php
/**
 * Created by PhpStorm.
 * User: sabloger
 * Date: 7/11/17
 * Time: 6:05 PM
 */

namespace Php_Strict\Exceptions;


class RequiredFieldsNotFilledException extends \Exception
{
    public function __construct(array $unfilledFields)
    {
        /*$message = 'Required fields are not filled. Input fields: (in_flds) but required fields was: (re_flds)';
        $message = str_replace('in_flds' , json_encode(array_keys($inputItems)) , $message);
        $message = str_replace('re_flds' , json_encode($requiredItems) , $message);*/

        $message = str_replace('?' , json_encode($unfilledFields),'Required fields are not filled. unfilled required fields: (?)');
        parent::__construct($message);
    }

}