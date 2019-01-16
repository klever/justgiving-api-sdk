<?php

namespace Konsulting\JustGivingApiSdk\ResourceClients\Models;

use Konsulting\JustGivingApiSdk\Exceptions\InvalidPropertyException;

class Model
{
    /**
     * Allow data to be filled via the constructor.
     *
     * @param iterable $data
     */
    public function __construct($data = null)
    {
        if (isset($data)) {
            $this->fill($data);
        }
    }

    /**
     * Get an associative array of the attributes.
     *
     * @return array
     */
    public function getAttributes()
    {
        return get_object_vars($this);
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
     * @param iterable $data
     * @return $this
     * @throws InvalidPropertyException
     */
    public function fill($data)
    {
        foreach ($data as $key => $value) {
            if (! property_exists($this, $key)) {
                throw new InvalidPropertyException($key . ' is not a property on ' . get_class($this));
            }

            $this->$key = $value;
        }

        return $this;
    }
}
