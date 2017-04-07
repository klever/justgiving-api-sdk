<?php

namespace Klever\JustGivingApiSdk\Clients\Models;

class Model
{
    /**
     * Get an associative array of the attributes.
     *
     * @return array
     */
    public function getAttributes()
    {
        $attributes = get_object_vars($this);

        foreach ($attributes as $key => $value) {
            if ($value instanceof Model) {
                $attributes = $this->fillNestedAttributes($attributes, ucfirst($key), $value);
                unset($attributes[$key]);
            }
        }

        return $attributes;
    }

    /**
     * @param array  $attributes
     * @param string $baseName
     * @param Model  $object
     * @return mixed
     */
    protected function fillNestedAttributes(array $attributes, $baseName, Model $object)
    {
        foreach ($object->getAttributes() as $key => $value) {
            $attributes[$baseName . '.' . $key] = $value;
        }

        return $attributes;
    }


    /**
     * Get the names of the attributes on this model.
     *
     * @return array
     */
    public function getAttributeNames()
    {
        return array_keys($this->getAttributes());
    }

    /**
     * Populate the model with the supplied data.
     *
     * @param array $data
     * @return $this
     */
    public function fill(array $data)
    {
        foreach ($data as $key => $value) {
            $this->$key = $value;
        }

        return $this;
    }
}
