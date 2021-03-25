<?php


namespace App\Controllers;


class Category
{
    public function index()
    {

        $category = (new \App\Models\Category())->find()->order('id')->fetch(true);

//       header comentado para rodar os testes
//       header('Content-type: application/json');

        $response = [];
        foreach ($category as $c)
            $response[] = $c->data();

        echo json_encode(array(
            "status" => "success",
            "class" => "Controller/Category",
            "method" => "list",
            "data" => $response),
            JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);
        return $response;
    }

    public function create($data)
    {

//       header comentado para rodar os testes
//       header('Content-type: application/json');

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
                echo json_encode(array(
                    "status" => "error",
                    "type" => "invalid_data",
                    "class" => "Controller/Category",
                    "method" => "create",
                    "message" => "obrigatório", "fields" => $message),
                    JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);
                return false;
            }

            $model->name = $data['name'];

            $model->save();
            echo json_encode(array(
                "status" => "success",
                "class" => "Controller/Category",
                "method" => "create",
                "id" => $model->id,
                "message" => "categoria salva com sucesso"),
                JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);
            return true;
        }
        http_response_code(404);
        echo json_encode(array(
            "status" => "error",
            "type" => "invalid_data",
            "class" => "Controller/Category",
            "method" => "create",
            "message" => "não foi possivel salvar o categoria"),
            JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);
        return false;
    }

    public function findById(array $data)
    {
//       header comentado para rodar os testes
//       header('Content-type: application/json');

        if (!empty($data['id'])) {
            $id = filter_var($data['id'], FILTER_SANITIZE_NUMBER_INT);
            $category = (new \App\Models\Category())->findById($id);

            if (empty($category)) {
                http_response_code(404);
                echo json_encode(array(
                    "status" => "error",
                    "type" => "invalid_data",
                    "class" => "Controller/Category",
                    "method" => "findById",
                    "message" => "identificador inválido"),
                    JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);
                return false;
            }

            $response = $category->data();

            echo json_encode(array(
                "status" => "success",
                "class" => "Controller/Category",
                "method" => "findById", "data" => $response),
                JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);
            return $response;
        }
        http_response_code(404);
        echo json_encode(array(
            "status" => "error",
            "type" => "invalid_data",
            "class" => "Controller/Category",
            "method" => "findById",
            "message" => "não foi possivel buscar a categoria"),
            JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);
        return false;
    }

    public function edit(array $data)
    {
//       header comentado para rodar os testes
//       header('Content-type: application/json');

        if (!empty($data['id'])) {
            $id = filter_var($data['id'], FILTER_SANITIZE_NUMBER_INT);
            $object = (new \App\Models\Category())->findById($id);

            if (empty($object)) {
                http_response_code(404);
                echo json_encode(array(
                    "status" => "error",
                    "type" => "invalid_data",
                    "class" => "Controller/Category",
                    "method" => "edit",
                    "message" => "identificador inválido"),
                    JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);
                return false;
            }

            $object->name = $data['name'] ?? $object->name;

            $object->save();
            echo json_encode(array(
                "status" => "success",
                "class" => "Controller/Category",
                "method" => "edit",
                "id" => $object->id,
                "message" => "categoria editada com sucesso"),
                JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);
            return true;

        }
        http_response_code(404);
        echo json_encode(array(
            "status" => "error",
            "type" => "invalid_data",
            "class" => "Controller/Category",
            "method" => "edit",
            "message" => "não foi possivel editar a categoria"),
            JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);
        return false;
    }

    public function delete(array $data)
    {
//       header comentado para rodar os testes
//       header('Content-type: application/json');

        if (!empty($data['id'])) {
            $id = filter_var($data['id'], FILTER_SANITIZE_NUMBER_INT);
            $object = (new \App\Models\Category())->findById($id);

            if (empty($object)) {
                http_response_code(404);
                echo json_encode(array(
                    "status" => "error",
                    "type" => "invalid_data",
                    "class" => "Controller/Category",
                    "method" => "delete",
                    "message" => "identificador inválido"),
                    JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);
                return false;
            }

            $object->destroy();
            echo json_encode(array(
                "status" => "sucess",
                "class" => "Controller/Category",
                "method" => "delete",
                "id" => $id,
                "message" => "categoria excluida com sucesso"),
                JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);
            return true;

        }
        http_response_code(404);
        echo json_encode(array(
            "status" => "error",
            "type" => "invalid_data",
            "class" => "Controller/Category",
            "method" => "delete",
            "message" => "não foi possivel excluir a categoria"),
            JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);
        return false;
    }
}