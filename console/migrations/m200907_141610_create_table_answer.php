<?php

use yii\db\Migration;

class m200907_141610_create_table_answer extends Migration {

    public $newTableName = 'answer';

    public function up() {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            $tableOptions = 'CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE=InnoDB';
        }

        $newTableName = $this->newTableName;
        if ($this->db->driverName === 'pgsql') {
            $newTableName = Yii::$app->params['schema'] . '.' . $newTableName;
        }

        // Удаляем если сбойная таблица
        //$this->dropTable($newTableName);

        $this->createTable($newTableName, [
            'id' => $this->primaryKey()->notNull(),

            'respondent_name'    => $this->string(255)->notNull()->comment(Yii::t('app', 'Имя')),
            'respondent_email'   => $this->string(255)->notNull()->comment(Yii::t('app', 'E-mail')),
            'respondent_comment' => $this->text()->comment(Yii::t('app', 'Комментарий')),
            'question_id'        => $this->integer()->notNull()->comment(Yii::t('app', 'Ответ')),

            'created_at' => $this->integer()->notNull()->comment(Yii::t('app', 'Создано')),
            'updated_at' => $this->integer()->comment(Yii::t('app', 'Изменено')),
        ], $tableOptions  . ' COMMENT="Ответ"');
    }

    public function down() {
        $newTableName = $this->newTableName;
        if ($this->db->driverName === 'pgsql') {
            $newTableName = Yii::$app->params['schema'] . '.' . $newTableName;
        }
        $this->execute('SET FOREIGN_KEY_CHECKS = 0');
        $this->dropTable($newTableName);
        $this->execute('SET FOREIGN_KEY_CHECKS = 1');
    }
}
