<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model frontend\models\Personnels */

$this->title = 'Create Personnels';
$this->params['breadcrumbs'][] = ['label' => 'Personnels', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="personnels-create">

    <?= $this->render('_form', [
        'model' => $model,
        'userType'=>$userType
    ]) ?>

</div>
