<?php


namespace App\Controllers;


class Category
{
    public function index(array $data)
    {
        try {
            $category = (new \App\Models\Category())->find()->order('id')->fetch(true);

            header('Content-type: application/json');

            $response = [];
            foreach ($category as $c)
                $response[] = $c->data();

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
            $model = (new \App\Models\Category());

            $message = [];
            foreach ($model->columns() as $m) {
                if (empty($data[$m->Field]) && $m->Null == 'NO' && @$m->Field != 'id') {
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

            $model->name = $data['name'];

            if (!$model->save()) {
                http_response_code(404);
                echo json_encode(array("status" => "error",
                    "data" => "Nao foi possivel salvar a categoria"),
                    JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);
            } else {
                $model->save();
                echo json_encode(array("status" => "success",
                    "data" => "categoria salva com sucesso"),
                    JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);
                return;
            }
        }
        http_response_code(404);
        echo json_encode(array("status" => "error",
            "data" => "Nao foi possivel salvar o categoria"),
            JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);
    }

    public function edit(array $data)
    {
        header('Content-type: application/json');

        if (!empty($data['id'])) {
            $id = filter_var($data['id'], FILTER_SANITIZE_NUMBER_INT);
            $product = (new \App\Models\Category())->findById($id);

            if (empty($product)) {
                http_response_code(404);
                echo json_encode(array("status" => "error",
                    "data" => "identificador inválido"),
                    JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);
                return;
            }

            $product->name = $data['name'] ?? $product->name;

            if (!$product->save()) {
                http_response_code(404);
                echo json_encode(array("status" => "error",
                    "data" => "Nao foi possivel salvar a categoria"),
                    JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);
            } else {
                echo json_encode(array("status" => "success",
                    "data" => "categoria salva com sucesso"),
                    JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);
                return;
            }

        }
        http_response_code(404);
        echo json_encode(array("status" => "error",
            "data" => "Nao foi possivel editar a categoria"),
            JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);
    }

    public function delete(array $data)
    {
        header('Content-type: application/json');

        if (!empty($data['id'])) {
            $id = filter_var($data['id'], FILTER_SANITIZE_NUMBER_INT);
            $product = (new \App\Models\Category())->findById($id);

            if (empty($product)) {
                http_response_code(404);
                echo json_encode(array("status" => "error",
                    "data" => "identificador inválido"),
                    JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);
                return;
            }

            $product->destroy();
            echo json_encode(array("status" => "sucess",
                "data" => "categoria excluida com sucesso"),
                JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);
            return;

        }
        http_response_code(404);
        echo json_encode(array("status" => "error",
            "data" => "Nao foi possivel excluir a categoria"),
            JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);
    }
}