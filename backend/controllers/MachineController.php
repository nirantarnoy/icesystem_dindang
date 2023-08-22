<?php

namespace backend\controllers;

use backend\models\PositionSearch;
use Yii;
use backend\models\Machine;
use backend\models\MachineSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * MachineController implements the CRUD actions for Machine model.
 */
class MachineController extends Controller
{
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
     * Lists all Machine models.
     * @return mixed
     */
    public function actionIndex()
    {
        $viewstatus = 1;

        if(\Yii::$app->request->get('viewstatus')!=null){
            $viewstatus = \Yii::$app->request->get('viewstatus');
        }

        $pageSize = \Yii::$app->request->post("perpage");
        $searchModel = new MachineSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        if($viewstatus ==1){
            $dataProvider->query->andFilterWhere(['status'=>$viewstatus]);
        }
        if($viewstatus == 2){
            $dataProvider->query->andFilterWhere(['status'=>0]);
        }

        $dataProvider->setSort(['defaultOrder' => ['id' => SORT_DESC]]);
        $dataProvider->pagination->pageSize = $pageSize;

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'perpage' => $pageSize,
            'viewstatus'=>$viewstatus,
        ]);
    }

    /**
     * Displays a single Machine model.
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
     * Creates a new Machine model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Machine();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing Machine model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing Machine model.
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
     * Finds the Machine model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Machine the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Machine::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }

    public function actionCreatemclist(){
        $mc = [1,2,3];
        $l = ['A','B','C','D'];

        for($i=0;$i<=count($mc)-1;$i++){
            for($x=0;$x<=count($l)-1;$x++){
                for($z=1;$z<=50;$z++){
                    $model = new \common\models\MachineDetail();
                    $model->machine_id = $mc[$i];
                    $model->loc_name = $l[$x].$z;
                    $model->loc_qty = 10;
                    $model->status = 1;
                    $model->company_id =1;
                    $model->branch_id = 1;
                    $model->save(false);
                }

            }

        }
    }

    public function actionUpdateproductionstatus(){
        $model = \common\models\MachineDetail::find()->all();
        foreach ($model as $value){
            $x = new \common\models\ProductionStatus();
            $x->loc_id = $value->id;
            $x->loc_name = $value->loc_name;
            $x->color_status = 'G';
            $x->product_id = $value->machine_id;
            $x->company_id = 1;
            $x->branch_id = 1;
            $x->save(false);
        }
    }
}
