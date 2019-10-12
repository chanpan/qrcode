<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model frontend\models\ReportProblem */

$this->title = 'Update Report Problem: ' . ' ' . $model->title;
$this->params['breadcrumbs'][] = ['label' => 'Report Problems', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->title, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="report-problem-update">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
