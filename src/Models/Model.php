<?php

namespace StephaneCoinon\IDrive\Models;

class Model
{
    /** @var array */
    protected $attributes;

    /**
     * Make a new Model.
     *
     * @param array $attributes
     */
    public function __construct(array $attributes = [])
    {
        $this->attributes = $attributes;
    }

    /**
     * Get an attribute.
     *
     * @param  string     $name    attribute name
     * @param  mixed|null $default default value to be returned if attribute
     *                             doesn't exist on this Model
     * @return mixed               attribute value or $default if it doesn't exist
     *                             on this Model
     */
    public function getAttribute($name, $default = null)
    {
        return $this->attributes[$name] ?? $default;
    }

    /**
     * Get the Model attributes.
     *
     * @return array
     */
    public function getAttributes()
    {
        return $this->attributes;
    }

    /**
     * Allow attributes to be accessed like class members.
     *
     * @param  string     $name attribute name
     * @return mixed|null       attribute value or null if it doesn't exist on this Model
     */
    public function __get($name)
    {
        return $this->getAttribute($name);
    }

}
