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
