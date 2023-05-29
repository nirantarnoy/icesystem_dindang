<?php

use yii\helpers\Html;
use kartik\grid\GridView;
use yii\widgets\Pjax;

/* @var $this yii\web\View */
/* @var $searchModel backend\models\StocktransSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'รายงานยอดรับเข้าผลิต';
$this->params['breadcrumbs'][] = $this->title;

$modelx = $dataProvider->getModels();
?>
<div class="stocktrans-index">
    <?php Pjax::begin(); ?>
    <?php echo $this->render('_search', ['model' => $searchModel, 'f_date' => null, 't_date' => null]); ?>
    <br/>
<!--    --><?//= GridView::widget([
//        'dataProvider' => $dataProvider,
//        //'filterModel' => $searchModel,
//        'showPageSummary' => true,
//        'toolbar' => [
//            '{toggleData}',
//            '{export}',
//        ],
//        'panel' => ['type' => 'info', 'heading' => 'รายงานยอดรับเข้าผลิต'],
//        'toggleDataContainer' => ['class' => 'btn-group mr-2'],
//        'columns' => [
////            ['class' => 'yii\grid\SerialColumn',
////                'headerOptions' => ['style' => 'text-align: center'],
////                'contentOptions' => ['style' => 'text-align: center'],],
//            //  'id',
////            'company_id',
////            'branch_id',
//            [
//                'attribute' => 'product_id',
//                'value' => function ($data) {
//                    return \backend\models\Product::findName($data->product_id);
//                },
//            ],
//
//            [
//                'attribute' => 'qty',
//                'headerOptions' => ['style' => 'text-align: right'],
//                'contentOptions' => ['style' => 'text-align: right'],
//                'value' => function ($data) {
//                    $cancel_qty = 0; // \backend\models\Stocktrans::findCancelqty($data->product_id,$from_date,$to_date,$data->company_id,$data->branch_id);
//
//
//                    return ($data->qty - $cancel_qty);
//                },
//                'format' => ['decimal', 2],
//                'hAlign' => 'right',
//                'pageSummary' => true,
//                'pageSummaryFunc' => GridView::F_SUM
//            ],
//
//        ],
//    ]); ?>
<!---->
<!--    --><?php //Pjax::end(); ?>

    <?php
     $total_rec = 0;
     $total_cancel = 0;
     $total_qty = 0;
     ?>
    <table class="table table-bordered table-striped">
        <thead>
        <tr>
            <th><b>รหัสสินค้า</b></th>
            <th style="text-align: right"><b>จำนวน</b></th>
            <th style="text-align: right"><b>ยกเลิก</b></th>
            <th style="text-align: right"><b>จำนวนรับผลิต</b></th>
        </tr>

        </thead>
        <tbody>
        <?php foreach ($modelx as $value):?>
        <?php
            $cancel_qty = \backend\models\Stocktrans::findCancelqty($value->product_id,$from_date,$to_date,$value->company_id,$value->branch_id);
            $total_qty = $total_qty + ($value->qty - $cancel_qty);
            $total_rec = ($total_rec + $value->qty);
            $total_cancel = ($total_cancel + $cancel_qty);
            ?>
        <tr>
            <td>
                <?=\backend\models\Product::findName($value->product_id)?>
            </td>
            <td style="text-align: right">
                <?=number_format(($value->qty),2)?>
            </td>
            <td style="text-align: right">
                <?=number_format(($cancel_qty),2)?>
            </td>
            <td style="text-align: right">
                <?=number_format(($value->qty - $cancel_qty),2)?>
            </td>
        </tr>
        <?php endforeach;?>
        </tbody>
        <tfoot>
        <tr style="background-color: #1abc9c">
            <td></td>
            <td style="text-align: right">  <?=number_format($total_rec,2)?></td>
            <td style="text-align: right">  <?=number_format($total_cancel,2)?></td>
            <td style="text-align: right"> <?=number_format($total_qty,2)?></td>
        </tr>
        </tfoot>

    </table>
    <table style="width: 100%;border: 0px;">
        <tr>
            <td style="text-align: right;border: 0px;">
                FM-WAT-02
            </td>
        </tr>
    </table>

</div>
