<?php
/**
 * Created by PhpStorm.
 * User: sabloger
 * Date: 7/11/17
 * Time: 9:23 AM
 */

namespace Php_Strict;


use App\Exceptions\InvalidItemTypeException;
use App\Exceptions\SetTypeOfArrayListAfterCreateException;
use App\Exceptions\StringOffsetException;
use Php_Strict\Traits\CountableTrait;
use Php_Strict\Traits\IteratorTrait;
use Php_Strict\Traits\JsonableTrait;
use Php_Strict\Traits\JsonSerializeTrait;
use Php_Strict\Traits\SerializableTrait;
use Php_Strict\Traits\StringTrait;
use Php_Strict\Traits\TypesTrait;
use Php_Strict\Interfaces\Arrayable;
use Php_Strict\Interfaces\ArrayListInterface;
use Php_Strict\Interfaces\Jsonable;

class ArrayList implements ArrayListInterface, \IteratorAggregate, \Serializable, \Countable, \ArrayAccess, Arrayable, Jsonable, \JsonSerializable
{

    use JsonSerializeTrait;
    use JsonableTrait;
    use CountableTrait;
    use StringTrait;
    use IteratorTrait;
    use SerializableTrait;
    use TypesTrait;

    /**
     * @var array
     */
    protected $items;

    /**
     * @var string
     */
    protected $type;


    public static function create($type, array $items = [])
    {
        return (new self($type, $items));
    }

    public function __construct($type, ...$items)
    {
        $this->setType($type);
        if (!empty($items))
            call_user_func_array([$this, 'collect'], $items);
    }

    /**
     * Whether a offset exists
     * @link http://php.net/manual/en/arrayaccess.offsetexists.php
     * @param mixed $offset <p>
     * An offset to check for.
     * </p>
     * @return boolean true on success or false on failure.
     * </p>
     * <p>
     * The return value will be casted to boolean if non-boolean was returned.
     * @since 5.0.0
     */
    public function offsetExists($offset)
    {
        return isset($this->items[$offset]);
    }

    /**
     * Offset to retrieve
     * @link http://php.net/manual/en/arrayaccess.offsetget.php
     * @param mixed $offset <p>
     * The offset to retrieve.
     * </p>
     * @return mixed Can return all value types.
     * @since 5.0.0
     */
    public function offsetGet($offset)
    {
        return isset($this->items[$offset]) ? $this->items[$offset] : null;
    }


    /**
     * Offset to set
     * @link http://php.net/manual/en/arrayaccess.offsetset.php
     * @param mixed $offset <p>
     * The offset to assign the value to.
     * </p>
     * @param mixed $value <p>
     * The value to set.
     * </p>
     * @return int
     * @throws StringOffsetException
     * @throws InvalidItemTypeException
     * @since 5.0.0
     */
    public function offsetSet($offset, $value)
    {
        if (!$this->checkType($value , $this->type))
            throw new InvalidItemTypeException($this->getItemType($value), $this->type);
        if (is_null($offset)) {
            $this->items[] = $value;
            return $this->getLastOffset();
        } elseif (is_numeric($offset)) {
            $this->items[$offset] = $value;
            return $offset;
        } else
            throw new StringOffsetException();
    }

    /**
     * Offset to unset
     * @link http://php.net/manual/en/arrayaccess.offsetunset.php
     * @param mixed $offset <p>
     * The offset to unset.
     * </p>
     * @return void
     * @since 5.0.0
     */
    public function offsetUnset($offset)
    {
        unset($this->items[$offset]);
    }

    public function getLastOffset()
    {
        $last = array_slice($this->items, -1, 1, true);
        reset($last);
        return key($last);
    }

    /* *
     * @param $key
     * @return int

    public function offsetOf($value)
    {
        return array_search($key, array_keys($this->toArray()));
    }
*/

    /**
     * @return array
     */
    public function toArray()
    {
        return $this->items;
    }

    /**
     * @param array|mixed ...$items
     * @return $this
     */
    public function collect(...$items)
    {
        foreach ($items as $item) {
            if (is_array($item)) {
                foreach ($item as $seed) {
                    $this->offsetSet(null, $seed);
                }
            } else
                $this->offsetSet(null, $seed);
        }
        return $this;
    }


    final protected function setType($type)
    {
        if (empty($this->items))
            $this->type = $this->getUnifiedType($type);
        else
            throw new SetTypeOfArrayListAfterCreateException();
    }


    /**
     * @return string
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * @param $item
     * @return int
     */
    public function push($item)
    {
        return $this->offsetSet(null, $item);
    }

    /**
     * @return mixed
     * @throws \Exception
     */
    public function pop()
    {
        throw new \Exception('Dus nadaram felan!!!');
    }

    /**
     * @param $item
     * @return ArrayListInterface
     * @throws \Exception
     */
    public function append($item)
    {
        throw new \Exception('Dus nadaram felan!!!');
    }

    /**
     * @param $item
     * @return ArrayListInterface
     * @throws \Exception
     */
    public function prepend($item)
    {
        throw new \Exception('Dus nadaram felan!!!');
    }


    public function each(callable $callback)
    {
        foreach ($this->items as $key => $item) {
            if ($callback($item, $key) === false) {
                break;
            }
        }

        return $this;
    }
}