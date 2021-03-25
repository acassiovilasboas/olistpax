<?php


namespace Tests\Controllers\IntegrationTest;


use App\Models\Product;

class ProductTest extends \PHPUnit\Framework\TestCase
{
    private $model;

    public function test__construct()
    {
        $this->model = (new Product());
        $this->assertIsObject($this->model);
    }


    /*
     * method/function of index()
     */

    public function testIndex()
    {
        $objects = \App\Controllers\Product::index();

        $this->assertIsArray($objects);
    }


    /*
     * method/functions of create
     */

    // salvando novo produto no banco
    public function testCreateObject()
    {
        $arrayProdutc = [
          'name' => 'newProductTest',
          'category_id' => 5,
          'price' => 50.2,
          'quantity' => 50
        ];
        $response = \App\Controllers\Product::create($arrayProdutc);
        $this->assertTrue($response);
    }


    // provocando erro por objeto vazio
    public function testCreateProductEmpty()
    {
        $arrayProdutc = [];
        $response = \App\Controllers\Product::create($arrayProdutc);
        $this->assertFalse($response);
    }


    // provocando erro por falta de informacao obrigatoria
    public function testCreateProductFieldRequireNotDeclared()
    {
        $arrayProdutc = [
            'name' => '',
            'category_id' => 5,
            'price' => 50.2,
            'quantity' => 50
        ];
        $response = \App\Controllers\Product::create($arrayProdutc);
        $this->assertFalse($response);
    }


    // provocando erro ao salvar no banco, tipo de dado inválido
    public function testCreateProductFieldStatementInvalid()
    {
        $arrayProdutc = [
            'name' => 'newProductTest',
            'category_id' => 5,
            'price' => 50.2,
            'quantity' => 'text for crash application'
        ];
        $response = \App\Controllers\Product::create($arrayProdutc);
        $this->assertFalse($response);
    }


    // provocando erro por informando categoria inexistente
    public function testCreateProductCategoryNotFound()
    {
        $arrayProdutc = [
            'name' => 'newProductTest',
            'category_id' => 9999,
            'price' => 50.2,
            'quantity' => 50
        ];
        $response = \App\Controllers\Product::create($arrayProdutc);
        $this->assertFalse($response);
    }


    /*
     * method/functions of findById()
     */

    // listando produto por id (ultimo id registrado)
    public function testFindBiId()
    {
        $this->model = (new Product())->find()->order('id')->fetch(true);
        $lastId = $this->model[sizeof($this->model)-1]->id;

        $arrayProduct = ['id' => $lastId];

        $object = \App\Controllers\Product::findById($arrayProduct);

        $this->assertIsObject($object);
    }


    // provocando erro - passagem de id inexistente
    public function testFindBiIdNotFound()
    {
        $arrayProduct = ['id' => 999999];
        $response = \App\Controllers\Product::findById($arrayProduct);

        $this->assertFalse($response);
    }

    // provocando erro - omitindo chave id no array
    public function testFindBiIdKeyIdNotFound()
    {
        $arrayProduct = ['chaveInvalida' => 5];
        $response = \App\Controllers\Product::findById($arrayProduct);

        $this->assertFalse($response);
    }



    /*
     * method/functions of edit
     */

    // testando regra de negocio: ao editar um produto e nao informar a
    // quantidade a ser atualizada, incremente a quantiadade automaticamente
    public function testEditIncrementQuantityAutomatic()
    {
        $this->model = (new Product())->find()->order('id')->fetch(true);
        $lastId = $this->model[sizeof($this->model)-1]->id;

        $objectOld = (new Product())->findById($lastId);

        $object = \App\Controllers\Product::edit([
            'id' => $lastId,
            'name' => "newProductTestOverwritten",
            'category_id' => 2,
            'price' => 5.9
        ]);

        $objectUpdated = (new Product())->findById($lastId);

        $this->assertNotEquals($objectOld->quantity, $objectUpdated->quantity);
    }


    // provocando erro por id invalido
    public function testEditIdNotFound()
    {
        $response = \App\Controllers\Product::edit([
            'id' => 999999,
            'name' => "newProductTestOverwritten",
            'category_id' => 2,
            'price' => 5.9
        ]);

        $this->assertFalse($response);
    }

    // provocando erro por key nao informada
    public function testEditKeyIdNotFound()
    {
        $response = \App\Controllers\Product::edit([
            'name' => "newProductTestOverwritten",
            'category_id' => 2,
            'price' => 5.9
        ]);

        $this->assertFalse($response);
    }

    // provocando erro por declaracao invalida
    public function testEditIdStatementInvalid()
    {
        $this->model = (new Product())->find()->order('id')->fetch(true);
        $lastId = $this->model[sizeof($this->model)-1]->id;
        $priceOld = $this->model[sizeof($this->model)-1]->price;

        $response = \App\Controllers\Product::edit([
            'id' => $lastId,
            'name' => "newProductTestOverwritten",
            'category_id' => 15,
            'price' => 'text for crash of application'
        ]);

        $productUpdated = (new Product())->findById($lastId);
        $priceUpdated = $productUpdated->price;

        $this->assertEquals($priceOld, $priceUpdated);
    }

    // provocando erro por categoria invalida
    public function testEditIdCategoryInvalid()
    {
        $this->model = (new Product())->find()->order('id')->fetch(true);
        $lastId = $this->model[sizeof($this->model)-1]->id;

        $response = \App\Controllers\Product::edit([
            'id' => $lastId,
            'name' => "newProductTestOverwritten",
            'category_id' => 99999,
            'price' => 50.50
        ]);

        $this->assertFalse($response);
    }


    /*
     * method/function delete()
     */

    // provocando erro id inválido
    public function testDeleteIdNotFoud()
    {
        $arrayProduct = ['id' => 99999];

        $methotDelete = \App\Controllers\Product::delete($arrayProduct);

        $this->assertFalse($methotDelete);
    }

    // provocando erro nova da chave invalida
    public function testDeleteNameKeyInvalid()
    {
        $this->model = (new Product())->find()->order('id')->fetch(true);
        $object = $this->model[sizeof($this->model)-1];

        $arrayProduct = ['name_key_invalid' => $object->id];

        $methotDelete = \App\Controllers\Product::delete($arrayProduct);

        $this->assertFalse($methotDelete);
    }


    // excluindo registro
    public function testDelete()
    {
        $this->model = (new Product())->find()->order('id')->fetch(true);
        $object = $this->model[sizeof($this->model)-1];

        $arrayProduct = ['id' => $object->id];

        $methotDelete = \App\Controllers\Product::delete($arrayProduct);

        $this->assertTrue($methotDelete);
    }
}