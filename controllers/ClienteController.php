<?php

namespace app\controllers;

use Yii;
use app\models\Cliente;
use yii\rest\Controller;
use yii\web\Response;

class ClienteController extends Controller
{
    public function actionCreate()
    {
        Yii::$app->response->format = Response::FORMAT_JSON;
        $request = Yii::$app->request->post();
        
        $cliente = new Cliente();
        $cliente->attributes = $request;

        if ($cliente->validate() && $cliente->save()) {
            return ['status' => 'success', 'data' => $cliente];
        }

        return ['status' => 'error', 'errors' => $cliente->errors];
    }
}
