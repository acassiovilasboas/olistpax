<?php


namespace Tests\Controllers\IntegrationTest;


use App\Models\Product;

class ProductTest extends \PHPUnit\Framework\TestCase
{
    private $model;


    /*
     * method/function of index()
     */
    // list products in database
    public function testIndex()
    {
        $objects = \App\Controllers\Product::index();

        $this->assertIsArray($objects);
    }


    /*
     * method/functions of create
     */
    // saving register in database
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


    // cannot be created because value for int has declared text
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

    // cannot be created because category not exist
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
    // loading register
    public function testFindBiId()
    {
        $this->model = (new Product())->find()->order('id')->fetch(true);
        $lastId = $this->model[sizeof($this->model)-1]->id;

        $arrayProduct = ['id' => $lastId];

        $object = \App\Controllers\Product::findById($arrayProduct);

        $this->assertIsObject($object);
    }

    // cannot be loading because number id not exist
    public function testFindBiIdNotFound()
    {
        $arrayProduct = ['id' => 999999];
        $response = \App\Controllers\Product::findById($arrayProduct);

        $this->assertFalse($response);
    }


    /*
     * method/functions of edit
     */
    // updated register and check value of quantity.
    // quantity increment if value of increment not sent.
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

    // cannot be updated because number id not exist
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

    // cannot be updated because sent text value in field for int
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

    // cannot be updated because number category not exist in database
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
    // cannot be deleted because number id not exist in database
    public function testDeleteIdNotFoud()
    {
        $arrayProduct = ['id' => 99999];

        $methotDelete = \App\Controllers\Product::delete($arrayProduct);

        $this->assertFalse($methotDelete);
    }

    // deleting register
    public function testDelete()
    {
        $this->model = (new Product())->find()->order('id')->fetch(true);
        $object = $this->model[sizeof($this->model)-1];

        $arrayProduct = ['id' => $object->id];

        $methotDelete = \App\Controllers\Product::delete($arrayProduct);

        $this->assertTrue($methotDelete);
    }
}