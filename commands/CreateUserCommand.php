<?php

namespace app\commands;

use Yii;
use yii\console\Controller;
use app\models\User;
use yii\helpers\Console;

class CreateUserCommand extends Controller
{
    public function actionIndex($username, $password, $name)
    {
        $user = new User();
        $user->username = $username;
        $user->name = $name;
        $user->password_hash = Yii::$app->security->generatePasswordHash($password);
        $user->auth_key = Yii::$app->security->generateRandomString();
        $user->access_token = Yii::$app->security->generateRandomString();
        $user->created_at = time();
        $user->updated_at = time();

        if ($user->save()) {
            $token = $this->generateJwtToken($user);

            Console::output('User created successfully.');
            Console::output('Token: ' . $token);
        } else {
            foreach ($user->errors as $attribute => $errors) {
                Console::output("Error in $attribute: " . implode(', ', $errors));
            }
        }
    }

    private function generateJwtToken($user)
    {
        $key = Yii::$app->params['jwtKey'];
        $payload = [
            'iss' => 'your-issuer',
            'iat' => time(),
            'exp' => time() + 3600, 
            'sub' => $user->id,
        ];

        return \Firebase\JWT\JWT::encode($payload, $key, 'HS256');
    }
}
