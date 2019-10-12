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

$this->title = 'จัดการการแจ้งปัญหา';
$this->params['breadcrumbs'][] = $this->title;

?>
<div class="box box-primary">
    <div class="box-header">
         <i class="fa fa-table"></i> <?=  Html::encode($this->title) ?> 
         <div class="pull-right">
             <?= Html::button(SDHtml::getBtnAdd(), ['data-url'=>Url::to(['report-problem/create']), 'class' => 'btn btn-success btn-sm', 'id'=>'modal-addbtn-report-problem']). ' ' .
		      Html::button(SDHtml::getBtnDelete(), ['data-url'=>Url::to(['report-problem/deletes']), 'class' => 'btn btn-danger btn-sm', 'id'=>'modal-delbtn-report-problem', 'disabled'=>false]) 
             ?>
         </div>
    </div>
<div class="box-body">    
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <?php  Pjax::begin(['id'=>'report-problem-grid-pjax']);?>
    <?= GridView::widget([
	'id' => 'report-problem-grid',
/*	'panelBtn' => Html::button(SDHtml::getBtnAdd(), ['data-url'=>Url::to(['report-problem/create']), 'class' => 'btn btn-success btn-sm', 'id'=>'modal-addbtn-report-problem']). ' ' .
		      Html::button(SDHtml::getBtnDelete(), ['data-url'=>Url::to(['report-problem/deletes']), 'class' => 'btn btn-danger btn-sm', 'id'=>'modal-delbtn-report-problem', 'disabled'=>true]),*/
	'dataProvider' => $dataProvider,
	'filterModel' => $searchModel,
        'columns' => [
	    [
		'class' => 'yii\grid\CheckboxColumn',
		'checkboxOptions' => [
		    'class' => 'selectionReportProblemIds'
		],
		'headerOptions' => ['style'=>'text-align: center;'],
		'contentOptions' => ['style'=>'width:40px;text-align: center;'],
	    ],
	    [
		'class' => 'yii\grid\SerialColumn',
		'headerOptions' => ['style'=>'text-align: center;'],
		'contentOptions' => ['style'=>'width:60px;text-align: center;'],
	    ], 
            'title',
            'detail:ntext',
            'user_name',
            'tel',
            [
                    'attribute' => 'status',
                    'value' => function($model){
                        $items = ['0'=>'ยังไม่เครีย','1'=>'เครียแล้ว'];
                        if($model->status){
                            return $items[$model->status];
                        }else{
                            return $items[0];
                        }
                    },
                    'filter'=>['0'=>'ยังไม่เครีย','1'=>'เครียแล้ว']
            ],
            [
                'attribute' => 'date',
                'value' => function($model){
	                if(isset($model->date)){
	                    return \appxq\sdii\utils\SDdate::mysql2phpDateTime($model->date);
                    }
                }
            ],

	    [
		'class' => 'appxq\sdii\widgets\ActionColumn',
		'contentOptions' => ['style'=>'width:80px;text-align: center;'],
		'template' => '{update} {delete}',
                'buttons'=>[
                    'update'=>function($url, $model){
                        return Html::a('<span class="fa fa-edit"></span> '.Yii::t('app', 'แก้ไข'), 
                                    yii\helpers\Url::to(['report-problem/update?id='.$model->id]), [
                                    'title' => Yii::t('app', 'Edit'),
                                    'class' => 'btn btn-primary btn-xs',
                                    'data-action'=>'update',
                                    'data-pjax'=>0
                        ]);
                    },
                    'delete' => function ($url, $model) {                         
                        return Html::a('<span class="fa fa-trash"></span> '.Yii::t('app', 'Delete'), 
                                yii\helpers\Url::to(['report-problem/delete?id='.$model->id]), [
                                'title' => Yii::t('app', 'Delete'),
                                'class' => 'btn btn-danger btn-xs',
                                'data-confirm' => Yii::t('chanpan', 'คุณแน่ใจหรือว่าต้องการลบรายการนี้หรือไม่?'),
                                'data-method' => 'post',
                                'data-action' => 'delete',
                                'data-pjax'=>0
                        ]);
                            
                        
                    },
                ]
	    ],
        ],
    ]); ?>
    <?php  Pjax::end();?>

</div>
</div>
<?=  ModalForm::widget([
    'id' => 'modal-report-problem',
    //'size'=>'modal-lg',
]);
?>

<?php  \richardfan\widget\JSRegister::begin([
    //'key' => 'bootstrap-modal',
    'position' => \yii\web\View::POS_READY
]); ?>
<script>
// JS script
$('#modal-addbtn-report-problem').on('click', function() {
    modalReportProblem($(this).attr('data-url'));
});

$('#modal-delbtn-report-problem').on('click', function() {
    selectionReportProblemGrid($(this).attr('data-url'));
});

$('#report-problem-grid-pjax').on('click', '.select-on-check-all', function() {
    window.setTimeout(function() {
	var key = $('#report-problem-grid').yiiGridView('getSelectedRows');
	disabledReportProblemBtn(key.length);
    },100);
});

$('.selectionCoreOptionIds').on('click',function() {
    var key = $('input:checked[class=\"'+$(this).attr('class')+'\"]');
    disabledReportProblemBtn(key.length);
});

$('#report-problem-grid-pjax').on('dblclick', 'tbody tr', function() {
    var id = $(this).attr('data-key');
    modalReportProblem('<?= Url::to(['report-problem/update', 'id'=>''])?>'+id);
});	

$('#report-problem-grid-pjax').on('click', 'tbody tr td a', function() {
    var url = $(this).attr('href');
    var action = $(this).attr('data-action');

    if(action === 'update' || action === 'view') {
	modalReportProblem(url);
    } else if(action === 'delete') {
	yii.confirm('<?= Yii::t('chanpan', 'คุณแน่ใจหรือว่าต้องการลบรายการนี้หรือไม่?')?>', function() {
	    $.post(
		url
	    ).done(function(result) {
		if(result.status == 'success') {
		    <?= SDNoty::show('result.message', 'result.status')?>
		    $.pjax.reload({container:'#report-problem-grid-pjax'});
		} else {
		    <?= SDNoty::show('result.message', 'result.status')?>
		}
	    }).fail(function() {
		<?= SDNoty::show("'" . SDHtml::getMsgError() . "Server Error'", '"error"')?>
		console.log('server error');
	    });
	});
    }
    return false;
});

function disabledReportProblemBtn(num) {
    if(num>0) {
	$('#modal-delbtn-report-problem').attr('disabled', false);
    } else {
	$('#modal-delbtn-report-problem').attr('disabled', true);
    }
}

function selectionReportProblemGrid(url) {
    yii.confirm('<?= Yii::t('chanpan', 'Are you sure you want to delete these items?')?>', function() {
	$.ajax({
	    method: 'POST',
	    url: url,
	    data: $('.selectionReportProblemIds:checked[name=\"selection[]\"]').serialize(),
	    dataType: 'JSON',
	    success: function(result, textStatus) {
		if(result.status == 'success') {
		    <?= SDNoty::show('result.message', 'result.status')?>
		    $.pjax.reload({container:'#report-problem-grid-pjax'});
		} else {
		    <?= SDNoty::show('result.message', 'result.status')?>
		}
	    }
	});
    });
}

function modalReportProblem(url) {
    $('#modal-report-problem .modal-content').html('<div class=\"sdloader \"><i class=\"sdloader-icon\"></i></div>');
    $('#modal-report-problem').modal('show')
    .find('.modal-content')
    .load(url);
}
</script>
<?php  \richardfan\widget\JSRegister::end(); ?>