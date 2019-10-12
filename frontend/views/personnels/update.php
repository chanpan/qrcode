<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model frontend\models\Personnels */

$this->title = 'Update Personnels: ' . ' ' . $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Personnels', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="personnels-update">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
