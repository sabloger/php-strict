<?php
/**
 * Created by PhpStorm.
 * User: sabloger
 * Date: 7/11/17
 * Time: 9:30 AM
 */

namespace Php_Strict\Interfaces;

interface ArrayListInterface
{
    /**
     * @param string $type
     * @param array $items
     * @return ArrayListInterface
     */
    public static function create($type, array $items = []);

    /**
     * @param array|mixed ...$items
     * @return ArrayListInterface
     */
    public function collect(...$items);

    /**
     * @return string
     */
    public function getType();

    /**
     * @param $item
     * @return ArrayListInterface
     */
    public function push($item); // Age bekham bind beshe ba BaseObject -- inkaro Optional mikonam!!! yani ye validate mizaram ke check mikone age ObjectInterface bood validate kone :)
    // hata mitune extend beshe azash, va un Strict bege ke type e man ine!! va method haye lazem mesle in va push,... ro override mikone!!!

    //injuri hata Scalar type ham mishe dad!!


    /**
     * @return mixed
     */
    public function pop();

    /**
     * @param $item
     * @return ArrayListInterface
     */
    public function append($item);

    /**
     * @param $item
     * @return ArrayListInterface
     */
    public function prepend($item);

    /**
     * @return array
     */
    public function toArray();

    /**
     * Execute a callback over each item.
     *
     * @param  callable $callback
     * @return $this
     */
    public function each(callable $callback);
}