<?php


namespace Tests;


use App\Models\Category;

class CategoryTest extends \PHPUnit\Framework\TestCase
{

    public function testCreate()
    {
        $model = (new \App\Models\Category());

        $model->name = "novacategoria";
        $model->save();
        $this->assertEquals(9, $model->id);
    }

    public function testList()
    {

    }

    public function testUpdate()
    {

    }

    public function testDelete()
    {

    }
}