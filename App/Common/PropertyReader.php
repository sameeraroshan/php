<?php


namespace Serato\Common;

/**
 * Trait PropertyReader
 * used to read private properties.
 * can be used to assign values for read properties.
 * @package Serato
 */
trait PropertyReader
{
    /**
     * @param $object object with private properties
     * @param $property string name of the property to be accessed
     * @return mixed
     */
    function & reader(object $object, string $property): mixed
    {
        return \Closure::bind(function & () use ($property) {
            return $this->$property;
        }, $object, $object)->__invoke();

    }
}