<?php

use yii\db\Migration;

class m200907_141609_create_table_question extends Migration {

    public $newTableName = 'question';

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
        $this->dropTable($newTableName);

        $this->createTable($newTableName, [
            'id'          => $this->primaryKey(),

            'name'        => $this->string()->notNull()->comment('Название'),
            'lft'         => $this->integer()->notNull(), // left attribute in table schema
            'rgt'         => $this->integer()->notNull(), // right attribute in table schema
            'depth'       => $this->integer()->notNull(), // depth attribute in table schema (note: it must be signed int)

            'active'     => $this->boolean()->notNull()->defaultValue(true)->comment('Активно'),
            'created_at' => $this->integer()->notNull()->comment(Yii::t('app', 'Создано')),
            'updated_at' => $this->integer()->comment(Yii::t('app', 'Изменено')),
        ], $tableOptions);

        $this->addCommentOnTable($newTableName, 'Вопросы с вариантами ответов Nested Sets.\nНеобходим https://github.com/paulzi/yii2-nested-sets');

        $this->createIndex('idx-'.$newTableName.'-lft_rgt', $newTableName, ['lft', 'rgt']);
        $this->createIndex('idx-'.$newTableName.'-rgt',     $newTableName, 'rgt');

        $this->insert($newTableName, [
            'id'          => 1,
            'name'        => 'root',
            'lft'         => 1,
            'rgt'         => 2,
            'depth'       => 0,
            'active'      => true,
            'created_at'  => time(),
        ]);
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
