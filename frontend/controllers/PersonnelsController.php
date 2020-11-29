<?php

namespace frontend\controllers;

use Yii;
use frontend\models\Personnels;
use frontend\models\search\Personnels as PersonnelsSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use yii\web\Response;
use appxq\sdii\helpers\SDHtml;

/**
 * PersonnelsController implements the CRUD actions for Personnels model.
 */
class PersonnelsController extends Controller
{
    public function behaviors()
    {
        return [
/*	    'access' => [
		'class' => AccessControl::className(),
		'rules' => [
		    [
			'allow' => true,
			'actions' => ['index', 'view'], 
			'roles' => ['?', '@'],
		    ],
		    [
			'allow' => true,
			'actions' => ['view', 'create', 'update', 'delete', 'deletes'], 
			'roles' => ['@'],
		    ],
		],
	    ],*/
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['post'],
                ],
            ],
        ];
    }

    public function beforeAction($action) {
	if (parent::beforeAction($action)) {
	    if (in_array($action->id, array('index','view','create', 'update','delete','deletes','qrcode'))) {
		$admin = isset(Yii::$app->session['admin'])?Yii::$app->session['admin']:'';
                $person = isset(Yii::$app->session['person'])?Yii::$app->session['person']:'';
                if($admin == '' && $person == ''){
                    return $this->redirect(['/site/index']);
                }
	    }
	    return true;
	} else {
	    return false;
	}
    }
    
    /**
     * Lists all Personnels models.
     * @return mixed
     */
    public function actionIndex()
    {
		$userType = \Yii::$app->request->get('userType');
        $searchModel = new PersonnelsSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
			'dataProvider' => $dataProvider,
			'userType'=>$userType
        ]);
    }

    /**
     * Displays a single Personnels model.
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
     * Creates a new Personnels model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
	if (Yii::$app->getRequest()->isAjax) {
	    $model = new Personnels();
            $model->scenario = 'create';
	    if ($model->load(Yii::$app->request->post())) {
			// $model->userType = 1;       
                
		if ($model->save()) {
		    return \cpn\chanpan\classes\CNMessage::getSuccess('สร้างสำเร็จ');
		} else {
		    return \cpn\chanpan\classes\CNMessage::getError('สร้างไม่สำเร็จ');
		}
	    } else {
			$userType = \Yii::$app->request->get('userType');
			$model->userType = $userType;
			//$this->title = ($userType == 1)?'จัดการเจ้าหน้าที่':'จัดการสมาชิก';
		return $this->renderAjax('create', [
			'model' => $model,
			'userType'=>$userType 
		]);
	    }
	} else {
	    throw new NotFoundHttpException('Invalid request. Please do not repeat this request again.');
	}
    }

    /**
     * Updates an existing Personnels model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
	if (Yii::$app->getRequest()->isAjax) {
	    $model = $this->findModel($id);

	    if ($model->load(Yii::$app->request->post())) {
			
		if ($model->save()) {
		    return \cpn\chanpan\classes\CNMessage::getSuccess('แก้ไขสำเร็จ');
		} else {
		    return \cpn\chanpan\classes\CNMessage::getError('แก้ไขไม่สำเร็จ');
		}
	    } else {
			$userType = \Yii::$app->request->get('userType');
			//$this->title = ($userType == 1)?'จัดการเจ้าหน้าที่':'จัดการสมาชิก';
		return $this->renderAjax('update', [
			'model' => $model,
			'userType'=>$userType
		]);
		 
	    }
	} else {
	    throw new NotFoundHttpException('Invalid request. Please do not repeat this request again.');
	}
    }

    /**
     * Deletes an existing Personnels model.
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

    public function actionDeletes() {
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
    
    /**
     * Finds the Personnels model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Personnels the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Personnels::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
