<?php

/* @var $this \yii\web\View */

/* @var $content string */

use yii\helpers\Html;
use yii\bootstrap\Nav;
use yii\bootstrap\NavBar;
use yii\widgets\Breadcrumbs;
use frontend\assets\AppAsset;
use common\widgets\Alert;

\cpn\chanpan\assets\bootbox\BootBoxAsset::register($this);
\cpn\chanpan\assets\notify\NotifyAsset::register($this);
\frontend\assets\VuejsAsset::register($this);

AppAsset::register($this);
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
<head>
    <?php Yii::$app->meta->displaySeo() ?>
    <meta charset="<?= Yii::$app->charset ?>">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title><?= $this->title; ?></title>
    <?= Html::csrfMetaTags() ?>
    <title><?= Html::encode($this->title) ?></title>
    <?php $this->head() ?>
</head>
<body>
<?php $this->beginBody() ?>

<div class="wrap" id="container">

    <header id="header">
        <img src="<?= yii\helpers\Url::to('@web/images/header1.jpg') ?>">
    </header>
    <div>
        <?php if (isset(\Yii::$app->session['admin'])): ?>
            <?php //echo $this->render('admin.php');?>
        <?php elseif (isset(\Yii::$app->session['person'])): ?>
            <?php //echo $this->render('person.php');?>
        <?php endif; ?>
        <?= Breadcrumbs::widget([
            'links' => isset($this->params['breadcrumbs']) ? $this->params['breadcrumbs'] : [],
        ]) ?>
        <?php if (!\Yii::$app->session['person'] && !\Yii::$app->session['admin']): ?>
            <nav class="navbar navbar-default">
                <div class="container-fluid">
                    <div class="navbar-header">
                    </div>
                    <ul class="nav navbar-nav">
                        <li><a href="<?= \yii\helpers\Url::to(['/site/admin-login']) ?>">เข้าสูระบบ ADMIN</a></li>
                        <li><a href="<?= \yii\helpers\Url::to(['/site/person-login']) ?>">เข้าสูระบบ เจ้าหน้าที่/สมาชิก</a></li>
                        <li><a href="<?= \yii\helpers\Url::to(['/site/register2']) ?>">สมัครสมาชิก</a></li>
                        <!-- <li><a href="<?= \yii\helpers\Url::to(['/report-problem/problem']) ?>">แจ้งปัญหา</a></li> -->
                        <li><a href="<?= \yii\helpers\Url::to(['/site/contact']) ?>">ติดต่อเรา </a></li>
                    </ul>
                </div>
            </nav>
        <?php endif; ?>
        <?= Alert::widget() ?>
        <?= $content ?>
    </div>
</div>

<footer class="footer">
    <div class="container">
        <p class="pull-left">&copy; ระบบการจัดการรถด้วยการสแกน qr code</p>
    </div>
</footer>
<style>
    html, body {
    height: 100%;
    overflow-x: hidden;
}
</style>
<?php $this->registerCss("
div.required label.control-label:after {
    content: \" *\";
    color: red;
}
#container{
    width:800px;
    margin:0 auto;
}
#header img{ 
    width:100%;
}
.txt{
    color: #1d6d4d;
    font-weight: bold;
}
ิbody{
    overflow-x:hidden;
}
") ?>
<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>
