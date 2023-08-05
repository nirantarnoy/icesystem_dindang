<?php

namespace backend\controllers;

use backend\models\LocationSearch;
use Yii;
use backend\models\Customertaxinvoice;
use backend\models\CustomertaxinvoiceSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * CustomertaxinvoiceController implements the CRUD actions for Customertaxinvoice model.
 */
class CustomertaxinvoiceController extends Controller
{
    public $enableCsrfValidation = false;

    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['POST'],
                ],
            ],
        ];
    }

    /**
     * Lists all Customertaxinvoice models.
     * @return mixed
     */
    public function actionIndex()
    {
        $pageSize = \Yii::$app->request->post("perpage");
        $searchModel = new CustomertaxinvoiceSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        $dataProvider->setSort(['defaultOrder' => ['id' => SORT_DESC]]);
        $dataProvider->pagination->pageSize = $pageSize;

//        return $this->render('index', [
//            'searchModel' => $searchModel,
//            'dataProvider' => $dataProvider,
//            'perpage' => $pageSize,
//        ]);

        return $this->render('_printshortpreview');
    }

    /**
     * Displays a single Customertaxinvoice model.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new Customertaxinvoice model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Customertaxinvoice();

        if ($model->load(Yii::$app->request->post())) {
            $order_line_id_list = \Yii::$app->request->post('order_line_id_list');
            $line_product_group_id = \Yii::$app->request->post('line_product_group_id');
            $line_qty = \Yii::$app->request->post('line_qty');
            $line_price = \Yii::$app->request->post('line_price');
            $line_discount = \Yii::$app->request->post('line_discount');
            $line_total = \Yii::$app->request->post('line_total');

            if($model->save(false)){
                if($line_product_group_id != null){
                    for($i=0;$i<=count($line_product_group_id)-1;$i++){
                        $modelline = new \common\models\CustomerTaxInvoiceLine();
                        $modelline->tax_invoice_id = $model->id;
                        $modelline->product_group_id = $line_product_group_id[$i];
                        $modelline->qty = $line_qty[$i];
                        $modelline->price = $line_price[$i];
                        $modelline->discount_amount = $line_discount[$i];
                        $modelline->line_total = $line_total[$i];
                        $modelline->save(false);
                    }
                }
                if($order_line_id_list != null){
                    $arr = explode(',',$order_line_id_list);
                    if($arr != null){
                        for($x=0;$x<=count($arr)-1;$x++){
                            $model_x = new \common\models\CustomerTaxInvoiceDetail();
                            $model_x->customer_tax_invoice_id = $model->id;
                            $model_x->order_line_id = $arr[$x];
                            $model_x->save(false);
                        }
                    }
                }
            }
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('create', [
            'model' => $model,
            'model_line' => null,
        ]);
    }

    /**
     * Updates an existing Customertaxinvoice model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);
        $model_line = \common\models\CustomerTaxInvoiceLine::find()->where(['tax_invoice_id'=>$id])->all();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('update', [
            'model' => $model,
            'model_line' => $model_line,
        ]);
    }

    /**
     * Deletes an existing Customertaxinvoice model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the Customertaxinvoice model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Customertaxinvoice the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Customertaxinvoice::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }

    public function actionFindorder()
    {
        $customer_id = 210;// \Yii::$app->request->post('customer_id');
      //  $customer_id =  \Yii::$app->request->post('customer_id');
        $html = '';
        if ($customer_id > 0) {
            $model = \backend\models\Orders::find()->select(['id', 'order_date'])->where(['customer_id' => $customer_id])->limit(20)->all();
            if ($model) {
                foreach ($model as $x_value) {
//                    $html .= $x_value->id;
                    $modelline = \backend\models\Orderline::find()->where(['order_id' => $x_value->id])->andFilterWhere(['is','tax_status',new \yii\db\Expression('null')])->all();
                    if ($modelline) {
                        foreach ($modelline as $value) {
                            $product_group_name = \backend\models\Product::findGroupName($value->product_id);
                            $html .= '<tr>';
                            $html .= '<td style="text-align: center">
                            <div class="btn btn-outline-success btn-sm" onclick="addselecteditem($(this))" data-var="' . $value->id . '">เลือก</div>
                            <input type="hidden" class="line-find-order-id" value="' . $value->order_id . '">
                            <input type="hidden" class="line-find-product-id" value="' . $value->product_id . '">
                            <input type="hidden" class="line-find-qty" value="' . $value->qty . '">
                            <input type="hidden" class="line-find-price" value="' . $value->price . '">
                            <input type="hidden" class="line-find-product-group-id" value="' . \backend\models\Product::findGroupId($value->product_id) . '">
                            <input type="hidden" class="line-find-product-group-name" value="' . $product_group_name . '">
                           </td>';
                            $html .= '<td style="text-align: left">' . \backend\models\Orders::getNumber($value->order_id) . '</td>';
                            $html .= '<td style="text-align: left">' . date('d-m-Y', strtotime($x_value->order_date)) . '</td>';
                            $html .= '<td style="text-align: left">' . \backend\models\Product::findCode($value->product_id) . '</td>';
                            $html .= '<td style="text-align: left">' . \backend\models\Product::findName($value->product_id) . '</td>';
                            $html .= '<td style="text-align: left">' . $product_group_name . '</td>';
                            $html .= '<td style="text-align: right">' . number_format($value->qty, 1) . '</td>';
                            $html .= '<td style="text-align: right">' . number_format($value->price, 1) . '</td>';
                            $html .= '<td style="text-align: right">' . number_format($value->line_total, 1) . '</td>';
                            $html .= '</tr>';
                        }
                    }
                }


            }
        }
        echo $html;
    }

    public function actionOrdersearch(){
        $from_date = \Yii::$app->request->post('search_from_date');
        $to_date = \Yii::$app->request->post('search_to_date');
        $customer_id = 210;// \Yii::$app->request->post('customer_id');
        //  $customer_id =  \Yii::$app->request->post('customer_id');
        $html = '';

        if ($customer_id != 0 && $from_date != null && $to_date) {

            $search_from_date = null;
            $search_to_date = null;

            $x1 = explode('/',$from_date);
            $x2 = explode('/',$to_date);
            if($x1!=null && count($x1)>1){
                $search_from_date = $x1[2].'-'.$x1[1].'-'.$x1[0];
            }
            if($x2!=null && count($x2)>1){
                $search_to_date = $x2[2].'-'.$x2[1].'-'.$x2[0];
            }

          //  $html.= $search_from_date. ' and '.$search_to_date;

            $model = \backend\models\Orders::find()->select(['id', 'order_date'])->where(['customer_id' => $customer_id])->andFilterWhere(['BETWEEN','date(order_date)',$search_from_date,$search_to_date])->limit(20)->all();
            if ($model) {
                foreach ($model as $x_value) {
//                    $html .= $x_value->id;
                    $modelline = \backend\models\Orderline::find()->where(['order_id' => $x_value->id])->andFilterWhere(['is','tax_status',new \yii\db\Expression('null')])->all();
                    if ($modelline) {
                        foreach ($modelline as $value) {
                            $product_group_name = \backend\models\Product::findGroupName($value->product_id);
                            $html .= '<tr>';
                            $html .= '<td style="text-align: center">
                            <div class="btn btn-outline-success btn-sm" onclick="addselecteditem($(this))" data-var="' . $value->id . '">เลือก</div>
                            <input type="hidden" class="line-find-order-id" value="' . $value->order_id . '">
                            <input type="hidden" class="line-find-product-id" value="' . $value->product_id . '">
                            <input type="hidden" class="line-find-qty" value="' . $value->qty . '">
                            <input type="hidden" class="line-find-price" value="' . $value->price . '">
                            <input type="hidden" class="line-find-product-group-id" value="' . \backend\models\Product::findGroupId($value->product_id) . '">
                            <input type="hidden" class="line-find-product-group-name" value="' . $product_group_name . '">
                           </td>';
                            $html .= '<td style="text-align: left">' . \backend\models\Orders::getNumber($value->order_id) . '</td>';
                            $html .= '<td style="text-align: left">' . date('d-m-Y', strtotime($x_value->order_date)) . '</td>';
                            $html .= '<td style="text-align: left">' . \backend\models\Product::findCode($value->product_id) . '</td>';
                            $html .= '<td style="text-align: left">' . \backend\models\Product::findName($value->product_id) . '</td>';
                            $html .= '<td style="text-align: left">' . $product_group_name . '</td>';
                            $html .= '<td style="text-align: right">' . number_format($value->qty, 1) . '</td>';
                            $html .= '<td style="text-align: right">' . number_format($value->price, 1) . '</td>';
                            $html .= '<td style="text-align: right">' . number_format($value->line_total, 1) . '</td>';
                            $html .= '</tr>';
                        }
                    }
                }
            }else{
                $html.='<tr>';
                $html.='<td colspan="9" style="text-align: center;color: red;">';
                $html.='ไม่พบข้อมูล';
                $html.='</td>';
                $html.='</tr>';
            }
        }else{
            $html.='<tr>';
            $html.='<td colspan="9" style="text-align: center;color: red;">';
            $html.='ไม่พบข้อมูล';
            $html.='</td>';
            $html.='</tr>';
        }
        echo $html;
    }

    public function actionConvertnumtostring()
    {
        $txt = '';
       $amount = \Yii::$app->request->post('amount');
       if($amount >=0){
           $txt = self::numtothai($amount);
       }
       echo $txt;
    }
    public function numtothai($num)
    {
        $return = "";
        $num = str_replace(",", "", $num);
        $number = explode(".", $num);
        if (sizeof($number) > 2) {
            return 'รูปแบบข้อมุลไม่ถูกต้อง';
            exit;
        } else if (sizeof($number) == 1) {
            $number[1] = 0;
        }
        // return $number[0];
        $return .= self::numtothaistring($number[0]) . "บาท";

        $stang = intval($number[1]);
        // return $stang;
        if ($stang > 0) {
            if (strlen($stang) == 1) {
                $stang = $stang . '0';
            }
            if ($stang == '10') {
                $return .= 'สิบสตางค์';
            } else if ($stang == '11') {
                $return .= 'สิบเอ็ดสตางค์';
            } else if ($stang == '12') {
                $return .= 'สิบสองสตางค์';
            } else if ($stang == '13') {
                $return .= 'สิบสามสตางค์';
            } else if ($stang == '14') {
                $return .= 'สิบสี่สตางค์';
            } else if ($stang == '15') {
                $return .= 'สิบห้าสตางค์';
            } else if ($stang == '16') {
                $return .= 'สิบหกสตางค์';
            } else if ($stang == '17') {
                $return .= 'สิบเจ็ดสตางค์';
            } else if ($stang == '18') {
                $return .= 'สิบแปดสตางค์';
            } else if ($stang == '19') {
                $return .= 'สิบเก้าสตางค์';
            } else {
                $return .= self::numtothaistring($stang) . "สตางค์";
            }

        } else {
            $return .= "ถ้วน";
        }
        return $return;
    }
    public function numtothaistring($num)
    {
        $return_str = "";
        $txtnum1 = array('', 'หนึ่ง', 'สอง', 'สาม', 'สี่', 'ห้า', 'หก', 'เจ็ด', 'แปด', 'เก้า');
        $txtnum2 = array('', 'สิบ', 'ร้อย', 'พัน', 'หมื่น', 'แสน', 'ล้าน');
        $num_arr = str_split($num);
        $count = count($num_arr);
        foreach ($num_arr as $key => $val) {
            // echo $count." ".$val." ".$key."</br>";
            if ($count > 1 && $val == 1 && $key == ($count - 1)) {
                $return_str .= "เอ็ด";
            } else if ($count > 1 && $val == 1 && $key == 2) {
                $return_str .= $txtnum2[$val];
            } else if ($count > 1 && $val == 2 && $key == ($count - 2)) {
                $return_str .= "ยี่" . $txtnum2[$count - $key - 1];
            } else if ($count > 1 && $val == 0) {
            } else {
                $return_str .= $txtnum1[$val] . $txtnum2[$count - $key - 1];
            }
        }
        return $return_str;
    }


    public function actionPrintshort(){
        $id = \Yii::$app->request->post('print_id');
         $this->renderPartial('_printshort',[
            'print_id'=>$id,
            'branch_id'=>1
        ]);

        $session = \Yii::$app->session;
        $session->setFlash('msg-slip-tax', 'slip_tax.pdf');
      //  return $this->redirect(['customertaxinvoice/update','id'=>$id]);
        return $this->render('_printshortpreview');
    }
    public function actionPrintfull(){
        $id = \Yii::$app->request->post('print_id');
        return $this->render('_printfull',[
            'print_id'=>$id,
        ]);
    }
}
