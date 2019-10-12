<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model frontend\models\ReportProblem */

$this->title = 'Report Problem#'.$model->title;
$this->params['breadcrumbs'][] = ['label' => 'Report Problems', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="report-problem-view">

    <div class="modal-header">
	<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
	<h4 class="modal-title" id="itemModalLabel"><?= Html::encode($this->title) ?></h4>
    </div>
    <div class="modal-body">
        <?= DetailView::widget([
	    'model' => $model,
	    'attributes' => [
		'id',
		'title',
		'detail:ntext',
		'user_name',
		'tel',
	    ],
	]) ?>
    </div>
</div>
