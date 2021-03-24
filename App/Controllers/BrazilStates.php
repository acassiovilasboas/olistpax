<?php


namespace App\Controllers;


class BrazilStates
{
    public function getStates()
    {
        $states = self::getStatesApi();
        $states = json_decode($states);

        $this->createStates($states);

    }

    public function index()
    {
        header('Content-type: application/json');
        $states = (new \App\Models\BrazilStates())->find()->fetch(true);

        if($states) {

            $arrayStates = [];
            foreach ($states as $state) {
                $arrayStates[] = $state->data();
            }

            echo json_encode($arrayStates,
                JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);

        } else {
            http_response_code(404);
            echo json_encode(array("status" => "error",
                "data" => "nao possui estados registrados"),
                JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);
        }
    }

    private static function getStatesApi()
    {
        $curl = curl_init();

        curl_setopt_array($curl, array(
            CURLOPT_URL => 'https://servicodados.ibge.gov.br/api/v1/localidades/estados',
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'GET',
        ));

        $response = curl_exec($curl);

        curl_close($curl);
        return $response;
    }

    private function createStates(array $data)
    {
        header('Content-type: application/json');

        if ($data) {
            foreach ($data as $state) {
                $model = (new \App\Models\BrazilStates());

                $model->state_id = $state->id;
                $model->name = $state->nome;
                $model->sigla = $state->sigla;

                if (!$model->save()) {
                    http_response_code(404);
                    echo json_encode(array("status" => "error",
                        "data" => "nao foi possivel salvar os estados"),
                        JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);
                    return;
                }
            }

            $quantidadeEstados = sizeof($data);
            echo json_encode(array("status" => "success",
                "data" => "{$quantidadeEstados} registros incluidos com sucesso"),
                JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);
        }
    }
}