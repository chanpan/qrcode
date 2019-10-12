<?php
namespace common\modules\user\controllers;
use dektrium\user\controllers\AdminController as BaseAdminController;
use yii\helpers\Url;
use common\modules\user\models\UserSearch;
use common\modules\user\models\Profile;
use common\modules\user\models\User;
use yii\web\NotFoundHttpException;
use Yii;
use yii\helpers\Html;

class AdminController extends BaseAdminController{
    public function actionIndex()
    {  
       
        Url::remember('', 'actions-redirect');
        $searchModel  = \Yii::createObject(UserSearch::className());
        $dataProvider = $searchModel->search(\Yii::$app->request->get());

        return $this->render('index', [
            'dataProvider' => $dataProvider,
            'searchModel'  => $searchModel,
        ]);
    }
    public function actionUpdateProfile($id)
    {
        
        if (Yii::$app->getRequest()->isAjax) {
            $request = Yii::$app->request;
            Url::remember('', 'actions-redirect');
            $user    = $this->findModel($id);
            $profile = $user->profile; 
            if ($profile == null) {
                $profile = \Yii::createObject(Profile::className());
                $profile->link('user', $user);
            }
            $event = $this->getProfileEvent($profile);
            $this->trigger(self::EVENT_BEFORE_PROFILE_UPDATE, $event);

            if ($profile->load(\Yii::$app->request->post()) && $profile->save()) {
                $this->trigger(self::EVENT_AFTER_PROFILE_UPDATE, $event);
                return \cpn\chanpan\classes\CNMessage::getSuccess('แก้ไขสำเร็จ');
            }

            return $this->renderAjax('_profile', [
                        'user' => $user,
                        'profile' => $profile,
            ]);
        } else {
	    throw new NotFoundHttpException('Invalid request. Please do not repeat this request again.');
	}
    }
    public function actionDelete($id)
    {
        if ($id == \Yii::$app->user->getId()) {
            return \cpn\chanpan\classes\CNMessage::getError('You can not remove your own account');
        } else {
            $model = $this->findModel($id);
            $event = $this->getUserEvent($model);
            $this->trigger(self::EVENT_BEFORE_DELETE, $event);
            $model->delete();
            $this->trigger(self::EVENT_AFTER_DELETE, $event);
             
            return \cpn\chanpan\classes\CNMessage::getSuccess('ลบสำเร็จ');
        }

        return $this->redirect(['index']);
    }
     
    
}
