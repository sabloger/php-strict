<?php
/**
 * Created by PhpStorm.
 * User: sabloger
 * Date: 7/11/17
 * Time: 12:36 PM
 */

namespace Php_Strict\Tests;

use Php_Strict\ArrayList;

class BookArrayList extends ArrayList
{
    /**
     * @param array $items
     * @return BookArrayList
     */
    public static function newLib(array $items = [])
    {
        return (new self($items));
    }

    /**
     * BookArrayList constructor.
     * @param array $items
     */
    public function __construct(array $items = [])
    {
        parent::__construct(Book::class, $items);
    }

    /**
     * Validate all of items using Object->validate() and ArrayList each()
     * @throws \Exception
     * @return null|true
     */
    public function validate()
    {
        parent::each(function (Book $item, $key) {
            try {
                $item->validate();
            } catch (\Exception $exception) {
                throw new \Exception(sprintf('ArrayList validation failed at offset (%s) with message: %s' , $key, $exception->getMessage()));
            }
        });
        return true;
    }
}