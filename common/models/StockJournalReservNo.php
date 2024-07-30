<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "stock_journal_reserv_no".
 *
 * @property int $id
 * @property int|null $module_id
 * @property int|null $company_id
 * @property int|null $branch_id
 * @property string|null $journal_no
 */
class StockJournalReservNo extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'stock_journal_reserv_no';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['module_id', 'company_id', 'branch_id'], 'integer'],
            [['journal_no'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'module_id' => 'Module ID',
            'company_id' => 'Company ID',
            'branch_id' => 'Branch ID',
            'journal_no' => 'Journal No',
        ];
    }
}
