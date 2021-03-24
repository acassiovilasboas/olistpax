<?php


namespace App\Controllers;


class Product
{
    public function index(array $data)
    {
        try {
            $product = (new \App\Models\Product())->find()->order('id')->fetch(true);

            header('Content-type: application/json');

            $response = [];
            foreach ($product as $p) {
                $response[] = $p->data();
            }

            echo json_encode($response, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);
            return $response;
        } catch (\Exception $e) {
            http_response_code(404);
            echo json_encode(array("status" => "error",
                "data" => $e->getMessage()),
                JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);
        }
    }

    public function create(array $data)
    {
        header('Content-type: application/json');

        if (!empty($data)) {
            $model = (new \App\Models\Product());

            $message = [];
            foreach ($model->columns() as $m) {
                if (@$m->Field != 'id' && empty($data[$m->Field]) && @$m->Null == 'NO') {
                    $message[] = $m->Field;
                }
            }

            if (!empty($message)) {
                http_response_code(404);
                echo json_encode(array("status" => "error",
                    "type" => "obrigatório", "fields" => $message),
                    JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);
                return;
            }

            $category_id = filter_var($data['category_id'], FILTER_SANITIZE_NUMBER_INT);
            $category = (new \App\Models\Category())->findById($category_id);

            if (empty($category)) {
                http_response_code(404);
                echo json_encode(array("status" => "error",
                    "data" => "categoria inválida"),
                    JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);
            }

            $model->category_id = $category_id;
            $model->name = $data['name'];
            $model->price = $data['price'];
            $model->quantity = $data['quantity'];

            if (!$model->save()) {
                http_response_code(404);
                echo json_encode(array("status" => "error",
                    "data" => "Nao foi possivel salvar o produto"),
                    JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);
            } else {
                $model->save();
                echo json_encode(array("status" => "success",
                    "data" => "produto salvo com sucesso"),
                    JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);
                return;
            }
        }
        http_response_code(404);
        echo json_encode(array("status" => "error",
            "data" => "Nao foi possivel salvar o produto"),
            JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);
    }

    public
    function edit(array $data)
    {
        header('Content-type: application/json');

        if (!empty($data['id'])) {
            $id = filter_var($data['id'], FILTER_SANITIZE_NUMBER_INT);
            $product = (new \App\Models\Product())->findById($id);

            if (empty($product)) {
                http_response_code(404);
                echo json_encode(array("status" => "error",
                    "data" => "identificador inválido"),
                    JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);
                return;
            }

            $product->category_id = $data['category_id'] ?? $product->category_id;
            $product->name = $data['name'] ?? $product->name;
            $product->price = $data['price'] ?? $product->price;
            $product->quantity = $data['quantity'] ?? $product->quantity + 1;

            if (!$product->save()) {
                http_response_code(404);
                echo json_encode(array("status" => "error",
                    "data" => "Nao foi possivel salvar o produto"),
                    JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);
            } else {
                echo json_encode(array("status" => "success",
                    "data" => "produto salvo com sucesso"),
                    JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);
                return;
            }

        }
        http_response_code(404);
        echo json_encode(array("status" => "error",
            "data" => "Nao foi possivel editar o produto"),
            JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);
    }

    public
    function delete(array $data)
    {
        header('Content-type: application/json');

        if (!empty($data['id'])) {
            $id = filter_var($data['id'], FILTER_SANITIZE_NUMBER_INT);
            $product = (new \App\Models\Product())->findById($id);

            if (empty($product)) {
                http_response_code(404);
                echo json_encode(array("status" => "error",
                    "data" => "identificador inválido"),
                    JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);
                return;
            }

            $product->destroy();
            echo json_encode(array("status" => "sucess",
                "data" => "produto excluido com sucesso"),
                JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);
            return;

        }
        http_response_code(404);
        echo json_encode(array("status" => "error",
            "data" => "Nao foi possivel excluir o produto"),
            JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);
    }
}