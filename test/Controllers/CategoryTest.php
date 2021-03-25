<?php


namespace Tests\Controllers;


use App\Models\Category;

class CategoryTest extends \PHPUnit\Framework\TestCase
{
    private $model;

    public function test__construct()
    {
        $this->model = (new Category());
        $this->assertIsObject($this->model);
        $this->assertNotEmpty($this->model);
    }


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
    // criando objeto
    public function testCreate()
    {
        $arrayObject = [
            'name' => 'createCategoryOfTest'
        ];
        $object = \App\Controllers\Category::create($arrayObject);
        $this->assertTrue($object);
    }

    // provocando erro deixando de passar field obrigatorio
    public function testCreateFieldRequire()
    {
        $arrayObject = [
            'name' => ''
        ];
        $object = \App\Controllers\Category::create($arrayObject);
        $this->assertFalse($object);
    }

    // provocando erro com array vazio
    public function testCreateArrayEmpty()
    {
        $arrayObject = [];
        $object = \App\Controllers\Category::create($arrayObject);
        $this->assertFalse($object);
    }


    /*
     * method/functions of findById()
     */

    // provocando erro - passagem de id inexistente
    public function testFindBiIdNotFound()
    {
        $arrayCategory = ['id' => 999999];
        $response = \App\Controllers\Category::findById($arrayCategory);
        $this->assertFalse($response);
    }

    // provocando erro - omitindo chave id no array
    public function testFindBiIdKeyIdNotFound()
    {
        $arrayCategory = ['chaveInvalida' => 5];
        $response = \App\Controllers\Category::findById($arrayCategory);
        $this->assertFalse($response);
    }

    // listando produto por id (ultimo id registrado)
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

    // provocando erro por id invalido
    public function testEditIdNotFound()
    {
        $response = \App\Controllers\Category::edit([
            'id' => 999999,
            'name' => "newCategoryTestOverwritten"
        ]);
        $this->assertFalse($response);
    }

    // provocando erro por key invalido
    public function testEditKeyIdNotFound()
    {
        $response = \App\Controllers\Category::edit([
            'name' => "newCategoryTestOverwritten"
        ]);
        $this->assertFalse($response);
    }


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

    // provocando erro id inválido
    public function testDeleteIdNotFoud()
    {
        $arrayCategory = ['id' => 99999];

        $methotDelete = \App\Controllers\Category::delete($arrayCategory);

        $this->assertFalse($methotDelete);
    }

    // provocando erro nova da chave invalida
    public function testDeleteNameKeyInvalid()
    {
        $this->model = (new Category())->find()->order('id')->fetch(true);
        $object = $this->model[sizeof($this->model)-1];

        $arrayCategory = ['name_key_invalid' => $object->id];

        $methotDelete = \App\Controllers\Category::delete($arrayCategory);

        $this->assertFalse($methotDelete);
    }


    // excluindo registro
    public function testDelete()
    {
        $this->model = (new Category())->find()->order('id')->fetch(true);
        $object = $this->model[sizeof($this->model)-1];

        $arrayCategory = ['id' => $object->id];

        $methotDelete = \App\Controllers\Category::delete($arrayCategory);

        $this->assertTrue($methotDelete);
    }


}