<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%cliente}}`.
 */
class m240913_215017_create_cliente_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%cliente}}', [
            'id' => $this->primaryKey(),
            'nome' => $this->string()->notNull(),
            'cpf' => $this->string()->notNull()->unique(),
            'endereco' => $this->text()->notNull(),
            'cep' => $this->string()->notNull(),
            'logradouro' => $this->string()->notNull(),
            'numero' => $this->integer()->notNull(),
            'cidade' => $this->string()->notNull(),
            'estado' => $this->string()->notNull(),
            'complemento' => $this->string(),
            'sexo' => $this->string(1)->notNull(),
        ]);
    }
    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%cliente}}');
    }
}
