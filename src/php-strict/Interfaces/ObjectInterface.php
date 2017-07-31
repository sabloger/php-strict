<?php
/**
 * Created by PhpStorm.
 * User: sabloger
 * Date: 7/10/17
 * Time: 11:46 AM
 */

namespace Sabloger\Php_Strict\Interfaces;


interface ObjectInterface
{
    public function __construct(array $items = null);

    public function toArray();

    public function collect(array $items);

    public function set($key, $value);

    public function get($key);

    public function __get($key);

    public function __set($key, $value);

    function __call($name, $arguments);

    public function field($key, $value = null);

    public function unsetItem($key);

    public function has($key);

    public function keyOf($index);

    public function indexOf($key);

    /**
     * @return array
     */
    public function getFieldsStub();

    /**
     * @return array
     */
    public function getRequiredFields();

    public function validate();

}