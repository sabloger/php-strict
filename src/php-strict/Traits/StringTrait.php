<?php
/**
 * Created by PhpStorm.
 * User: sabloger
 * Date: 7/11/17
 * Time: 10:47 AM
 */

namespace App\Objects\Traits;


trait StringTrait
{

    /**
     * @return string
     */
    function __toString()
    {
        return json_encode($this->toArray());
    }
}