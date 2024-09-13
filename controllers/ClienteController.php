<?php

namespace app\controllers;

use Yii;
use app\models\Cliente;
use yii\rest\Controller;
use yii\web\Response;
use yii\data\ActiveDataProvider;

class ClienteController extends Controller
{

    public function actionList()
    {
        Yii::$app->response->format = Response::FORMAT_JSON;

        $query = Cliente::find();

        // Filtros
        $nome = Yii::$app->request->get('nome');
        $cpf = Yii::$app->request->get('cpf');

        if ($nome) {
            $query->andFilterWhere(['like', 'nome', $nome]);
        }

        if ($cpf) {
            $query->andFilterWhere(['cpf' => $cpf]);
        }

        // Ordenação
        $sort = Yii::$app->request->get('sort');
        if (in_array($sort, ['nome', 'cpf', 'cidade'])) {
            $query->orderBy($sort);
        }

        // Paginação
        $limit = Yii::$app->request->get('limit', 10);
        $offset = Yii::$app->request->get('offset', 0);

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'pagination' => [
                'pageSize' => $limit,
                'page' => (int)($offset / $limit),
            ],
        ]);

        return $dataProvider->getModels();
    }
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
