<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model frontend\models\ReportProblem */

$this->title = 'Create Report Problem';
$this->params['breadcrumbs'][] = ['label' => 'Report Problems', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="report-problem-create">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
