<?php

use yii\helpers\Url;

$this->title = 'ระบบการจัดการรถด้วยการสแกน qr code';
Yii::$app->meta->keywords = 'ระบบการจัดการรถด้วยการสแกน qr code';
Yii::$app->meta->description = 'ระบบการจัดการรถด้วยการสแกน qr code';
//Yii::$app->meta->image = Yii::getAlias('@web').'/images/myimage.jpg';

$admin = isset(Yii::$app->session['admin'])?Yii::$app->session['admin']:'';
?>
<div>
    <h3>สวัสดิ์ดี: <?php echo $admin != '' ? $admin['P_name'] : 'No name'?> <a href="<?= Url::to(['/site/admin-loout'])?>"><i class="fa fa-sign-out" aria-hidden="true"></i> ออกจากระบบ</a></h3>
</div>
<br>
<div class="row">
    <div class="col-md-2 text-center">
        <a href="<?= Url::to(['/admins/index']) ?>"  >
            <img src="<?= Url::to('@web/images/admin.png') ?>" style="height:100px;">
            <h4>จัดการAdmin</h4>
        </a>
    </div>
    <div class="col-md-2 text-center">
        <a href="<?= Url::to(['/personnels/index']) ?>"  >
            <img src="<?= Url::to('@web/images/staff.png') ?>" style="height:100px;">
            <h4>จัดการเจ้าหน้าที่</h4>
        </a>
    </div>
    <div class="col-md-2 text-center">
        <a href="<?= Url::to(['/users/index']) ?>"  >
            <img src="<?= Url::to('@web/images/user.png') ?>" style="height:100px;">
            <h4>จัดการผู้ใช้</h4>
        </a>
    </div>
    <div class="col-md-2 text-center">
        <a href="<?= Url::to(['/cars/index']) ?>"  >
            <img src="<?= Url::to('@web/images/cars.jpg') ?>" style="height:100px;">
            <h4>จัดการรถ</h4>
        </a>
    </div>
    <div class="col-md-2 text-center">
        <a href="<?= Url::to(['/report-problem/index']) ?>"  >
            <img src="<?= Url::to('@web/images/report.png') ?>" style="height:100px;">
            <h4>จัดการการแจ้งปัญหา</h4>
            <a href="<?= Url::to(['/users/index']) ?>"  >
                </div> 
                </div>