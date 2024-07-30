<?php
date_default_timezone_set('Asia/Bangkok');

use chillerlan\QRCode\QRCode;
use yii\web\Response;

//require_once __DIR__ . '/vendor/autoload.php';
//require_once 'vendor/autoload.php';
// เพิ่ม Font ให้กับ mPDF

$defaultFontConfig = (new Mpdf\Config\FontVariables())->getDefaults();
$fontData = $defaultFontConfig['fontdata'];
$mpdf = new \Mpdf\Mpdf(['tempDir' => __DIR__ . '/tmp',
//$mpdf = new \Mpdf\Mpdf([
    //'tempDir' => '/tmp',
    'mode' => 'utf-8', 'format' => [80, 250],
    'fontdata' => $fontData + [
            'sarabun' => [ // ส่วนที่ต้องเป็น lower case ครับ
                'R' => 'THSarabunNew.ttf',
                'I' => 'THSarabunNewItalic.ttf',
                'B' => 'THSarabunNewBold.ttf',
                'BI' => "THSarabunNewBoldItalic.ttf",
            ]
        ],
]);

//$mpdf->SetMargins(-10, 1, 1);
$mpdf->SetDisplayMode('fullpage');
$mpdf->AddPageByArray([
    'margin-left' => 5,
    'margin-right' => 0,
    'margin-top' => 0,
    'margin-bottom' => 1,
]);

//$customer_name = $trans_data[0]['customer_id']?getCustomername($connect, $trans_data[0]['customer_id']):$trans_data[0]['customer_name'];
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
            font-size: 18px;
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

    </style>
    <!--    <script src="vendor/jquery/jquery.min.js"></script>-->
    <!--    <script type="text/javascript" src="js/ThaiBath-master/thaibath.js"></script>-->
</head>
<body>
<table class="table-qrcode" style="width: 100%">
    <tr>
        <td style="width: 2%">
            <div style="height: 20px;width: 20px;">
                <?php
                $order_no = "ICE";
                if($model["order_no"] != ''){
                    $order_no = $model["order_no"];
                }
                \Yii::$app->response->format = Response::FORMAT_HTML;
                $data = $order_no;
                $qr = new QRCode();
                echo '<img src="' . $qr->render($data) . '" />';
                ?>
            </div>
        </td>
        <td style="width: 98%">
            <table class="table-header" width="100%">
                <tr>
                    <td style="font-size: 20px;text-align: center;vertical-align: bottom">
                        <h2>น้ำแข็ง</h2>
                    </td>
                </tr>
                <tr>
                    <td style="font-size: 20px;text-align: center;vertical-align: top">
                        <h2>ใบสั่งจ่าย</h2>
                    </td>
                </tr>
            </table>
        </td>
    </tr>
</table>
<table class="table-header" width="100%">
    <tr>
        <td style="font-size: 18px;text-align: left">เลขที่ <span><?php echo $model["order_no"]; ?></span>
        </td>
        <td style="font-size: 18px;text-align: left">
            วันที่ <span><?= date('d/m/Y', strtotime($model["order_date"])); ?></span>
        </td>
    </tr>
    <tr>
        <td style="font-size: 18px;text-align: left">
            ลูกค้า <span><?= \backend\models\Customer::findName($model["customer_id"]); ?></span>
        </td>
        <td style="font-size: 18px;text-align: left">
            เวลา <span><?= date('H:i:s', strtotime($model["order_date"])); ?></span>
        </td>
    </tr>
</table>
<table class="table-title">
    <tr>
        <td style="border-top: 1px dotted gray;border-bottom: 1px dotted gray"><b>รายการ</b></td>
        <td style="text-align: center;border-top: 1px dotted gray;border-bottom: 1px dotted gray"><b>จำนวน</b></td>
        <td style="text-align: center;border-top: 1px dotted gray;border-bottom: 1px dotted gray"><b>ราคา</b></td>
        <td style="text-align: right;border-top: 1px dotted gray;border-bottom: 1px dotted gray"><b>รวม</b></td>
    </tr>
    <?php
    $total_qty = 0;
    $total_amt = 0;
    $discount = 0;
    $change = 0;
    $items_cnt  = 0;
    ?>
    <?php if($model_line != null):?>
    <?php for($i=0;$i<=count($model_line)-1;$i++): ?>
        <?php
        $total_qty = $total_qty + $model_line[$i]["qty"];
        $total_amt = $total_amt + ($model_line[$i]["qty"] * $model_line[$i]["price"]);
        $change = $change_amount == null ? 0 : $change_amount;//$value->change_amount;
        $items_cnt +=1;
        ?>
        <tr>
            <td><?= \backend\models\Product::findName($model_line[$i]["product_id"]); ?></td>
            <td style="text-align: center"><?= number_format($model_line[$i]["qty"],1) ?></td>
            <td style="text-align: center"><?= number_format($model_line[$i]["price"],2) ?></td>
            <td style="text-align: right"><?= number_format($model_line[$i]["qty"] * $model_line[$i]["price"], 2); ?></td>
        </tr>
    <?php endfor; ?>
    <?php endif;?>
    <tfoot>
    <tr>
        <td style="font-size: 18px;border-top: 1px dotted gray">จำนวนรายการ</td>
        <td style="font-size: 18px;border-top: 1px dotted gray;text-align: center"><?= number_format($items_cnt) ?></td>
        <td style="font-size: 18px;border-top: 1px dotted gray;text-align: center"></td>
        <td style="font-size: 18px;border-top: 1px dotted gray;text-align: right"><?= number_format($total_amt, 2) ?></td>
    </tr>
    <tr>
        <td style="font-size: 18px;">ส่วนลด</td>
        <td></td>
        <td></td>
        <td style="font-size: 18px;text-align: right"><?= number_format($discount, 2) ?></td>
    </tr>
    <tr>
        <td style="font-size: 18px;">จำนวนสุทธิ</td>
        <td></td>
        <td></td>
        <td style="font-size: 18px;text-align: right"> <?= number_format($total_amt - $discount, 2) ?></td>
    </tr>
    <tr>
        <td style="font-size: 18px;">ทอนเงิน</td>
        <td></td>
        <td></td>
        <td style="font-size: 18px;text-align: right"> <?= number_format($change, 2) ?></td>
    </tr>
    </tfoot>
</table>
<table class="table-header">
    <tr><td></td></tr>
</table>
<table class="table-header">
    <tr>
        <td style="font-size: 18px;">แคชเชียร์ ........ <span style="position: absolute;"><?=\backend\models\User::findName(\Yii::$app->user->id)?></span> .........</td>
    </tr>
    <tr>
        <td><p style="font-size: 15px;">Process time used <span><?=$model["time_used"]?></span></p></td>
    </tr>
</table>
<br/>
<br/>
</body>
</html>
<?php
$slip_path = '';
if($branch_id == 1){
    $slip_path = '../web/uploads/company1/slip/slip_index.pdf';
}else if($branch_id == 2){
    $slip_path = '../web/uploads/company2/slip/slip_index.pdf';
}
//    if(file_exists('../web/uploads/slip/slip_index.pdf')){
//        unlink('../web/uploads/slip/slip_index.pdf');
//    }
if(file_exists($slip_path)){
    unlink($slip_path);
}

$html = ob_get_contents(); // ทำการเก็บค่า HTML จากคำสั่ง ob_start()
$mpdf->WriteHTML($html); // ทำการสร้าง PDF ไฟล์
//$mpdf->Output( 'Packing02.pdf','F'); // ให้ทำการบันทึกโค้ด HTML เป็น PDF โดยบันทึกเป็นไฟล์ชื่อ MyPDF.pdf
ob_clean();
//$mpdf->SetJS('this.print();');
$mpdf->SetJS('this.print();');

//$mpdf->Output('../web/uploads/slip/slip_index.pdf', 'F');
$mpdf->Output($slip_path, 'F');

ob_end_flush();

//header("location: system_stock/report_pdf/Packing.pdf");

?>
<!--ดาวโหลดรายงานในรูปแบบ PDF <a class="btn-export-pdf" href="MyPDF.pdf">คลิกที่นี้</a>-->

