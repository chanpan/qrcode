<?php
namespace common\modules\user\controllers;
use dektrium\user\controllers\SettingsController as BaseSettingsController;
use common\modules\user\models\Profile;
use common\modules\user\models\User;
use common\modules\admin\models\SettingsForm;
    
class SettingsController extends BaseSettingsController{
    //put your code here
    public function actionProfile() {
        
       
        $model = $this->finder->findProfileById(\Yii::$app->user->identity->getId());

        if ($model == null) {
            $model = \Yii::createObject(Profile::className());
            $model->link('user', \Yii::$app->user->identity);
        }

        $event = $this->getProfileEvent($model);

        $this->performAjaxValidation($model);

        $this->trigger(self::EVENT_BEFORE_PROFILE_UPDATE, $event);
        if ($model->load(\Yii::$app->request->post())) {
            
            $model->avatar_path = isset($_POST['Profile']['path']) ? $_POST['Profile']['path'] : '';
            $model->avatar_base_url = isset($_POST['Profile']['base_url']) ? $_POST['Profile']['base_url'] : '';
                    
            if($model->save()){
                \Yii::$app->getSession()->setFlash('success', \Yii::t('user', 'Your profile has been updated'));
                $this->trigger(self::EVENT_AFTER_PROFILE_UPDATE, $event);
                return $this->refresh();
            }else{
                \yii\helpers\VarDumper::dump($model->errors, 10, true);exit();
            }
            
        }

        return $this->render('profile', [
                    'model' => $model,
        ]);
    }
    
    //accoute
    public function actionAccount() {
        /** @var SettingsForm $model */
        $model = \Yii::createObject(SettingsForm::className());
//        \appxq\sdii\utils\VarDumper::dump($model);
        $event = $this->getFormEvent($model);

        $this->performAjaxValidation($model);

        $this->trigger(self::EVENT_BEFORE_ACCOUNT_UPDATE, $event);
        if ($model->load(\Yii::$app->request->post()) && $model->save()) {
            \Yii::$app->session->setFlash('success', \Yii::t('user', 'Your account details have been updated'));
            $this->trigger(self::EVENT_AFTER_ACCOUNT_UPDATE, $event);
            return $this->refresh();
        }

        return $this->render('account', [
                    'model' => $model,
        ]);
    }

}
