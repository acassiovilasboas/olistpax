<?php


namespace Tests\Controllers\IntegrationTest;


use App\Models\Category;

class CategoryTest extends \PHPUnit\Framework\TestCase
{
    private $model;

    /*
     * method/functions of index()
     */
    // list of registers
    public function testIndex()
    {
        $objects = \App\Controllers\Category::index();
        $this->assertIsArray($objects);
    }


    /*
     * method/function of create()
     */
    // create object and saved in database
    public function testCreate()
    {
        $arrayObject = [
            'name' => 'createCategoryOfTest'
        ];
        $object = \App\Controllers\Category::create($arrayObject);
        $this->assertTrue($object);
    }


    /*
     * method/functions of findById()
     */
    // cannot be loaded because value of id not exists in database
    public function testFindBiIdNotFound()
    {
        $arrayCategory = ['id' => 999999];
        $response = \App\Controllers\Category::findById($arrayCategory);
        $this->assertFalse($response);
    }

    // loading register when value correct
    public function testFindBiId()
    {
        $this->model = (new Category())->find()->order('id')->fetch(true);
        $lastId = $this->model[sizeof($this->model)-1]->id;

        $arrayCategory = ['id' => $lastId];
        $object = \App\Controllers\Category::findById($arrayCategory);
        $this->assertIsObject($object);
    }



    /*
     * method/functions of edit
     */
    // cannot be updated because value of id not exist in database
    public function testEditIdNotFound()
    {
        $response = \App\Controllers\Category::edit([
            'id' => 999999,
            'name' => "newCategoryTestOverwritten"
        ]);
        $this->assertFalse($response);
    }

    // updated record and validating the old name with the updated name
    public function testEditCategory()
    {
        $this->model = (new Category())->find()->order('id')->fetch(true);
        $lastId = $this->model[sizeof($this->model)-1]->id;
        $nameOld = $this->model[sizeof($this->model)-1]->name;

        $arrayCategory = ['id' => $lastId, 'name' => 'nameOverride'];

        $object = \App\Controllers\Category::edit($arrayCategory);

        $categoryUpdated = (new Category())->findById($lastId);

        $nameCategoryUpdated = $categoryUpdated->name;

        $this->assertTrue($object);
        $this->assertNotEquals($nameOld, $nameCategoryUpdated);
    }


    /*
     * method/function delete()
     */
    // cannot be deleted because value of id not exist in database
    public function testDeleteIdNotFoud()
    {
        $arrayCategory = ['id' => 99999];

        $methotDelete = \App\Controllers\Category::delete($arrayCategory);

        $this->assertFalse($methotDelete);
    }

    // deleting register
    public function testDelete()
    {
        $this->model = (new Category())->find()->order('id')->fetch(true);
        $object = $this->model[sizeof($this->model)-1];

        $arrayCategory = ['id' => $object->id];

        $methotDelete = \App\Controllers\Category::delete($arrayCategory);

        $this->assertTrue($methotDelete);
    }
}