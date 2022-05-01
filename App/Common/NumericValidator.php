<?php

namespace Serato\Common;

use Doctrine\Common\Annotations\AnnotationReader;
use Doctrine\Common\Annotations\AnnotationRegistry;
use Serato\Annotations\SeratoNumeric;


/**
 * Trait NumericValidator
 * @package Serato\Common
 * validates the given fields are numeric
 */
trait NumericValidator
{
    public AnnotationReader $reader;

    public function __construct()
    {
        AnnotationRegistry::registerLoader('class_exists');
        $this->reader = new AnnotationReader();
    }

    public function __call($property, $arguments): mixed
    {
        $action = substr($property, 0, 3);
        $fieldName = lcfirst(substr($property, 3));
        if (property_exists($this, $fieldName)) {
            switch ($action) {
                case "set":
                    try {
                        if ($this->isSeratoNumeric($fieldName)) {
                            if (count($arguments) > 0 && $arguments[0] != null) {
                                if (!is_numeric($arguments[0])) { //todo this evaluated both 2000 and '2000' to be true.
                                    throw new \Exception('Not a number!');
                                }
                            }
                        }
                    } catch (\ReflectionException $e) {
                        echo "Error evaluating property:" . $fieldName;
                    }


                    break;
                default:
                    break;
            }
        }
        return parent::__call($property, $arguments);
    }

    /** check whether field is annotated with SeratoNumeric annotation.
     * @param $fieldName
     * @return bool
     * @throws \ReflectionException
     */
    private function isSeratoNumeric($fieldName): bool
    {
        //todo creating new ReflectionClass for each iteration may cause perf issues.
        $reflector = new \ReflectionClass($this);
        $reflectionProperty = $reflector->getProperty($fieldName);
        $reflectionProperty->setAccessible(true);
        return $this->reader->getPropertyAnnotation(
            $reflectionProperty, SeratoNumeric::class
        ) ? true : false;
    }
}