<?php

use yii\helpers\Html;
use yii\widgets\Pjax;
use yii\helpers\Url;
use appxq\sdii\widgets\GridView;
use appxq\sdii\widgets\ModalForm;
use appxq\sdii\helpers\SDNoty;
use appxq\sdii\helpers\SDHtml;

/* @var $this yii\web\View */
/* @var $searchModel frontend\models\search\Personnels */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = ($userType == 1)?'จัดการเจ้าหน้าที่':'จัดการสมาชิก';
if($userType == 3){
    $this->title = 'จัดการเจ้าหน้าที่ รปภ.';
}
$this->params['breadcrumbs'][] = $this->title;

?>
<div class="row">
<div class='pull-right'>
                 <?= $this->render('@frontend/views/site/profile')?>
            </div>
</div>
<div class="box box-primary">
    <div class="box-header">
         <h3><?=  Html::encode($this->title) ?> </h3>
         <div class="pull-right">
             <?= Html::button(SDHtml::getBtnAdd().' เพิ่มข้อมูล', ['data-url'=>Url::to(['personnels/create?userType='.$userType]), 'class' => 'btn btn-success btn-sm', 'id'=>'modal-addbtn-personnels'])
             ?>
         </div>
    </div><br>
<div class="box-body">    
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <?php  Pjax::begin(['id'=>'personnels-grid-pjax']);?>
    <?= GridView::widget([
	'id' => 'personnels-grid',
/*	'panelBtn' => Html::button(SDHtml::getBtnAdd(), ['data-url'=>Url::to(['personnels/create']), 'class' => 'btn btn-success btn-sm', 'id'=>'modal-addbtn-personnels']). ' ' .
		      Html::button(SDHtml::getBtnDelete(), ['data-url'=>Url::to(['personnels/deletes']), 'class' => 'btn btn-danger btn-sm', 'id'=>'modal-delbtn-personnels', 'disabled'=>true]),*/
	'dataProvider' => $dataProvider,
	'filterModel' => $searchModel,
        'columns' => [
	    
	    [
		'class' => 'yii\grid\SerialColumn',
		'headerOptions' => ['style'=>'text-align: center;'],
		'contentOptions' => ['style'=>'width:60px;text-align: center;'],
	    ],

           
            'v_username',
            'v_pass',
            'v_name',
            'v_home',
            // 'v_district',
            // 'v_state',
            // 'v_province',
            // 'v_career',

	    [
		'class' => 'appxq\sdii\widgets\ActionColumn',
		'contentOptions' => ['style'=>'width:80px;text-align: center;'],
		'template' => ' {update} {delete}',
                'buttons'=>[
                    'update'=>function($url, $model){
                        return Html::a('<span class="fa fa-edit"></span> '.Yii::t('app', 'แก้ไข'), 
                                    yii\helpers\Url::to(['personnels/update?id='.$model->id.'&userType='.Yii::$app->request->get('userType')]), [
                                    'title' => Yii::t('app', 'Edit'),
                                    'class' => 'btn btn-primary btn-xs',
                                    'data-action'=>'update',
                                    'data-pjax'=>0
                        ]);
                    },
                    'delete' => function ($url, $model) {                         
                        return Html::a('<span class="fa fa-trash"></span> '.Yii::t('app', 'Delete'), 
                                yii\helpers\Url::to(['personnels/delete?id='.$model->id]), [
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
    'id' => 'modal-personnels',
    //'size'=>'modal-lg',
]);
?>

<?php  \richardfan\widget\JSRegister::begin([
    //'key' => 'bootstrap-modal',
    'position' => \yii\web\View::POS_READY
]); ?>
<script>
// JS script
$('#modal-addbtn-personnels').on('click', function() {
    modalPersonnel($(this).attr('data-url'));
});

$('#modal-delbtn-personnels').on('click', function() {
    selectionPersonnelGrid($(this).attr('data-url'));
});

$('#personnels-grid-pjax').on('click', '.select-on-check-all', function() {
    window.setTimeout(function() {
	var key = $('#personnels-grid').yiiGridView('getSelectedRows');
	disabledPersonnelBtn(key.length);
    },100);
});

$('.selectionCoreOptionIds').on('click',function() {
    var key = $('input:checked[class=\"'+$(this).attr('class')+'\"]');
    disabledPersonnelBtn(key.length);
});

$('#personnels-grid-pjax').on('dblclick', 'tbody tr', function() {
    var id = $(this).attr('data-key');
    modalPersonnel('<?= Url::to(['personnels/update', 'id'=>''])?>'+id);
});	

$('#personnels-grid-pjax').on('click', 'tbody tr td a', function() {
    var url = $(this).attr('href');
    var action = $(this).attr('data-action');

    if(action === 'update' || action === 'view') {
	modalPersonnel(url);
    } else if(action === 'delete') {
	yii.confirm('<?= Yii::t('chanpan', 'คุณแน่ใจหรือว่าต้องการลบรายการนี้หรือไม่?')?>', function() {
	    $.post(
		url
	    ).done(function(result) {
		if(result.status == 'success') {
		    <?= SDNoty::show('result.message', 'result.status')?>
		    $.pjax.reload({container:'#personnels-grid-pjax'});
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

function disabledPersonnelBtn(num) {
    if(num>0) {
	$('#modal-delbtn-personnels').attr('disabled', false);
    } else {
	$('#modal-delbtn-personnels').attr('disabled', true);
    }
}

function selectionPersonnelGrid(url) {
    yii.confirm('<?= Yii::t('chanpan', 'Are you sure you want to delete these items?')?>', function() {
	$.ajax({
	    method: 'POST',
	    url: url,
	    data: $('.selectionPersonnelIds:checked[name=\"selection[]\"]').serialize(),
	    dataType: 'JSON',
	    success: function(result, textStatus) {
		if(result.status == 'success') {
		    <?= SDNoty::show('result.message', 'result.status')?>
		    $.pjax.reload({container:'#personnels-grid-pjax'});
		} else {
		    <?= SDNoty::show('result.message', 'result.status')?>
		}
	    }
	});
    });
}

function modalPersonnel(url) {
    $('#modal-personnels .modal-content').html('<div class=\"sdloader \"><i class=\"sdloader-icon\"></i></div>');
    $('#modal-personnels').modal('show')
    .find('.modal-content')
    .load(url);
}
</script>
<?php  \richardfan\widget\JSRegister::end(); ?>