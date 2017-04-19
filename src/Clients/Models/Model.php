<?php

namespace Klever\JustGivingApiSdk\Clients\Models;

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
     */
    public function fill($data)
    {
        foreach ($data as $key => $value) {
            $this->$key = $value;
        }

        return $this;
    }
}
