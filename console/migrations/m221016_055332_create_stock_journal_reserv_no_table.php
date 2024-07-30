<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%stock_journal_reserv_no}}`.
 */
class m221016_055332_create_stock_journal_reserv_no_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%stock_journal_reserv_no}}', [
            'id' => $this->primaryKey(),
            'module_id' => $this->integer(),
            'company_id' => $this->integer(),
            'branch_id' => $this->integer(),
            'journal_no' => $this->string(),
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%stock_journal_reserv_no}}');
    }
}
