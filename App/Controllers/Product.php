<?php


namespace App\Controllers;


class Product
{
    public function index()
    {
        $product = (new \App\Models\Product())->find()->order('id')->fetch(true);

//      header comentado para rodar os testesddddddddddddd
//      header('Content-type: application/json');

        if(empty($product)) {
            http_response_code(400);
            echo json_encode(array(
                "status" => "error",
                "class" => "Controller/Product",
                "method" => "list",
                "message" => "não existe produtos cadastrados na base de dados"),
                JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);
            return false;
        }

        $response = [];
        foreach ($product as $p) {
            $response[] = $p->data();
        }

        http_response_code(200);
        echo json_encode(array(
            "status" => "success",
            "class" => "Controller/Product",
            "method" => "list",
            "data" => $response),
            JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);
        return $response;
    }

    public function create(array $data)
    {
//      header comentado para rodar os testes
//      header('Content-type: application/json');

        if (!empty($data)) {
            $model = (new \App\Models\Product());

            $message = [];
            foreach ($model->columns() as $m) {
                if (@$m->Field != 'id' && empty($data[$m->Field]) && @$m->Null == 'NO') {
                    $message[] = $m->Field;
                }
            }

            if (!empty($message)) {
                http_response_code(400);
                echo json_encode(array(
                    "status" => "error",
                    "type" => "invalid_data",
                    "class" => "Controller/Product",
                    "method" => "create",
                    "message" => "campos obrigatório", "fields" => $message),
                    JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);
                return false;
            }

            $category_id = filter_var($data['category_id'], FILTER_SANITIZE_NUMBER_INT);
            $category = (new \App\Models\Category())->findById($category_id);

            if (empty($category)) {
                http_response_code(400);
                echo json_encode(array(
                    "status" => "error",
                    "type" => "invalid_data",
                    "class" => "Controller/Product",
                    "method" => "create",
                    "message" => "categoria inválida"),
                    JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);
                return false;
            }

            $model->category_id = $category_id;
            $model->name = $data['name'];
            $model->price = $data['price'];
            $model->quantity = $data['quantity'];

            if (!$model->save()) {
                http_response_code(404);
                echo json_encode(array(
                    "status" => "error",
                    "type" => "invalid_data",
                    "class" => "Controller/Product",
                    "method" => "create",
                    "message" => "não foi possivel salvar o produto"),
                    JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);
                return false;
            } else {
                $model->save();
                http_response_code(201);
                echo json_encode(array(
                    "status" => "success",
                    "method" => "create",
                    "class" => "Controller/Product",
                    "id" => $model->id,
                    "data" => "produto salvo com sucesso"),
                    JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);
                return $model;
            }
        }

        http_response_code(400);
        echo json_encode(array(
            "status" => "error",
            "type" => "invalid_data",
            "class" => "Controller/Product",
            "method" => "create",
            "message" => "não foi possivel criar o produto"),
            JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);
        return false;
    }

    public function findById(array $data)
    {
//      header comentado para rodar os testes
//      header('Content-type: application/json');

        if (!empty($data['id'])) {
            $id = filter_var($data['id'], FILTER_SANITIZE_NUMBER_INT);
            $product = (new \App\Models\Product())->findById($id);

            if (empty($product)) {
                http_response_code(400);
                echo json_encode(array(
                    "status" => "error",
                    "type" => "invalid_data",
                    "class" => "Controller/Product",
                    "method" => "findById",
                    "message" => "identificador inválido"),
                    JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);
                return false;
            }

            $response = $product->data();
            http_response_code(200);
            echo json_encode(array(
                "status" => "success",
                "class" => "Controller/Product",
                "method" => "findById",
                "data" => $response),
                JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);
            return $response;
        }

        http_response_code(400);
        echo json_encode(array(
            "status" => "error",
            "type" => "invalid_data",
            "class" => "Controller/Product",
            "method" => "findById",
            "message" => "não foi possivel editar o produto"),
            JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);
        return false;
    }

    public function edit(array $data)
    {
//      header comentado para rodar os testes
//      header('Content-type: application/json');

        if (!empty($data['id'])) {
            $id = filter_var($data['id'], FILTER_SANITIZE_NUMBER_INT);
            $product = (new \App\Models\Product())->findById($id);

            if (empty($product)) {
                http_response_code(400);
                echo json_encode(array(
                    "status" => "error",
                    "type" => "invalid_data",
                    "class" => "Controller/Product",
                    "method" => "edit",
                    "message" => "identificador inválido"),
                    JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);
                return false;
            }

            if (!empty($data['category_id'])) {
                $category_id = (int)filter_var($data['category_id'], FILTER_SANITIZE_NUMBER_INT);
                if (!empty($category_id) && is_numeric($category_id)) {
                    $category = (new \App\Models\Category())->findById($category_id);
                }
                if (empty($category)) {
                    http_response_code(400);
                    echo json_encode(array("status" => "error",
                        "type" => "invalid_data",
                        "class" => "Controller/Product",
                        "method" => "edit",
                        "message" => "categoria inválida"),
                        JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);
                    return false;
                }
            } else
                $category_id = $product->category_id;

            $product->category_id = $category_id ?? $product->category_id;
            $product->name = !empty($data['name']) ? $data['name'] : $product->name;
            $product->price = !empty($data['price']) ? $data['price'] : $product->price;
            $product->quantity = !empty($data['quantity']) ? $data['quantity'] : $product->quantity + 1;

            $product->save();
            http_response_code(201);
            echo json_encode(array(
                "status" => "success",
                "class" => "Controller/Product",
                "method" => "edit",
                "id" => $product->id,
                "message" => "produto salvo com sucesso"),
                JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);
            return $product;

        }
        http_response_code(400);
        echo json_encode(array(
            "status" => "error",
            "type" => "invalid_data",
            "class" => "Controller/Product",
            "method" => "edit",
            "message" => "não foi possível editar o produto"),
            JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);
        return false;
    }

    public function delete(array $data)
    {
//      header comentado para rodar os testes
//      header('Content-type: application/json');

        if (!empty($data['id'])) {
            $id = filter_var($data['id'], FILTER_SANITIZE_NUMBER_INT);
            $product = (new \App\Models\Product())->findById($id);

            if (empty($product)) {
                http_response_code(400);
                echo json_encode(array(
                    "status" => "error",
                    "type" => "invalid_data",
                    "class" => "Controller/Product",
                    "method" => "delete",
                    "message" => "identificador inválido"),
                    JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);
                return false;
            }

            if ($product->destroy()) {
                http_response_code(200);
                echo json_encode(array(
                    "status" => "sucess",
                    "class" => "Controller/Product",
                    "method" => "delete",
                    "id" => $id,
                    "message" => "produto excluido com sucesso"),
                    JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);
                return true;
            }
        }

        http_response_code(400);
        echo json_encode(array(
            "status" => "error",
            "type" => "invalid_data",
            "class" => "Controller/Product",
            "method" => "delete",
            "message" => "nao foi possivel excluir o produto"),
            JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);
        return false;
    }
}