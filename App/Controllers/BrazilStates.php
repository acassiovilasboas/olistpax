<?php



namespace App\Controllers;


class BrazilStates
{
    public function getStates()
    {
        $apiGetStates = (new \App\Support\BrazilStates());
        $apiGetStates->getBrazilStates();
        $response = $apiGetStates->callback();

        if(empty($response))
            return false;

        self::createStates($response);
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

            echo json_encode(array(
                "status" => "success",
                "class" => "Controller/BrazilState",
                "method" => "index",
                "data" => $arrayStates),
                JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);
            return true;

        } else {
            http_response_code(404);
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

    private function createStates(array $data)
    {
//        header comentado para rodar testes
//        header('Content-type: application/json');

        if ($data) {
            foreach ($data as $state) {
                $model = (new \App\Models\BrazilStates());

                $model->state_id = $state->id;
                $model->name = $state->nome;
                $model->sigla = $state->sigla;

                if (!$model->save()) {
                    http_response_code(404);
                    echo json_encode(array(
                        "status" => "error",
                        "type" => "database",
                        "class" => "BrazilStates",
                        "method" => "createStates",
                        "message" => "nao foi possivel salvar os estados"),
                        JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);
                    return false;
                }
            }

            $quantidadeEstados = sizeof($data);
            echo json_encode(array(
                "status" => "success",
                "class" => "BrazilStates",
                "method" => "createStates",
                "message" => "{$quantidadeEstados} registros incluidos com sucesso"),
                JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);
            return true;
        }
    }
}