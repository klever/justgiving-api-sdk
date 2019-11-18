<?php

namespace Konsulting\JustGivingApiSdk\Tests;

use PHPUnit\Framework\TestCase as PHPUnitTestCase;

class TestCase extends PHPUnitTestCase
{
    /**
     * Tests if two objects have the same attributes.
     *
     * @param object|string $expectedObject
     * @param object        $actualObject
     */
    protected function assertEqualAttributes($expectedObject, $actualObject)
    {
        $expectedObject = is_string($expectedObject) ? new $expectedObject : $expectedObject;
        $expectedKeys = array_keys(get_object_vars($expectedObject));

        $intersect = array_intersect($expectedKeys, array_keys(get_object_vars($actualObject)));
        $this->assertEquals($expectedKeys, $intersect);
    }

    /**
     * Check if an object has all of an array of attributes.
     *
     * @param array  $attributes
     * @param object $object
     */
    protected function assertObjectHasAttributes($attributes, $object)
    {
        foreach ($attributes as $attribute) {
            $this->assertObjectHasAttribute($attribute, $object);
        }
    }
}
