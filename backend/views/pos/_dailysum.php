<?php

use kartik\daterange\DateRangePicker;
use kartik\grid\GridView;
use yii\helpers\Html;
use yii\widgets\LinkPager;

$this->title = 'สรุปยอดขายประจำวัน';
$pos_date = date('d/m/Y');
$emp_value = 0;
if($emp_id != null){
    $emp_value = $emp_id;
}


$company_id = 1;
$branch_id = 1;
if (!empty(\Yii::$app->user->identity->company_id)) {
    $company_id = \Yii::$app->user->identity->company_id;
}
if (!empty(\Yii::$app->user->identity->branch_id)) {
    $branch_id = \Yii::$app->user->identity->branch_id;
}

//echo $from_date_time;
//if ($show_pos_date != null) {
//    $pos_date = date('d/m/Y', strtotime($show_pos_date));
//}
?>
<!--<form action="--><?//= \yii\helpers\Url::to(['pos/dailysum'], true) ?><!--"-->
<!--      method="post">-->
<!--    -->
<!--</form>-->

<?php echo $this->render('_searchdailysum', ['model' => $searchModel]); ?>
<br/>
<div class="row">
    <div class="col-lg-12">
        <h4 class="text-success">
            รายการขาย</h4>
    </div>
</div>
<div class="row">
    <div class="col-lg-12">
        <?= GridView::widget([
            'dataProvider' => $dataProvider,
            // 'filterModel' => $searchModel,
            'showPageSummary' => true,
            'striped' => true,
            'hover' => true,
            'pjax' => true,
            'panel' => ['type' => 'info', 'heading' => 'รายงานแสดงยอดขายประจำวัน'],
            'toggleDataContainer' => ['class' => 'btn-group mr-2'],
            'emptyCell' => '-',
            'layout' => "{items}\n{summary}\n<div class='text-center'>{pager}</div>",
            'summary' => "แสดง {begin} - {end} ของทั้งหมด {totalCount} รายการ",
            'showOnEmpty' => false,
            //    'bordered' => true,
            //     'striped' => false,
            //    'hover' => true,
            'id' => 'product-grid',
            //'tableOptions' => ['class' => 'table table-hover'],
            'emptyText' => '<div style="color: red;text-align: center;"> <b>ไม่พบรายการไดๆ</b></div>',
            'columns' => [
//                [
//                    'class' => 'yii\grid\SerialColumn',
//                    'headerOptions' => ['style' => 'text-align: center'],
//                    'contentOptions' => ['style' => 'text-align: center'],
//                ],
                [
                    'attribute' => 'code',
                    'label' => 'รหัสสินค้า',
                    'group' => true,
                    'groupHeader' => function ($model, $key, $index, $widget) { // Closure method
                        return [
                            'mergeColumns' => [[0, 1]], // columns to merge in summary
                            'content' => [             // content to show in each summary cell
                                1 => 'ยอดสินค้า (' . $model->code . ')',
                                3 => GridView::F_SUM,
                                4 => GridView::F_SUM,
                                5 => GridView::F_SUM,
                                6 => GridView::F_SUM,
                                7 => GridView::F_SUM,
                                8 => GridView::F_SUM,
                            ],
                            'contentFormats' => [      // content reformatting for each summary cell
                                //4 => ['format' => 'number', 'decimals' => 0],
                                3 => ['format' => 'number', 'decimals' => 2],
                                4 => ['format' => 'number', 'decimals' => 2],
                                5 => ['format' => 'number', 'decimals' => 2],
                                6 => ['format' => 'number', 'decimals' => 2],
                                7 => ['format' => 'number', 'decimals' => 2],
                                8 => ['format' => 'number', 'decimals' => 2],
                            ],
                            'contentOptions' => [      // content html attributes for each summary cell
                                1 => ['style' => 'font-variant:small-caps'],
                                //4 => ['style' => 'text-align:right'],
                                3 => ['style' => 'text-align:right'],
                                4 => ['style' => 'text-align:right'],
                                5 => ['style' => 'text-align:right'],
                                6 => ['style' => 'text-align:right'],
                                7 => ['style' => 'text-align:right'],
                                8 => ['style' => 'text-align:right'],
                            ],
                            // html attributes for group summary row
                            'options' => ['class' => 'info table-info', 'style' => 'font-weight:bold;']
                        ];
                    },
//                    'pageSummaryOptions' => ['class' => 'text-right'],
//                    'pageSummary' => true,
//                    'pageSummaryFunc' => GridView::F_SUM
                ],
                [
                    'attribute' => 'name',
                    'label' => 'ชื่อสินค้า',
                    'pageSummary' => false,
                ],
                [
                    'attribute' => 'price',
                    'value' => function ($data) {
                        return number_format($data->price);
                    },
                    'pageSummary' => false,
                ],
                [
                    'attribute' => 'line_qty_cash',
                    'label' => 'จำนวน(สด)',
                    'headerOptions' => ['style' => 'text-align: right'],
                   // 'contentOptions' => ['style' => 'text-align: right'],
                    'contentOptions' => function($data){
                         $x = $data->line_qty_cash==0?'transparent':'black';
                         return ['style'=> 'text-align: right;color:'.$x];
                    },
                    'value' => function ($data) {
                        return $data->line_qty_cash;
                    },
                    'format' => ['decimal', 2],
                    'pageSummary' => true,
                    'pageSummaryFunc' => GridView::F_SUM,
                    'pageSummaryOptions' => ['class' => 'text-right', 'style' => 'background-color: #6699FF'],
                ],
                [
                    'attribute' => 'line_qty_credit',
                    'label' => 'จำนวน(เชื่อ)',
                    'headerOptions' => ['style' => 'text-align: right'],
                    'contentOptions' => function($data){
                        $x = $data->line_qty_credit==0?'transparent':'black';
                        return ['style'=> 'text-align: right;color:'.$x];
                    },
                    'value' => function ($data) {
                        return $data->line_qty_credit;
                    },
                    'format' => ['decimal', 2],
                    'pageSummary' => true,
                    'pageSummaryFunc' => GridView::F_SUM,
                    'pageSummaryOptions' => ['class' => 'text-right', 'style' => 'background-color: #6699FF'],
                ],
                [
                    'attribute' => 'qty',
                    'label' => 'รวมจำนวน',
                    'headerOptions' => ['style' => 'text-align: right'],
                    'contentOptions' => ['style' => 'text-align: right'],
                    'value' => function ($data) {
                        return $data->qty;
                    },
                    'format' => ['decimal', 2],
                    'pageSummary' => true,
                    'pageSummaryFunc' => GridView::F_SUM,
                    'pageSummaryOptions' => ['class' => 'text-right', 'style' => 'background-color: #6699FF'],
                ],
                [
                    'attribute' => 'line_total_cash',
                    'label' => 'สด',
                    'headerOptions' => ['style' => 'text-align: right'],
                    'contentOptions' => function($data){
                        $x = $data->line_total_cash==0?'transparent':'black';
                        return ['style'=> 'text-align: right;color:'.$x];
                    },
                    'value' => function ($data) {
                        return $data->line_total_cash;
                    },
                    'format' => ['decimal', 2],
                    'pageSummary' => true,
                    'pageSummaryFunc' => GridView::F_SUM,
                    'pageSummaryOptions' => ['class' => 'text-right', 'style' => 'background-color: #6699FF'],
                ],
                [
                    'attribute' => 'line_total_credit',
                    'label' => 'เชื่อ',
                    'headerOptions' => ['style' => 'text-align: right'],
                    'contentOptions' => function($data){
                        $x = $data->line_total_credit==0?'transparent':'black';
                        return ['style'=> 'text-align: right;color:'.$x];
                    },
                    'value' => function ($data) {
                        return $data->line_total_credit;
                    },
                    'format' => ['decimal', 2],
                    'pageSummary' => true,
                    'pageSummaryFunc' => GridView::F_SUM,
                    'pageSummaryOptions' => ['class' => 'text-right', 'style' => 'background-color: #6699FF'],
                ],
                [
                    'attribute' => 'line_total',
                    'label' => 'ยอดขายรวม',
                    'headerOptions' => ['style' => 'text-align: right'],
                    'contentOptions' => ['style' => 'text-align: right'],
                    'value' => function ($data) {
                        return $data->line_total;
                    },
                    'format' => ['decimal', 2],
                    'pageSummary' => true,
                    'pageSummaryFunc' => GridView::F_SUM,
                    'pageSummaryOptions' => ['class' => 'text-right', 'style' => 'background-color: #6699FF'],
                    'subGroupOf' => 1
                ],
            ],
            'pager' => ['class' => LinkPager::className()],
        ]); ?>
    </div>
</div>

<br>
<!--<div class="row">-->
<!--    <div class="col-lg-12">-->
<!--        <h4 class="text-success">-->
<!--            ประเภทชำระเงิน</h4>-->
<!--    </div>-->
<!--</div>-->
<div class="row">
<!--    <div class="col-lg-4">-->
<!--        --><?php //echo GridView::widget([
//            'dataProvider' => $dataProvider2,
//            // 'filterModel' => $searchModel,
//            'showPageSummary' => true,
//            'emptyCell' => '-',
//            'layout' => "{items}\n{summary}\n<div class='text-center'>{pager}</div>",
//            'summary' => "แสดง {begin} - {end} ของทั้งหมด {totalCount} รายการ",
//            'showOnEmpty' => false,
//            //    'bordered' => true,
//            //     'striped' => false,
//            //    'hover' => true,
//            'id' => 'pos-pay',
//            //'tableOptions' => ['class' => 'table table-hover'],
//            'emptyText' => '<div style="color: red;text-align: center;"> <b>ไม่พบรายการไดๆ</b></div>',
//            'columns' => [
//                [
//                    'class' => 'yii\grid\SerialColumn',
//                    'headerOptions' => ['style' => 'text-align: center'],
//                    'contentOptions' => ['style' => 'text-align: center;'],
//                    'footerOptions' => ['style' => 'background: white'],
//                ],
//                [
//                    'attribute' => 'code',
//                    'label' => 'รหัส',
//                    'pageSummaryOptions' => ['class' => 'text-right', 'style' => 'background-color: '],
//                ],
//                [
//                    'attribute' => 'name',
//                    'label' => 'ประเภทชำระเงิน',
//                    'pageSummary' => false,
//                    'pageSummaryOptions' => ['class' => 'text-right', 'style' => 'background-color: '],
//                ],
//                [
//                    'attribute' => 'payment_amount',
//                    'label' => 'ยอดขายรวม',
//                    'headerOptions' => ['style' => 'text-align: right'],
//                    'contentOptions' => ['style' => 'text-align: right'],
//                    'value' => function ($data) {
//                        return $data->payment_amount;
//                    },
//                    'format' => ['decimal', 2],
//                    'pageSummary' => true,
//                    'pageSummaryFunc' => GridView::F_SUM,
//                    'pageSummaryOptions' => ['class' => 'text-right', 'style' => 'background-color: #6699FF'],
//                ]
//            ],
//            'pager' => ['class' => LinkPager::className()],
//        ]); ?>
<!--    </div>-->
    <div class="col-lg-6">
        <?php if($dataProvider->getModels() != null):?>
        <a href="<?= \yii\helpers\Url::to(['pos/posttrans'], true) ?>"
           class="btn btn-success"><i
                    class="fa fa-check"></i>
            ตรวจสอบและปิดยอดขาย</a>
        <p>
            <small>หมายเหตุ: </small><small
                    class="text-danger">กรุณาตรวจสอบข้อมูลให้ครบถ้วนก่อนการยืนยันยอดการทำรายการก่อนส่งยอด</small>
        </p>
        <?php endif;?>
    </div>
</div>
