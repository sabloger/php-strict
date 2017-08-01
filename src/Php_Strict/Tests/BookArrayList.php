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
    public static function newBook(array $items = [])
    {
        return (new self($items));
    }

    public function __construct(array $items)
    {
        parent::__construct(Book::class, $items);
    }

    public function validate()
    {
        parent::each(function ($item, $key) {
            try {
                $item->validate();
            } catch (\Exception $exception) { //TODO:: str_replace_array male laravel E!!! nemikham dependency be laravel dashte bashe agha!!!
                throw new \Exception(str_replace_array('?', [$key, $exception->getMessage()], 'ArrayList validation failed at offset (?) with message: ?'));
            }
        });
    }
}