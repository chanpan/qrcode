<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model frontend\models\Cars */ 
?>
<div class="cars-view">

    <div class="modal-header">
	<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
	<h4 class="modal-title" id="itemModalLabel"><?= Html::encode($this->title) ?></h4>
    </div>
    <div class="modal-body" style='width:300px;'>
        <?= DetailView::widget([
	    'model' => $model,
	    'attributes' => [ 
		'T_name',
		'T_home',
		'T_district',
		'T_state',
		'T_province',
		'T_numberphone',
		'T_motorname',
		'T_motormunber',
	    ],
	]) ?>
    </div>
</div>
<style>
.navbar{
	display:none;
} 
</style>