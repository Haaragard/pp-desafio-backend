<?php

namespace App\Dtos;

abstract class BaseDto
{
    /**
     * @var array
     */
    protected static array $rules = [];

    /**
     * @var array
     */
    protected static array $attributes = [];

    /**
     * @return array
     */
    public static function rules(): array
    {
        return static::$rules;
    }

    /**
     * @return array
     */
    public function toArray(): array
    {
        $attributes = [];
        foreach(static::$attributes as $attrName) {
            $attributes[$attrName] = $this->{$attrName};
        }

        return $attributes;
    }
}