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


class UpdateController extends Controller
{


    public function actionMark()
    {

        echo 'start mark users'.PHP_EOL;
        $usersModel = new Users();

        $usersModel->write([], ['mark'=>1]);

        echo 'end mark users'.PHP_EOL;
        return true;
    }

    public function actionStart()
    {
        echo 'start change password'.PHP_EOL;
        $usersModel = new Users();

        $users = $usersModel->find(['mark'=>1]);
        foreach ($users as $user) {
            $bytes = openssl_random_pseudo_bytes(8);
            $password = bin2hex($bytes);
            $passwordHash = password_hash($password, PASSWORD_DEFAULT);
            $usersModel->update($user['_id'], ['password_hash' => $passwordHash, 'mark'=>0]);

            //mb send new password $password
        }

        echo 'end change password'.PHP_EOL;

        return true;
    }
}
