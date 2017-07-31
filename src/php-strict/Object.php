<?php
/**
 * Created by PhpStorm.
 * User: sabloger
 * Date: 7/10/17
 * Time: 1:39 PM
 */

namespace Sabloger\Php_Strict;


class Object extends BaseObject
{

    /**
     * @return array
     */
    public function getRequiredFields()
    {
        return [];
    }

    /**
     * @return bool
     */
    protected function isUndefinedSettingAllowed()
    {
        return true;
    }

    /**
     * @return array
     */
    public function getFieldsStub()
    {
        return [];
    }
}