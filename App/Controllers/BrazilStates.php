<?php


namespace App\Controllers;


use CoffeeCode\DataLayer\Connect;

class BrazilStates
{
    public function create()
    {
        $apiGetStates = (new \App\Support\BrazilStates());
        $apiGetStates->getBrazilStates();
        $response = $apiGetStates->callback();

        if (empty($response))
            return false;

        self::registerResponseInDatabase($response);
        return true;
    }

    public function index()
    {
//        header('Content-type: application/json');
        $states = (new \App\Models\BrazilStates())->find()->fetch(true);

        if ($states) {

            $arrayStates = [];
            foreach ($states as $state) {
                $arrayStates[] = $state->data();
            }

            http_response_code(200);
            echo json_encode(array(
                "status" => "success",
                "class" => "Controller/BrazilState",
                "method" => "index",
                "data" => $arrayStates),
                JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);
            return true;

        } else {
            http_response_code(400);
            echo json_encode(array(
                "status" => "error",
                "type" => "invalid_data",
                "class" => "Controller/BrazilStats",
                "method" => "index",
                "message" => "nao possui estados registrados"),
                JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);
            return false;
        }
    }

    private function registerResponseInDatabase(array $data)
    {
//        header comentado para rodar testes
//        header('Content-type: application/json');

        $message = [];
        $arrayStats = [];
        if (!empty($data)) {

            $model = (new \App\Models\BrazilStates());

            if (!$model->find()->count() > 0) {
                foreach ($data as $state) {
                    $newModel = (new \App\Models\BrazilStates());

                    $newModel->state_id = $state->id;
                    $newModel->name = $state->nome;
                    $newModel->sigla = $state->sigla;

                    if (!$newModel->save()) {
                        http_response_code(404);
                        echo json_encode(array(
                            "status" => "error",
                            "type" => "database",
                            "class" => "BrazilStates",
                            "method" => "createStates",
                            "message" => "nao foi possivel salvar os registros"),
                            JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);
                        return false;
                    }
                }

                $quantidadeEstados = sizeof($data);
                http_response_code(201);
                echo json_encode(array(
                    "status" => "success",
                    "class" => "BrazilStates",
                    "method" => "createStates",
                    "message" => "{$quantidadeEstados} registros incluidos com sucesso"),
                    JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);
                return true;

            }

            http_response_code(400);
            echo json_encode(array(
                "status" => "error",
                "type" => "data_duplicate",
                "class" => "BrazilStates",
                "method" => "createStates",
                "message" => "os registros nao foram salvos. Sua base de dados já possui os estados cadastrados"),
                JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);
            return false;
        }

        http_response_code(400);
        echo json_encode(array(
            "status" => "error",
            "type" => "response_api_extern",
            "class" => "BrazilStates",
            "method" => "createStates",
            "message" => "array empty"),
            JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);
        return false;
    }

    public function delete()
    {
        $model = (new \App\Models\BrazilStates());

        if ($model->find()->count() > 0) {

            if ($model->deleteAll()) {
                http_response_code(200);
                echo json_encode(array(
                    "status" => "success",
                    "class" => "BrazilStates",
                    "method" => "createStates",
                    "message" => "registros excluidos com sucesso"),
                    JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);
                return true;
            }
            http_response_code(404);
            echo json_encode(array(
                "status" => "error",
                "class" => "BrazilStates",
                "method" => "create",
                "message" => "não foi possivel excluir registros"),
                JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);
            return true;
        }
        http_response_code(400);
        echo json_encode(array(
            "status" => "error",
            "class" => "BrazilStates",
            "method" => "create",
            "message" => "a base de dados nao possui registros para excluir"),
            JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);
        return true;

    }
}