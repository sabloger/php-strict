<?php

namespace Php_Strict;

use App\Exceptions\InvalidItemTypeException;
use App\Exceptions\NullOrScalarOffsetException;
use App\Exceptions\ObjectValidationFailedException;
use App\Exceptions\RequiredFieldsNotFilledException;
use App\Exceptions\SettingUndefinedFieldIsNotAllowed;
use Php_Strict\Traits\CountableTrait;
use Php_Strict\Traits\IteratorTrait;
use Php_Strict\Traits\JsonableTrait;
use Php_Strict\Traits\JsonSerializeTrait;
use Php_Strict\Traits\SerializableTrait;
use Php_Strict\Traits\StringTrait;
use Php_Strict\Traits\TypesTrait;
use Php_Strict\Interfaces\Arrayable;
use Php_Strict\Interfaces\Jsonable;
use Php_Strict\Interfaces\ObjectInterface;


/**
 * TODO:: Change [] to array() to support rater than php 5.4
 * User: sabloger
 * Date: 7/10/17
 * Time: 9:06 AM
 * CASE INSENSITIVE KEYS!!
 * Multiple work ways!!
 * As an array!
 * As a setter getter object!
 * As object properties
 * As a set() get() object!
 * Strict type! (and Optional typed!)
 * Can set default values for fields on __construct method!!
 * Jsonable
 * Serializable
 * Arrayable
 * Iteratable
 * TODO:: Improve field options::
 * TODO:: CamelCase to SnackCase auto-convert (and vise versa)
 * TODO:: Fields alias name,, or json (and array) alternative name!!!
 * TODO:: such as string:case! automatic case convert on assign!! ,,
 * TODO:: or expert validations like laravel validators ,,
 * TODO:: depended and serial fill required fields!!! -> $a and $b are not required fields! But if you filled it you must fill $b!! ... :-)
 * TODO:: ability to set default values for fields!
 *
 * TODO::::: Auto-generate Setter Getters or PHPDocs for class by an artisan command!!
 *
 * TODO:: age tuye object beshe ye method (dasti ya base) dasht ke akharesh be dest befreste khodesh chi?? mishe mesle builder!! nazaret??!! --
 */
abstract class BaseObject
    implements ObjectInterface, \IteratorAggregate, \Serializable, \Countable, \ArrayAccess, Arrayable, Jsonable, \JsonSerializable
{
    use JsonSerializeTrait;
    use JsonableTrait;
    use CountableTrait;
    use StringTrait;
    use IteratorTrait;
    use SerializableTrait;
    use TypesTrait;

    /**
     * Data container
     * @var array
     */
    private $items = array();


    abstract public function getRequiredFields();

    abstract public function getFieldsStub();

    /**
     * @return bool
     */
    abstract protected function isUndefinedSettingAllowed();

    /**
     * BaseObject constructor.
     * @param array|null $items
     */
    function __construct(array $items = null)
    {
        if (!empty($items))
            $this->collect($items);
    }

    /**
     * @param array $items
     * @return $this
     */
    public function collect(array $items)
    {
        foreach ($items as $key => $value)
            $this->set($key, $value);

        return $this;
    }

    /**
     * @return array
     */
    public function toArray()
    {
        return $this->items;
    }

    /**
     * @param $key
     * @param $value
     * @return $this
     * @throws InvalidItemTypeException
     * @throws NullOrScalarOffsetException
     * @throws SettingUndefinedFieldIsNotAllowed
     */
    public function set($key, $value)
    {
        if (is_null($key))
            throw new NullOrScalarOffsetException();
        else if (is_numeric($key))
            throw new NullOrScalarOffsetException();
        else {
            $fieldsStub = $this->getFieldsStub();
            $cKey = $this->getCorrectKey($key);
            if ($this->isUndefinedSettingAllowed())
                $this->items[$cKey] = $value;
            elseif (key_exists($cKey, $fieldsStub)) {
                if (!$this->checkType($value, $fieldsStub[$cKey]))
                    throw new InvalidItemTypeException($this->getItemType($value), $fieldsStub[$cKey]);
                $this->items[$cKey] = $value;
            } else
                throw new SettingUndefinedFieldIsNotAllowed();
        }
        return $this;
    }

    private function getCorrectKey($key)
    {
        $orgFieldsStub = $this->getFieldsStub();
        $orgAssignedFields = $this->toArray();
        if (($orgKey = array_search(strtolower($key), array_keys(array_change_key_case($orgFieldsStub, CASE_LOWER)))) !== false) {
            return array_keys($orgFieldsStub)[$orgKey];
        } elseif (($orgKey = array_search(strtolower($key), array_keys(array_change_key_case($orgAssignedFields, CASE_LOWER)))) !== false) {
            return array_keys($orgAssignedFields)[$orgKey];
        } else {
            return $key;
        }

    }

    /**
     * @param $key
     * @param $value
     * @return BaseObject
     */
    public function __set($key, $value)
    {
        return $this->set($key, $value);
    }

    /**
     * @param $key
     * @return mixed|null
     */
    public function get($key)
    {
        $cKey = $this->getCorrectKey($key);
        return isset($this->items[$cKey]) ? $this->items[$cKey] : null;
    }

    /**
     * @param $key
     * @return mixed|null
     */
    public function __get($key)
    {
        return $this->get($key);
    }

    /**
     * @param $key
     * @param null $value
     * @return BaseObject|mixed|null
     */
    public function field($key, $value = null)
    {
        if ($value === null)
            return $this->get($key);
        else
            return $this->set($key, $value);
    }

    /**
     * @param $key
     * @return bool
     */
    public function has($key)
    {
        return isset($this->items[$key]);
    }

    /**
     * @param $key
     */
    public function unsetItem($key)
    {
        unset($this->items[$key]);
    }

    /**
     * @param $key
     * @return int
     */
    public function indexOf($key)
    {
        return array_search($key, array_keys($this->toArray()));
    }

    /**
     * @param $index
     * @return string
     */
    public function keyOf($index)
    {
        return array_keys($this->toArray())[$index];
    }

    /**
     * @param $name
     * @param $arguments
     * @return mixed
     */
    function __call($name, $arguments)
    {
        $lName = strtolower($name);
        $callables = ['set', 'get'];

        foreach ($callables as $callable) {
            if (strpos($lName, $callable) === 0) {
                $postFix = str_replace_first($callable, '', $lName);
                array_unshift($arguments, $postFix);
                return call_user_func_array([$this, $callable], $arguments);
            }
        }

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
        return $this->has($offset);
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
        return $this->get($offset);
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
     * @return void
     * @throws NullOrScalarOffsetException
     * @since 5.0.0
     */
    public function offsetSet($offset, $value)
    {
        $this->set($offset, $value);
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
        $this->unsetItem($offset);
    }

    /**
     * @return bool
     * @throws RequiredFieldsNotFilledException
     * @throws ObjectValidationFailedException
     */
    final public function validate()
    { //TODO nemikham dependency be laravel dashte bashe ama validation e laravel khube ha!!!
        if (!$this->areRequiredFieldsFilled())
            throw new RequiredFieldsNotFilledException($this->getUnfilledFields());
        else
            return true;
    }

    /**
     * @return bool
     */
    protected function areRequiredFieldsFilled()
    {
        return empty(array_diff($this->getRequiredFields(), array_intersect($this->getRequiredFields(), array_keys($this->toArray()))));
    }

    protected function getUnfilledFields()
    {
        return array_values(array_diff($this->getRequiredFields(), array_keys($this->toArray())));
    }
}