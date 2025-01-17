<?php

use yii\db\Migration;

/**
 * Handles adding columns to table `{{%transaction_pos_sale_sum}}`.
 */
class m240618_060354_add_transfer_in_qty_column_to_transaction_pos_sale_sum_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('{{%transaction_pos_sale_sum}}', 'transfer_in_qty', $this->float());
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn('{{%transaction_pos_sale_sum}}', 'transfer_in_qty');
    }
}
