<?php


namespace App\Models;

use CoffeeCode\DataLayer\Connect;
use CoffeeCode\DataLayer\DataLayer;


class BrazilStates extends DataLayer
{
    public function __construct()
    {
        parent::__construct("brazil_states", []);
    }

    public function deleteAll()
    {
        $model = new BrazilStates();

        if(!empty($model)) {
            Connect::getInstance();
            $query = "TRUNCATE brazil_states";
            Connect::getInstance()->beginTransaction();
            $connect = Connect::getInstance();
            $stmt = $connect->query($query);

            if($stmt->execute()) {
                Connect::getInstance()->commit();
                return true;
            }
            Connect::getInstance()->rollBack();
            return false;
        }
        return false;
    }
}