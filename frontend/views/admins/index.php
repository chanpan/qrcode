<?php

use yii\helpers\Html;
use yii\widgets\Pjax;
use yii\helpers\Url;
use appxq\sdii\widgets\GridView;
use appxq\sdii\widgets\ModalForm;
use appxq\sdii\helpers\SDNoty;
use appxq\sdii\helpers\SDHtml;

/* @var $this yii\web\View */
/* @var $searchModel frontend\models\search\Admins */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'ผู้ดูแลระบบ';
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
             <?= Html::button(SDHtml::getBtnAdd().' เพิ่มข้อมูล', ['data-url'=>Url::to(['admins/create']), 'class' => 'btn btn-success btn-sm', 'id'=>'modal-addbtn-admins'])
             ?>
         </div>
    </div><br>
<div class="box-body">    
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <?php  Pjax::begin(['id'=>'admins-grid-pjax']);?>
    <?= GridView::widget([
	'id' => 'admins-grid',
	'dataProvider' => $dataProvider,
	'filterModel' => $searchModel,
        'columns' => [
	   
	    [
		'class' => 'yii\grid\SerialColumn',
		'headerOptions' => ['style'=>'text-align: center;'],
		'contentOptions' => ['style'=>'width:60px;text-align: center;'],
	    ],
 
            'P_username',
            'P_pass',
            'P_name',

	    [
		'class' => 'appxq\sdii\widgets\ActionColumn',
		'contentOptions' => ['style'=>'width:80px;text-align: center;'],
		'template' => '{update} {delete}',
                'buttons'=>[
                    'update'=>function($url, $model){
                        return Html::a('<span class="fa fa-edit"></span> '.Yii::t('app', 'แก้ไข'), 
                                    yii\helpers\Url::to(['admins/update?id='.$model->id]), [
                                    'title' => Yii::t('app', 'Edit'),
                                    'class' => 'btn btn-primary btn-xs',
                                    'data-action'=>'update',
                                    'data-pjax'=>0
                        ]);
                    },
                    'delete' => function ($url, $model) {                         
                        return Html::a('<span class="fa fa-trash"></span> '.Yii::t('app', 'Delete'), 
                                yii\helpers\Url::to(['admins/delete?id='.$model->id]), [
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
    'id' => 'modal-admins',
    //'size'=>'modal-lg',
]);
?>

<?php  \richardfan\widget\JSRegister::begin([
    //'key' => 'bootstrap-modal',
    'position' => \yii\web\View::POS_READY
]); ?>
<script>
// JS script
$('#modal-addbtn-admins').on('click', function() {
    modalAdmin($(this).attr('data-url'));
});

$('#modal-delbtn-admins').on('click', function() {
    selectionAdminGrid($(this).attr('data-url'));
});

$('#admins-grid-pjax').on('click', '.select-on-check-all', function() {
    window.setTimeout(function() {
	var key = $('#admins-grid').yiiGridView('getSelectedRows');
	disabledAdminBtn(key.length);
    },100);
});

$('.selectionCoreOptionIds').on('click',function() {
    var key = $('input:checked[class=\"'+$(this).attr('class')+'\"]');
    disabledAdminBtn(key.length);
});

$('#admins-grid-pjax').on('dblclick', 'tbody tr', function() {
    var id = $(this).attr('data-key');
    modalAdmin('<?= Url::to(['admins/update', 'id'=>''])?>'+id);
});	

$('#admins-grid-pjax').on('click', 'tbody tr td a', function() {
    var url = $(this).attr('href');
    var action = $(this).attr('data-action');

    if(action === 'update' || action === 'view') {
	modalAdmin(url);
    } else if(action === 'delete') {
	yii.confirm('<?= Yii::t('chanpan', 'คุณแน่ใจหรือว่าต้องการลบรายการนี้หรือไม่?')?>', function() {
	    $.post(
		url
	    ).done(function(result) {
		if(result.status == 'success') {
		    <?= SDNoty::show('result.message', 'result.status')?>
		    $.pjax.reload({container:'#admins-grid-pjax'});
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

function disabledAdminBtn(num) {
    if(num>0) {
	$('#modal-delbtn-admins').attr('disabled', false);
    } else {
	$('#modal-delbtn-admins').attr('disabled', true);
    }
}

function selectionAdminGrid(url) {
    yii.confirm('<?= Yii::t('chanpan', 'Are you sure you want to delete these items?')?>', function() {
	$.ajax({
	    method: 'POST',
	    url: url,
	    data: $('.selectionAdminIds:checked[name=\"selection[]\"]').serialize(),
	    dataType: 'JSON',
	    success: function(result, textStatus) {
		if(result.status == 'success') {
		    <?= SDNoty::show('result.message', 'result.status')?>
		    $.pjax.reload({container:'#admins-grid-pjax'});
		} else {
		    <?= SDNoty::show('result.message', 'result.status')?>
		}
	    }
	});
    });
}

function modalAdmin(url) {
    $('#modal-admins .modal-content').html('<div class=\"sdloader \"><i class=\"sdloader-icon\"></i></div>');
    $('#modal-admins').modal('show')
    .find('.modal-content')
    .load(url);
}
</script>
<?php  \richardfan\widget\JSRegister::end(); ?>