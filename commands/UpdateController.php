<?php
/**
 * Created by PhpStorm.
 * User: Lazarev Aleksey
 * Date: 22.08.16
 * Time: 10:22
 */


namespace app\commands;

use app\models\Users;
use Yii;
use yii\console\Controller;
use yii\db\Expression;


class TestController extends Controller
{


    public function actionMark()
    {

        $usersModel = new Users();

        $usersModel->write([], ['mark'=>1]);

        return false;
    }

    public function actionStart()
    {

        $usersModel = new Users();

        $users = $usersModel->find(['mark'=>1]);
        foreach ($users as $user) {
            $bytes = openssl_random_pseudo_bytes(8);
            $password = bin2hex($bytes);
            $passwordHash = password_hash($password, PASSWORD_DEFAULT);
            $usersModel->update($user['_id'], ['password_hash' => $passwordHash, 'mark'=>0]);

            //mb send new password $password
        }
        return false;
    }
}
