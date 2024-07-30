<?php

use yii\db\Migration;

/**
 * Handles adding columns to table `{{%order_line}}`.
 */
class m210403_011908_add_sale_payment_method_id_column_to_order_line_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('{{%order_line}}', 'sale_payment_method_id', $this->integer());
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn('{{%order_line}}', 'sale_payment_method_id');
    }
}
