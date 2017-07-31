<?php
/**
 * Created by PhpStorm.
 * User: sabloger
 * Date: 7/11/17
 * Time: 9:30 AM
 */

namespace Sabloger\Php_Strict\Interfaces;

interface ArrayListInterface
{
    // yek array ya collection az object haee ke hame faghat bayad be yek type object ya instance bashan! hamuni ke avali ke new mishe behesh midan,,,
    // yek method e getType ham dare ke noee item haro mide ke baraye Validate khube!! :-)
    // taze mitune bind beshe ba BaseObject tuye child ha ta ke higher order message bezane va hameye object haro ->Validate kone ;-)

    // TODO mitune bejare Array, Collecton NEGAHDARE va returnesh collection bashe??? bad nista ama dependency hasho ziad mikone o dige gheire laravelia nemitunan estefade konan!!
    // TODO emkane Higher order message ro juri faAl konam ke beshe extendesh kard o method zad o uno ruye hame bezane, va ye method az hameye object ha ro call kone!!

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