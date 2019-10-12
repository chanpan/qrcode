<?php

use yii\helpers\Url;

$this->title = 'ระบบการจัดการรถด้วยการสแกน qr code';
Yii::$app->meta->keywords = 'ระบบการจัดการรถด้วยการสแกน qr code';
Yii::$app->meta->description = 'ระบบการจัดการรถด้วยการสแกน qr code';
//Yii::$app->meta->image = Yii::getAlias('@web').'/images/myimage.jpg';

$admin = isset(Yii::$app->session['admin']) ? Yii::$app->session['admin'] : '';

?>
<?php if (!\Yii::$app->session['person'] && !\Yii::$app->session['admin']): ?>

<?php else: ?>
    <div class="row">
        <div class="col-md-12">

            <div class="col-md-12" style='background:#41f3ac;padding-top:20px;'>
                <div>
                    <h3>สวัสดิ์ดี: <?php echo $admin != '' ? $admin['P_name'] : 'No name' ?> <a
                                href="<?= Url::to(['/site/admin-loout']) ?>"><i class="fa fa-sign-out"
                                                                                aria-hidden="true"></i> ออกจากระบบ</a>
                    </h3>
                </div>
                <?php if (\Yii::$app->session['admin']): ?>
                    <div class="col-md-6 text-center">
                        <a href="<?= Url::to(['/admins/index']) ?>">
                            <img src="<?= Url::to('@web/images/admin.jpg') ?>" style="height:100px;">
                            <h4 class="txt">จัดการAdmin</h4>
                        </a>
                    </div>
                <?php endif; ?>
                <div class="col-md-6 text-center">
                    <a href="<?= Url::to(['/personnels/index']) ?>">
                        <img src="<?= Url::to('@web/images/staff.jpg') ?>" style="height:100px;">
                        <h4 class="txt">จัดการเจ้าหน้าที่</h4>
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
                        <h4 class="txt">จัดการการแจ้งปัญหา</h4>
                        <a href="<?= Url::to(['/users/index']) ?>">
                </div>
            </div>
        </div>
    </div>
<?php endif; ?>

