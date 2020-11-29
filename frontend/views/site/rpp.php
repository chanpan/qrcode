 
<?php

use yii\helpers\Html;
use yii\widgets\Pjax;
use yii\helpers\Url;
use appxq\sdii\widgets\GridView;
use appxq\sdii\widgets\ModalForm;
use appxq\sdii\helpers\SDNoty;
use appxq\sdii\helpers\SDHtml;

/* @var $this yii\web\View */
/* @var $searchModel frontend\models\search\ReportProblem */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'รายละเอียดการรายงานปัญหา';
$this->params['breadcrumbs'][] = $this->title;

?>
<div style='background:#fff;padding:10px'>
<h3><?= $this->title;?></h3>
<?= GridView::widget([
    
	'id' => 'report-problem-grid',
    'dataProvider' => $dataProvider,
        'columns' => [ 
	    [
		'class' => 'yii\grid\SerialColumn',
		'headerOptions' => ['style'=>'text-align: center;'],
		'contentOptions' => ['style'=>'width:60px;text-align: center;'],
	    ], 
            'title',
            'detail:ntext',
            
            [
                'attribute' => 'date',
                'value' => function($model){
	                if(isset($model->date)){
	                    return \appxq\sdii\utils\SDdate::mysql2phpDateTime($model->date);
                    }
                }
            ],
            [
                'attribute' => 'rstatus',
                'value' => function($model){
                    $items = ['0'=>'ยังไม่จัดการปัญหา','1'=>'จัดการปัญหาแล้ว'];
                    if($model->rstatus){
                        return $items[$model->rstatus];
                    }else{
                        return $items[0];
                    }
                }
        ],


	    [
		'class' => 'appxq\sdii\widgets\ActionColumn',
		'contentOptions' => ['style'=>'width:80px;text-align: center;'],
		'template' => '{manage-problem}',
                'buttons'=>[
                    'manage-problem'=>function($url, $model){
                        return Html::a('<span class="fa fa-edit"></span> '.Yii::t('app', 'จัดการ'), 
                                    yii\helpers\Url::to(['/site/manage-problem?id='.$model->id]), [
                                    'title' => Yii::t('app', 'จัดการ'),
                                    'class' => 'btn btn-primary btn-xs',
                                    'data-action'=>'manage-problem', 
                        ]);
                    },
                    
                ],
            ],
        ],
    ]); ?>
</div>
