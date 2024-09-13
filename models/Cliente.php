<?php

namespace app\models;

use Yii;
use yii\db\ActiveRecord;

class Cliente extends ActiveRecord
{
    public static function tableName()
    {
        return 'cliente';
    }

    public function rules()
    {
        return [
            [['nome', 'cpf', 'endereco', 'sexo'], 'required', 'message' => 'Este campo é obrigatório.'],
            ['cpf', 'match', 'pattern' => '/^\d{3}\.\d{3}\.\d{3}-\d{2}$/', 'message' => 'CPF inválido. O formato deve ser xxx.xxx.xxx-xx'],
            ['cpf', 'validateUniqueCpf'], 
            [['endereco'], 'string'],
            [['cep'], 'string', 'max' => 10],
            [['logradouro'], 'string', 'max' => 255],
            [['numero'], 'integer'],
            [['cidade', 'estado', 'complemento'], 'string', 'max' => 255],
            [['sexo'], 'in', 'range' => ['M', 'F'], 'message' => 'Sexo deve ser "M" ou "F"'],
            [['nome'], 'string', 'max' => 255],
        ];
    }

    public function validateUniqueCpf($attribute, $params)
    {
        $query = self::find()->where(['cpf' => $this->cpf]);
    
        if (!$this->isNewRecord) {
            $query->andWhere(['!=', 'id', $this->id]);
        }
    
        $existingCliente = $query->one();
    
        if ($existingCliente) {
            $this->addError($attribute, 'Já existe um cliente com esse CPF.');
        }
    }
    
}
