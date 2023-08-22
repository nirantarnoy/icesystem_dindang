<?php
namespace backend\controllers;

use backend\models\SalereportSearch;
use \Yii;
use backend\models\SalecomSearch;
use yii\web\Controller;

class SalereportController extends Controller{
    public $enableCsrfValidation =false;
    public function actionIndex2(){

        //$searchModel = new SalereportSearch();
        $searchModel = new \backend\models\SaleorderbyrouteSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        //   $dataProvider->query->andFilterWhere(['>','qty',0])->andFilterWhere(['customer_id'=>2247]);
        $dataProvider->query->andFilterWhere(['>','qty',0]);
        $dataProvider->query->andFilterWhere(['!=','status',3]);
        $dataProvider->setSort([
            'defaultOrder'=>['route_code'=>SORT_ASC,'order_date'=>SORT_ASC,'payment_method_id'=>SORT_ASC,'customer_id'=>SORT_ASC,'product_id'=>SORT_ASC]
        ]);

        return $this->render('_index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }
    public function actionIndex(){

        $id = \Yii::$app->request->post('find_customer_id');
        $from_date = \Yii::$app->request->post('from_date');
        $to_date = \Yii::$app->request->post('to_date');

       // $model = \backend\models\Orders::find()->where(['customer_id' => $id])->all();
        return $this->render('_print', [
        //    'model' => $model,
            'find_from_date' => $from_date,
            'find_to_date'=> $to_date,
            'find_customer_id'=>$id,
        ]);
    }
    public function actionIndexcar(){

        $id = \Yii::$app->request->post('find_customer_id');
        $from_date = \Yii::$app->request->post('from_date');
        $to_date = \Yii::$app->request->post('to_date');

        // $model = \backend\models\Orders::find()->where(['customer_id' => $id])->all();
        return $this->render('_printcar', [
            //    'model' => $model,
            'find_from_date' => $from_date,
            'find_to_date'=> $to_date,
            'find_customer_id'=>$id,
        ]);
    }
    public function actionComsale(){
        $company_id = 0;
        $branch_id = 0;

        if (!empty(\Yii::$app->user->identity->company_id)) {
            $company_id = \Yii::$app->user->identity->company_id;
        }
        if (!empty(\Yii::$app->user->identity->branch_id)) {
            $branch_id = \Yii::$app->user->identity->branch_id;
        }
        $from_date = \Yii::$app->request->post('from_date');
        $to_date = \Yii::$app->request->post('to_date');
        //  $find_sale_type = \Yii::$app->request->post('find_sale_type');
        $find_route_id = \Yii::$app->request->post('find_route_id');
        return $this->render('_comsale', [
            'from_date' => $from_date,
            'to_date'=> $to_date,
            'company_id' =>$company_id,
            'branch_id'=>$branch_id,
            'find_route_id'=>$find_route_id
        ]);
    }

}
