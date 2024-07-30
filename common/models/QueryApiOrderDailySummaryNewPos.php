<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "query_api_order_daily_summary_new_pos".
 *
 * @property int $id
 * @property string|null $order_no
 * @property string|null $order_date
 * @property int|null $status
 * @property int|null $car_ref_id
 * @property string|null $code
 * @property string|null $name
 * @property int|null $payment_method_id
 * @property string|null $product_code
 * @property string|null $product_name
 * @property int $order_line_id
 * @property int|null $product_id
 * @property float|null $line_qty
 * @property float|null $price
 * @property float|null $line_total
 * @property int|null $order_line_status
 * @property int|null $created_at
 * @property int|null $customer_id
 * @property int|null $sale_payment_method_id
 * @property int|null $order_channel_id
 * @property string|null $customer_ref_no
 * @property float|null $discount_amt
 * @property int|null $order_shift
 * @property int|null $created_by
 */
class QueryApiOrderDailySummaryNewPos extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'query_api_order_daily_summary_new_pos';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'status', 'car_ref_id', 'payment_method_id', 'order_line_id', 'product_id', 'order_line_status', 'created_at', 'customer_id', 'sale_payment_method_id', 'order_channel_id', 'order_shift', 'created_by'], 'integer'],
            [['order_date'], 'safe'],
            [['line_qty', 'price', 'line_total', 'discount_amt'], 'number'],
            [['order_no', 'code', 'name', 'product_code', 'product_name', 'customer_ref_no'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'order_no' => 'Order No',
            'order_date' => 'Order Date',
            'status' => 'Status',
            'car_ref_id' => 'Car Ref ID',
            'code' => 'Code',
            'name' => 'Name',
            'payment_method_id' => 'Payment Method ID',
            'product_code' => 'Product Code',
            'product_name' => 'Product Name',
            'order_line_id' => 'Order Line ID',
            'product_id' => 'Product ID',
            'line_qty' => 'Line Qty',
            'price' => 'Price',
            'line_total' => 'Line Total',
            'order_line_status' => 'Order Line Status',
            'created_at' => 'Created At',
            'customer_id' => 'Customer ID',
            'sale_payment_method_id' => 'Sale Payment Method ID',
            'order_channel_id' => 'Order Channel ID',
            'customer_ref_no' => 'Customer Ref No',
            'discount_amt' => 'Discount Amt',
            'order_shift' => 'Order Shift',
            'created_by' => 'Created By',
        ];
    }
}
