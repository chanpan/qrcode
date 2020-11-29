<?php

use yii\helpers\Url;

$this->title = 'ระบบการจัดการรถด้วยการสแกน qr code';
Yii::$app->meta->keywords = 'ระบบการจัดการรถด้วยการสแกน qr code';
Yii::$app->meta->description = 'ระบบการจัดการรถด้วยการสแกน qr code';
//Yii::$app->meta->image = Yii::getAlias('@web').'/images/myimage.jpg';

//var_dump(\Yii::$app->session['person']);exit();
 

$admin = isset(Yii::$app->session['admin']) ? Yii::$app->session['admin'] : '';

$person = isset(Yii::$app->session['person']) ? Yii::$app->session['person'] : '';

?>
<?php if (!\Yii::$app->session['person'] && !\Yii::$app->session['admin']): ?>

<?php else: ?>
<div class="row">
    <div class="col-md-12">

        <div class="col-md-12" style='background:#41f3ac;padding-top:20px;'>
            <div class='pull-right'>
                 <?= $this->render('@frontend/views/site/profile')?>
            </div>
            <div class='clearfix'></div><br>
            <?php if (\Yii::$app->session['admin']): ?>
            <div class="col-md-6 text-center">
                <a href="<?= Url::to(['/admins/index']) ?>">
                    <img src="<?= Url::to('@web/images/admin.jpg') ?>" style="height:100px;">
                    <h4 class="txt">จัดการข้อมูลผู้ดูแลระบบ</h4>
                </a>
            </div>
            <div class="col-md-6 text-center">
                <a href="<?= Url::to(['/personnels/index?userType=2']) ?>">
                    <img src="<?= Url::to('@web/images/members.jpg') ?>" style="height:100px;">
                    <h4 class="txt">จัดการสมาชิก</h4>
                </a>
            </div>
            <?php endif; ?>
            <?php if(isset(\Yii::$app->session['person']['userType']) && \Yii::$app->session['person']['userType'] == 1): ?>
            <div class="col-md-6 text-center">
                <a href="<?= Url::to(['/personnels/index?userType=1']) ?>">
                    <img src="<?= Url::to('@web/images/staff.jpg') ?>" style="height:100px;">
                    <h4 class="txt">จัดการเจ้าหน้าที่</h4>
                </a>
            </div>
            <div class="col-md-6 text-center">
                <a href="<?= Url::to(['/personnels/index?userType=3']) ?>">
                    <img src="<?= Url::to('@web/images/staff.jpg') ?>" style="height:100px;">
                    <h4 class="txt">จัดการเจ้าหน้าที่ รปภ.</h4>
                </a>
            </div>
            <div class="col-md-6 text-center">
                <a href="<?= Url::to(['/personnels/index?userType=2']) ?>">
                    <img src="<?= Url::to('@web/images/members.jpg') ?>" style="height:100px;">
                    <h4 class="txt">จัดการสมาชิก</h4>
                </a>
            </div>
            <div class="col-md-6 text-center">
                <a href="<?= Url::to(['/cars/index']) ?>">
                    <img src="<?= Url::to('@web/images/cars.jpg') ?>" style="height:100px;">
                    <h4 class="txt">จัดการรถ</h4>
                </a>
            </div>
            <div class="col-md-6 text-center">
                <a href="<?= Url::to(['/report-problem/index']) ?>">
                    <img src="<?= Url::to('@web/images/report.png') ?>" style="height:100px;">
                    <h4 class="txt">จัดการปัญหา</h4>
                    <a href="<?= Url::to(['/users/index']) ?>">
            </div>
        </div>
        <?php else:?>
        <?php if(!\Yii::$app->session['admin'] && \Yii::$app->session['person']['userType'] != 3):?>
        <div class="col-md-6 text-center">
            <a href="<?= Url::to(['/site/register']) ?>">
                <img src="<?= Url::to('@web/images/register.png') ?>" style="height:100px;">
                <h4 class="txt">ลงทะเบียนข้อมูลรถ</h4>
        </div>
        <div class="col-md-6 text-center">
            <a href="<?= Url::to(['/report-problem/problem']) ?>">
                <img src="<?= Url::to('@web/images/report.png') ?>" style="height:100px;">
                <h4 class="txt">แจ้งปัญหา</h4>

        </div>
        <?php elseif(\Yii::$app->session['person']['userType'] == 3):?>
            <?= $this->render('rpp',[
                 'dataProvider'=>$dataProvider
            ]);?>
        <?php endif; ?>
        <?php endif; ?>
    </div>
</div>
<?php endif; ?>