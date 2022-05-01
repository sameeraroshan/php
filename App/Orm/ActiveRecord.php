<?php

namespace Serato\Orm;


use Serato\Common\PropertyReader;

/**
 * ActiveRecord
 *
 * Abstract class that all child datbase models inherit from.
 *
 * Assume that this class contains boiler plate functionality for handling
 * database reads and writes and that the `save` method is fully implemented.
 */
abstract class ActiveRecord implements ActiveRecordInterface
{

    use PropertyReader;

    /**
     * ActiveRecord constructor. made private to avoid instantiation without using @create method.
     */
    private function __construct()
    {
    }

    protected bool $isModified = false;

    /**
     * Saves a models data to the database
     *
     * @return void
     */
    public function save(): void
    {
        // Assume a full working implementation
    }

    /** object modified state is returned.
     * @return bool
     */
    public function isModified(): bool
    {
        return $this->isModified;
    }


    /**
     * @param $property
     * @param $arguments
     * @return $this
     */
    public function __call($property, $arguments):mixed
    {
        $action = substr($property, 0, 3);
        $fieldName = lcfirst(substr($property, 3));
        if (property_exists($this, $fieldName)) {
            switch ($action) {
                case "set":
                    if (count($arguments) > 0 && $arguments[0] != null) {
                        //accessing private properties through reader
                        $propertyRef = &$this->reader($this, $fieldName);
                        //if current value is different from the new value, object is modified.
                        if ($propertyRef != $arguments[0]) {
                            $this->isModified = true;
                        }
                        $propertyRef = $arguments[0];
                    }
                    return $this;
                case 'get':
                    return $this->reader($this, $fieldName);
                default:
                    return $this;
            }
        }
        return $this;
    }

    /** create new instance of the ActiveRecord
     * @return ActiveRecord
     */
    public static function create(): ActiveRecord
    {
        return new static();
    }

    public function __destruct()
    {
        echo "Destroying " . (new \ReflectionObject($this))->getShortName() . PHP_EOL;
    }

}
