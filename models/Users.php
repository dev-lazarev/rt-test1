<?php
/**
 * Created by PhpStorm.
 * User: Lazarev Aleksey
 * Date: 22.08.16
 * Time: 10:27
 */

namespace app\models;


class Users extends AbstractMongoModel
{

    public function getBase()
    {
        return 'databasename';
    }

    public function getCollection()
    {
        return 'users';
    }

    public function getFromId($id)
    {

        return $this->findOne([
            '_id' => $id,
        ]);
    }

    public function getFromLogin($login)
    {

        return $this->findOne([
            'login' => $login,
        ]);
    }


    public function update($id, $data = [])
    {

        $update = [];

        if (!empty($data)) {
            foreach ($data as $name => $value) {
                if ($name != '_id') {
                    $update['$set'][$name] = $value;
                }
            }
        }


        $this->write(
            [
                '_id' => $id
            ],
            $update
        );

        return $update['$set'];
    }


}