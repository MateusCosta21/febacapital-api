<?php

namespace app\controllers;

use Yii;
use yii\rest\Controller;
use yii\web\Response;
use app\models\User;
use Firebase\JWT\JWT;
use Firebase\JWT\Key;

class AuthController extends Controller
{
    public $enableCsrfValidation = false;

    public function actionLogin()
    {
        Yii::$app->response->format = Response::FORMAT_JSON;
        $request = Yii::$app->request->post();
        $username = $request['username'] ?? null;
        $password = $request['password'] ?? null;

        if ($username && $password) {
            $user = User::findByUsername($username);

            if ($user && $user->validatePassword($password)) {
                $token = $this->generateJwtToken($user);
                return ['token' => $token];
            }

            return ['error' => 'Invalid credentials'];
        }

        return ['error' => 'Missing parameters'];
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

        return JWT::encode($payload, $key, 'HS256');
    }

}

