<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\models\Test */

$this->title = Yii::t('chanpan', 'Update {modelClass}: ', [
    'modelClass' => 'Test',
]) . ' ' . $model->name;
$this->params['breadcrumbs'][] = ['label' => Yii::t('chanpan', 'Tests'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->name, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="test-update">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
