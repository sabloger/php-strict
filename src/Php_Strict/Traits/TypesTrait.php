<?php
/**
 * Created by PhpStorm.
 * User: sabloger
 * Date: 7/11/17
 * Time: 5:24 PM
 */

namespace Php_Strict\Traits;


trait TypesTrait
{

    static $TYPE_ANY = 'any';

    /**
     * @var array
     */
    static $TYPES_MAP = [
        'int' => 'integer',
        'str' => 'string'
    ];


    /**
     * @param string $type
     * @return string
     */
    protected function getUnifiedType($type)
    {
        return key_exists($type, self::$TYPES_MAP) !== false ? self::$TYPES_MAP[$type] : $type;
    }

    /**
     * @param mixed $item
     * @param string $excepted_type
     * @return bool
     */
    protected function checkType($item, $excepted_type)
    {
        if(empty($excepted_type) || $excepted_type == self::$TYPE_ANY)
            return true;
        $ue_type = $this->getUnifiedType($excepted_type);
        $type = gettype($item);
        if ($type == 'object')
            return $item instanceof $ue_type;
        else
            return $type == $ue_type;

    }

    /**
     * @param mixed $item
     * @return string
     */
    protected function getItemType($item)
    {
        $type = gettype($item);
        if ($type == 'object')
            return get_class($item);
        else
            return $type;
    }
}