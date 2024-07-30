<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "query_plan".
 *
 * @property int $id
 * @property string|null $trans_date
 * @property int|null $company_id
 * @property int|null $branch_id
 * @property int|null $product_id
 * @property string|null $code
 * @property string|null $name
 * @property float|null $qty
 * @property int|null $customer_id
 * @property string|null $customer_code
 * @property string|null $customer_name
 */
class QueryPlan extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'query_plan';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['company_id', 'branch_id'], 'integer'],
            [['trans_date'], 'safe'],
            [['qty'], 'number'],
            [['code', 'name',], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'trans_date' => 'Trans Date',
            'company_id' => 'Company ID',
            'branch_id' => 'Branch ID',
            'code' => 'Code',
            'name' => 'Name',
            'qty' => 'Qty',
        ];
    }
}
