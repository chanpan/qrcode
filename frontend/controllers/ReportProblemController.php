<?php

namespace frontend\controllers;

use appxq\sdii\utils\SDdate;
use appxq\sdii\utils\VarDumper;
use cpn\chanpan\classes\CNMessage;
use Yii;
use frontend\models\ReportProblem;
use frontend\models\search\ReportProblem as ReportProblemSearch;
use yii\helpers\Json;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use yii\web\Response;
use appxq\sdii\helpers\SDHtml;

/**
 * ReportProblemController implements the CRUD actions for ReportProblem model.
 */
class ReportProblemController extends Controller
{


    public function beforeAction($action)
    {
            Yii::$app->language = 'th';
            if (in_array($action->id, array('index', 'view', 'create', 'update', 'delete', 'deletes', 'qrcode'))) {
                $admin = isset(Yii::$app->session['admin']) ? Yii::$app->session['admin'] : '';
                $person = isset(Yii::$app->session['person']) ? Yii::$app->session['person'] : '';
                if ($admin == '' && $person == '') {
                    return $this->redirect(['/site/index']);
                }
            }
            if(in_array($action->id ,['problem','get-problem']) ){
                header('Access-Control-Allow-Origin: *');
                header('Access-Control-Allow-Methods: DELETE, POST, GET, OPTIONS');
                //header('Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With,x-token');
                $this->enableCsrfValidation = false;
            }
            return parent::beforeAction($action);

    }

    /**
     * Lists all ReportProblem models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new ReportProblemSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single ReportProblem model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id)
    {
        if (Yii::$app->getRequest()->isAjax) {
            return $this->renderAjax('view', [
                'model' => $this->findModel($id),
            ]);
        } else {
            return $this->render('view', [
                'model' => $this->findModel($id),
            ]);
        }
    }

    /**
     * Creates a new ReportProblem model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        if (Yii::$app->getRequest()->isAjax) {
            $model = new ReportProblem();

            if ($model->load(Yii::$app->request->post())) {
                $model->date = date('Y-m-d H:i:s');
                if ($model->save()) {
                    return \cpn\chanpan\classes\CNMessage::getSuccess('สร้างสำเร็จ');
                } else {
                    return \cpn\chanpan\classes\CNMessage::getError('สร้างไม่สำเร็จ');
                }
            } else {
                return $this->renderAjax('create', [
                    'model' => $model,
                ]);
            }
        } else {
            throw new NotFoundHttpException('Invalid request. Please do not repeat this request again.');
        }
    }

    /**
     * Updates an existing ReportProblem model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        if (Yii::$app->getRequest()->isAjax) {
            $model = $this->findModel($id);

            if ($model->load(Yii::$app->request->post())) {
                $model->date = date('Y-m-d H:i:s');
                if ($model->save()) {
                    return \cpn\chanpan\classes\CNMessage::getSuccess('แก้ไขสำเร็จ');
                } else {
                    return \cpn\chanpan\classes\CNMessage::getError('แก้ไขไม่สำเร็จ');
                }
            } else {
                return $this->renderAjax('update', [
                    'model' => $model,
                ]);
            }
        } else {
            throw new NotFoundHttpException('Invalid request. Please do not repeat this request again.');
        }
    }

    /**
     * Deletes an existing ReportProblem model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        if (Yii::$app->getRequest()->isAjax) {
            Yii::$app->response->format = Response::FORMAT_JSON;
            if ($this->findModel($id)->delete()) {
                return \cpn\chanpan\classes\CNMessage::getSuccess('ลบสำเร็จ');
            } else {
                return \cpn\chanpan\classes\CNMessage::getError('ลบไม่สำเร็จ');
            }
        } else {
            throw new NotFoundHttpException('Invalid request. Please do not repeat this request again.');
        }
    }

    public function actionDeletes()
    {
        if (Yii::$app->getRequest()->isAjax) {
            Yii::$app->response->format = Response::FORMAT_JSON;
            if (isset($_POST['selection'])) {
                foreach ($_POST['selection'] as $id) {
                    $this->findModel($id)->delete();
                }
                return \cpn\chanpan\classes\CNMessage::getSuccess('ลบสำเร็จ');
            } else {
                return \cpn\chanpan\classes\CNMessage::getError('ลบไม่สำเร็จ');
            }
        } else {
            throw new NotFoundHttpException('Invalid request. Please do not repeat this request again.');
        }
    }
    public function actionProblem(){

       if(Yii::$app->request->post()) {
           $data = Yii::$app->request->post('datas');
           $data = Json::decode($data);
           $model = new ReportProblem();
           $model->title = isset($data['title']) ? $data['title'] : '';
           $model->detail = isset($data['detail']) ? $data['detail'] : '';
           $model->user_name = isset($data['name']) ? $data['name'] : '';
           $model->tel = isset($data['tel']) ? $data['tel'] : '';
           $model->status = 0;
           $model->date = date('Y-m-d H:i:s');
           if($model->save()){
               return CNMessage::getSuccess('ส่งข้อมูลแจ้งปัญหาสำเร็จ');
           }else{
               return CNMessage::getError('ไม่สำเร็จ', $model->errors);
           }
       }

        return $this->render('problem');
    }
    public function actionGetProblem(){
        $results = ReportProblem::find()->orderBy(['id'=>SORT_DESC])->all();
        $output = [];

        if($results){
            foreach($results as $k=>$v){
                $v->date = SDdate::mysql2phpDateTime($v->date);
                $output[] = $v;
            }
            return CNMessage::getSuccess('สำเร็จ', $output);
        }else{
            return CNMessage::getError('ไม่สำเร็จ');
        }
    }

    /**
     * Finds the ReportProblem model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return ReportProblem the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = ReportProblem::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
