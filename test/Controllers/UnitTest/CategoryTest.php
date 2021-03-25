<?php


namespace Tests\Controllers\UnitTest;


use App\Models\Category;

class CategoryTest extends \PHPUnit\Framework\TestCase
{
    private $model;

    /*
     * method/functions of index()
     */
    public function testIndex()
    {
        $objects = \App\Controllers\Category::index();
        $this->assertIsArray($objects);
    }


    /*
     * method/function of create()
     */
    // create object
    public function testCreate()
    {
        $arrayObject = [
            'name' => 'createCategoryOfTest'
        ];
        $object = \App\Controllers\Category::create($arrayObject);
        $this->assertTrue($object);
    }

    // cannot be created because the value name has not been sent
    public function testCreateFieldRequire()
    {
        $arrayObject = [
            'name' => ''
        ];
        $object = \App\Controllers\Category::create($arrayObject);
        $this->assertFalse($object);
    }

    // cannot be created because the array has empty
    public function testCreateArrayEmpty()
    {
        $arrayObject = [];
        $object = \App\Controllers\Category::create($arrayObject);
        $this->assertFalse($object);
    }


    /*
     * method/functions of findById()
     */
    // cannot be loaded because the array key is invalid and the id value is correct
    public function testFindBiIdKeyIdNotFound()
    {
        $arrayCategory = ['key_invalid' => 5];
        $response = \App\Controllers\Category::findById($arrayCategory);
        $this->assertFalse($response);
    }


    /*
     * method/functions of edit
     */
    // cannot be updated because the array key not exist (id)
    public function testEditKeyIdNotFound()
    {
        $response = \App\Controllers\Category::edit([
            'name' => "newCategoryTestOverwritten"
        ]);
        $this->assertFalse($response);
    }


    /*
     * method/function delete()
     */
    // cannot be updated because the array key id invalid (id)
    public function testDeleteNameKeyInvalid()
    {
        $this->model = (new Category())->find()->order('id')->fetch(true);
        $object = $this->model[sizeof($this->model)-1];

        $arrayCategory = ['name_key_invalid' => $object->id];

        $methotDelete = \App\Controllers\Category::delete($arrayCategory);

        $this->assertFalse($methotDelete);
    }
}