<?php
namespace frontend\controllers;

use appxq\sdii\utils\VarDumper;
use frontend\models\Cars;
use Yii;
use yii\base\InvalidParamException;
use yii\web\BadRequestHttpException;
use yii\web\Controller;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use common\models\LoginForm;
use frontend\models\PasswordResetRequestForm;
use frontend\models\ResetPasswordForm;
use frontend\models\SignupForm;
use frontend\models\ContactForm;
use kartik\mpdf\Pdf;

/**
 * Site controller
 */
class SiteController extends Controller
{

    public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
            'captcha' => [
                'class' => 'yii\captcha\CaptchaAction',
                'fixedVerifyCode' => YII_ENV_TEST ? 'testme' : null,
            ],
        ];
    }

    /**
     * Displays homepage.
     *
     * @return mixed
     */
    public function actionIndex()
    {
        return $this->render('index');
    }

    /**
     * Logs in a user.
     *
     * @return mixed
     */
    public function actionAdminLoout(){
        
        if(isset(Yii::$app->session['admin'])){
            unset(Yii::$app->session['admin']);
        }
        if(isset(Yii::$app->session['person'])){
            unset(Yii::$app->session['person']);
        }
        return $this->redirect(['site/index']);
    }
    public function actionAdminLogin()
    {
        if(isset(Yii::$app->session['admin'])){
            return $this->redirect(['/site/index']);
        }
        $post = Yii::$app->request->post();
        if($post){
           $username = $post['username'];
           $password = $post['password'];
           
           $admin = \frontend\models\Admins::find()
                   ->where('P_username=:username AND P_pass=:password',[
                       ':username'=>$username,
                       ':password'=>$password
                   ])->one();
           if($admin){
               if($password === $admin->P_pass){
                   unset($admin['P_pass']);
                   \Yii::$app->session['admin'] = $admin;
                   return \cpn\chanpan\classes\CNMessage::getSuccess("Login Success");
               }
           }
           return \cpn\chanpan\classes\CNMessage::getError("กรุณาตรวจสอบ Username หรือ Password");
        }
         return $this->render('admin-login');
    }
    
    
    public function actionPersonLoout(){
        
        if(isset(Yii::$app->session['person'])){
            unset(Yii::$app->session['person']);
        }
        return $this->redirect(['site/index']);
    }
    public function actionPersonLogin()
    {
        if(isset(Yii::$app->session['person'])){
            return $this->redirect(['/site/index']);
        }
        $post = Yii::$app->request->post();
        if($post){
           $username = $post['username'];
           $password = $post['password'];
           
           $person = \frontend\models\Personnels::find()
                   ->where('v_username=:username AND v_pass=:password',[
                       ':username'=>$username,
                       ':password'=>$password
                   ])->one();
   //\appxq\sdii\utils\VarDumper::dump($person);
           if($person){
               if($password === $person->v_pass){
                   unset($person['v_pass']);
                   \Yii::$app->session['person'] = $person;
                   return \cpn\chanpan\classes\CNMessage::getSuccess("Login Success");
               }
           }
           return \cpn\chanpan\classes\CNMessage::getError("กรุณาตรวจสอบ Username หรือ Password");
        }
         return $this->render('person-login');
    }

    /**
     * Logs out the current user.
     *
     * @return mixed
     */
    public function actionLogout()
    {
        Yii::$app->user->logout();

        return $this->goHome();
    }

    /**
     * Displays contact page.
     *
     * @return mixed
     */
    public function actionContact()
    {
        $model = new ContactForm();
        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            if ($model->sendEmail(Yii::$app->params['adminEmail'])) {
                Yii::$app->session->setFlash('success', 'Thank you for contacting us. We will respond to you as soon as possible.');
            } else {
                Yii::$app->session->setFlash('error', 'There was an error sending your message.');
            }

            return $this->refresh();
        } else {
            return $this->render('contact', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Displays about page.
     *
     * @return mixed
     */
    public function actionAbout()
    {
        return $this->render('about');
    }

    /**
     * Signs user up.
     *
     * @return mixed
     */
    public function actionSignup()
    {
        $model = new SignupForm();
        if ($model->load(Yii::$app->request->post())) {
            if ($user = $model->signup()) {
                if (Yii::$app->getUser()->login($user)) {
                    return $this->goHome();
                }
            }
        }

        return $this->render('signup', [
            'model' => $model,
        ]);
    }

    /**
     * Requests password reset.
     *
     * @return mixed
     */
    public function actionRequestPasswordReset()
    {
        $model = new PasswordResetRequestForm();
        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            if ($model->sendEmail()) {
                Yii::$app->session->setFlash('success', 'Check your email for further instructions.');

                return $this->goHome();
            } else {
                Yii::$app->session->setFlash('error', 'Sorry, we are unable to reset password for the provided email address.');
            }
        }

        return $this->render('requestPasswordResetToken', [
            'model' => $model,
        ]);
    }

    /**
     * Resets password.
     *
     * @param string $token
     * @return mixed
     * @throws BadRequestHttpException
     */
    public function actionResetPassword($token)
    {
        try {
            $model = new ResetPasswordForm($token);
        } catch (InvalidParamException $e) {
            throw new BadRequestHttpException($e->getMessage());
        }

        if ($model->load(Yii::$app->request->post()) && $model->validate() && $model->resetPassword()) {
            Yii::$app->session->setFlash('success', 'New password saved.');

            return $this->goHome();
        }

        return $this->render('resetPassword', [
            'model' => $model,
        ]);
    }
    
    public function actionQrcode(){
         $id = Yii::$app->request->get('id');
        $car = Cars::findOne($id);
        //VarDumper::dump($car)
         $content = $this->renderPartial('_sticker', [
            'id' => $id,
             'car'=>$car
        ]);

        $pdf = new Pdf([ 
            // set to use core fonts only
            'mode' => Pdf::MODE_UTF8,
            // A4 paper format
            //'format' => Pdf::FORMAT_A4,
            'format' => [60, 60],//Pdf::FORMAT_A4,
            'marginLeft' => 1,
            'marginRight' => 1,
            'marginTop' => 1,
            'marginBottom' => false,
            'marginHeader' => false,
            'marginFooter' => false,
            // portrait orientation
            'orientation' => Pdf::ORIENT_PORTRAIT,
            // stream to browser inline
            'destination' => Pdf::DEST_BROWSER,
            // your html content input
            'content' => $content,
            // format content from your own css file if needed or use the
            // enhanced bootstrap css built by Krajee for mPDF formatting
            'cssFile' => '@frontend/web/css/kv-mpdf-bootstrap.css',
            // any css to be embedded if required
            'cssInline' => 'body{font-size:11px}',
            // set mPDF properties on the fly
            'options' => ['title' => 'Car'],
            // call mPDF methods on the fly
            'methods' => [
                'SetHeader'=>false,
                'SetFooter'=>false,
            ]
        ]);

        // return the pdf output as per the destination setting
        return $pdf->render();
    }
     
}
