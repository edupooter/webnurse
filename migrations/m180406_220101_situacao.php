<?php

use yii\db\Schema;

class m180406_220101_situacao extends \yii\db\Migration
{
    public function up()
    {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_general_ci ENGINE=InnoDB';
        }
        
        $this->createTable('situacao', [
            'id' => $this->primaryKey(),
            'nome' => $this->string(40)->notNull()->defaultValue('(não informado)'),
            ], $tableOptions);
                
    }

    public function down()
    {
        $this->dropTable('situacao');
    }
}
