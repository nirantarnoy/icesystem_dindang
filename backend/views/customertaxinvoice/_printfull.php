<?php
$model = \backend\models\Customertaxinvoice::find()->where(['id' => $print_id])->one();
$modelline = \common\models\CustomerTaxInvoiceLine::find()->where(['tax_invoice_id' => $print_id])->all();
?>
<!DOCTYPE html>
<html>
<head>
    <meta content="text/html;charset=utf-8" http-equiv="Content-Type">
    <meta content="utf-8" http-equiv="encoding">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Print</title>
    <link href="https://fonts.googleapis.com/css?family=Sarabun&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: sarabun;
            /*font-family: garuda;*/
            font-size: 16px;
        }

        table.table-header {
            border: 0px;
            border-spacing: 1px;
        }

        table.table-qrcode {
            border: 0px;
            border-spacing: 1px;
        }

        table.table-qrcode td, th {
            border: 0px solid #dddddd;
            text-align: left;
            padding-top: 2px;
            padding-bottom: 2px;
        }

        table.table-footer {
            border: 0px;
            border-spacing: 0px;
        }

        table.table-header td, th {
            border: 0px solid #dddddd;
            text-align: left;
            padding-top: 2px;
            padding-bottom: 2px;
        }

        table.table-title {
            border: 0px;
            border-spacing: 0px;
        }

        table.table-title td, th {
            border: 0px solid #dddddd;
            text-align: left;
            padding-top: 2px;
            padding-bottom: 2px;
        }

        table {
            border-collapse: collapse;
            width: 100%;
        }

        td, th {
            border: 1px solid #dddddd;
            text-align: left;
            padding: 8px;
        }

        tr:nth-child(even) {
            /*background-color: #dddddd;*/
        }

        table.table-detail {
            border-collapse: collapse;
            width: 100%;
        }

        table.table-detail td, th {
            border: 1px solid #dddddd;
            text-align: left;
            padding: 2px;
        }
        table.table-invoice-no {
            font-size: 12px;
        }
        table.table-list-detail{
            font-size: 12px;
        }

    </style>
    <!--    <script src="vendor/jquery/jquery.min.js"></script>-->
    <!--    <script type="text/javascript" src="js/ThaiBath-master/thaibath.js"></script>-->
</head>
<body>
<table style="100%">
    <tr>
        <td style="width: 33.33%;border: none;">
            <div class="row">
                <div class="col-lg-12" style="text-align: left;">
                    <h6>บริษัท วรภัทร จำกัด (สาขาที่ 00001)</h6>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-12" style="text-align: left;">
                    <p style="font-size: 12px;">167 หมู่ 6 ต.ห้วยจรเข้ อ.เมืองนครปฐม จ.นครปฐม 73000 <br>เลขประจำตัวผู้เสียภาษีอากร
                        0-7355-17000-11-1</p>
                </div>
            </div>
        </td>
        <td style="width: 33.33%;border: none;">
            <div class="row">
                <div class="col-lg-12" style="text-align: center;">
                    <h6>ใบกำกับภาษี/ใบส่งสินค้า</h6><h5>TAX INVOICE/INVOICE</h5>
                </div>
            </div>
        </td>
        <td style="width: 33.33%;border: none;text-align: right;vertical-align: top;">
            <h6>เอกสารออกเป็นชุด</h6>
        </td>
    </tr>
</table>
<div class="row">
    <div class="col-lg-12">
        <table style="width: 100%;border-collapse: collapse;" class="table-invoice-no">
            <tr>
                <td style="width: 65%">
                    <table style="width: 100%;border-collapse: collapse;">
                        <tr><td style="width: 20%;border:none;">รหัสลูกค้า</td><td style="border: none;"><?=\backend\models\Customer::findCode($model->customer_id)?></td></tr>
                        <tr><td style="border: none;">นามลูกค้า</td><td style="border: none;"><?=\backend\models\Customer::findName($model->customer_id)?></td></tr>
                        <tr><td style="border: none;">ที่อยู่</td><td style="border: none;"></td></tr>
                        <tr><td style="color: white;border: none;">xx</td><td style="border: none;"></td></tr>
                    </table>
                </td>
                <td style="width: 35%">
                    <table style="width: 100%;border-collapse: collapse;border:none;">
                        <tr><td style="width: 50%;border: none;">วันที่</td><td style="border: none;"><?=date('d/m/Y')?></td></tr>
                        <tr><td style="border: none;">เลขที่ใบกำกับ</td><td style="border: none;"><?=$model->invoice_no?></td></tr>
                        <tr><td style="border: none;">กำหนดชำระเงิน</td><td style="border: none;"></td></tr>
                        <tr><td style="border: none;">ครบกำหนด</td><td style="border: none;"></td></tr>
                    </table>
                </td>
            </tr>
        </table>
    </div>
</div>
<div style="height: 2px;"></div>
<div class="row">
    <div class="col-lg-12">
        <table class="table-list-detail">
            <thead>
            <tr>
                <th style="text-align: center;padding: 10px;">รหัสสินค้า/รายละเอียด</th>
                <th style="text-align: center;">จำนวน</th>
                <th style="text-align: center;">หน่วยละ</th>
                <th style="text-align: center;">ส่วนลด</th>
                <th colspan="2" style="text-align: right;">จำนวนเงิน</th>
            </tr>
            </thead>
            <tbody>
            <?php $total = 0; ?>
            <?php foreach ($modelline as $value): ?>
                <tr>
                    <td><?= \backend\models\Productgroup::findName($value->product_group_id) ?></td>
                    <td style="text-align: center;"><?= number_format($value->qty, 2) ?></td>
                    <td style="text-align: center;"><?= number_format($value->price, 2) ?></td>
                    <td style="text-align: center;"><?= number_format($value->discount_amount, 2) ?></td>
                    <td style="text-align: right;"><?= number_format($value->line_total, 2) ?></td>
                </tr>
                <?php $total = ($total + $value->line_total); ?>
            <?php endforeach; ?>
            </tbody>
            <tfoot>
            <tr>
                <td colspan="2" style="border-right: 0px;text-align: center;"><b>(<?=$model->total_text?>)</b></td>
                <td colspan="2" style="text-align: left;"><b>รวมเงิน</b></td>
                <td style="text-align: right"><?= number_format($total, 2) ?></td>
            </tr>
            <tr>
                <td colspan="2" style="border-left: 0px;border-bottom: 0px;border-right: 0px;border-top: 0px;text-align: center;"></td>
                <td colspan="2" style="text-align: left;border-right: 0px;border-top: 0px;"><b>ภาษีมูลค่าเพิ่ม</b></td>
                <td style="text-align: right"><?= number_format($model->vat_amount, 2) ?></td>
            </tr>
            <tr>
                <td colspan="2" style="border-left: 0px;border-bottom: 0px;border-right: 0px;border-top: 0px;text-align: center;"></td>
                <td colspan="2" style="text-align: left;border-right: 0px;border-top: 0px;"><b>ยอดเงินสุทธิ</b></td>
                <td style="text-align: right"><?= number_format($model->net_amount, 2) ?></td>
            </tr>
            </tfoot>
        </table>
    </div>
</div>
<br/>
<div class="row">
    <div class="col-lg-4">
        <table style="width: 100%;border: 1px solid grey;border-radius: 20px;" class="table-list-detail">
            <tr>
                <td style="text-align: center;border-bottom: 0px;">ได้รับสินค้าตามรายการถูกต้องแล้ว</td>
            </tr>
            <tr>
                <td style="text-align: left;border-top:0px;border-bottom: 0px;">.........................................................................</td>
            </tr>
            <tr>
                <td style="text-align: left;border-top:0px;">วันที่ ..............................................................</td>
            </tr>
        </table>
    </div>
    <div class="col-lg-4">
        <table style="width: 100%;border-radius: 10px" class="table-list-detail">
            <tr>
                <td style="text-align: center;border-bottom: 0px;">ผู้ส่งของ</td>
            </tr>
            <tr>
                <td style="text-align: left;border-top:0px;border-bottom: 0px;">.........................................................................</td>
            </tr>
            <tr>
                <td style="text-align: left;border-top:0px;">วันที่ ..............................................................</td>
            </tr>
        </table>
    </div>
    <div class="col-lg-4">
        <table style="width: 100%;border-radius: 10px" class="table-list-detail">
            <tr>
                <td style="text-align: center;border-bottom: 0px;">ผู้อนุมัติ</td>
            </tr>
            <tr>
                <td style="text-align: left;border-top:0px;border-bottom: 0px;">.........................................................................</td>
            </tr>
            <tr>
                <td style="text-align: left;border-top:0px;">วันที่ ..............................................................</td>
            </tr>
        </table>
    </div>
</div>
</body>
</html>