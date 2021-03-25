<?php


namespace Tests\Controllers\UnitTest;


use App\Models\Product;

class ProductTest extends \PHPUnit\Framework\TestCase
{
    private $model;


    /*
     * method/functions of create
     */
    // cannot be created because array has empty
    public function testCreateProductEmpty()
    {
        $arrayProdutc = [];
        $response = \App\Controllers\Product::create($arrayProdutc);
        $this->assertFalse($response);
    }

    // cannot be created because value of field 'name' is required and not sent
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


    /*
     * method/functions of findById()
     */
    // cannot be loaded because name of key is invalid
    public function testFindBiIdKeyIdNotFound()
    {
        $arrayProduct = ['key_invalid' => 5];
        $response = \App\Controllers\Product::findById($arrayProduct);

        $this->assertFalse($response);
    }


    /*
     * method/functions of edit
     */
    // cannot be updated because key 'id' not sent
    public function testEditKeyIdNotFound()
    {
        $response = \App\Controllers\Product::edit([
            'name' => "newProductTestOverwritten",
            'category_id' => 2,
            'price' => 5.9
        ]);

        $this->assertFalse($response);
    }


    /*
     * method/function delete()
     */
    // cannot be deleted because name of key is invalid
    public function testDeleteNameKeyInvalid()
    {
        $this->model = (new Product())->find()->order('id')->fetch(true);
        $object = $this->model[sizeof($this->model)-1];

        $arrayProduct = ['name_key_invalid' => $object->id];

        $methotDelete = \App\Controllers\Product::delete($arrayProduct);

        $this->assertFalse($methotDelete);
    }
}