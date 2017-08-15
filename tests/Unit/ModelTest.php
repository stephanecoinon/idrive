<?php

namespace Tests\Unit;

use StephaneCoinon\IDrive\Models\Model;
use Tests\TestCase;

class ModelTest extends TestCase
{
    /** @test */
    function model_attributes_are_set_on_instantiation()
    {
        $attributes = ['name' => 'John Doe'];

        $model = new Model($attributes);

        $this->assertEquals($attributes, $model->getAttributes());
    }

    /** @test */
    function getting_an_attribute()
    {
        $model = new Model(['name' => 'John Doe']);

        $this->assertEquals('John Doe', $model->getAttribute('name'));
    }

    /** @test */
    function getting_an_unset_attribute_returns_null_by_default()
    {
        $model = new Model(['name' => 'John Doe']);

        $this->assertNull($model->getAttribute('email'));
    }

    /** @test */
    function a_default_value_can_be_returned_when_getting_an_unset_attribute()
    {
        $model = new Model(['name' => 'John Doe']);

        $this->assertEquals('no e-mail', $model->getAttribute('email', 'no e-mail'));
    }

    /** @test */
    function model_attributes_can_be_accessed_like_instance_members()
    {
        $attributes = ['name' => 'John Doe'];

        $model = new Model($attributes);

        $this->assertEquals('John Doe', $model->name);
    }

    /** @test */
    function fetching_an_unset_attribute_like_an_instance_member_returns_null()
    {
        $attributes = ['name' => 'John Doe'];

        $model = new Model($attributes);

        $this->assertNull($model->telephone);
    }
}
