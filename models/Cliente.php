<?php

namespace app\models;

use Yii;
use yii\db\ActiveRecord;
use app\components\services\CepService;

class Cliente extends ActiveRecord
{
    public static function tableName()
    {
        return 'cliente';
    }

    public function rules()
    {
        return [
            [['nome', 'cpf', 'endereco', 'sexo'], 'required'],
            ['cpf', 'match', 'pattern' => '/^\d{3}\.\d{3}\.\d{3}-\d{2}$/', 'message' => 'CPF inválido. O formato deve ser xxx.xxx.xxx-xx'],
            [['endereco'], 'string'],
            [['cep'], 'string', 'max' => 10],
            [['logradouro'], 'string', 'max' => 255],
            [['numero'], 'integer'],
            [['cidade', 'estado', 'complemento'], 'string', 'max' => 255],
            [['sexo'], 'in', 'range' => ['M', 'F'], 'message' => 'Sexo deve ser "M" ou "F"'],
            [['nome'], 'string', 'max' => 255],
        ];
    }
    

}
