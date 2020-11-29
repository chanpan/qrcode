<?php

use yii\helpers\Html;
use yii\widgets\Pjax;
use yii\helpers\Url;
use appxq\sdii\widgets\GridView;
use appxq\sdii\widgets\ModalForm;
use appxq\sdii\helpers\SDNoty;
use appxq\sdii\helpers\SDHtml;

/* @var $this yii\web\View */
/* @var $searchModel frontend\models\search\Cars */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'จัดการรถ';
$this->params['breadcrumbs'][] = $this->title;

?>
<div class="row">
<div class='pull-right'>
                 <?= $this->render('@frontend/views/site/profile')?>
            </div>
</div>
<div class="box box-primary">
    <div class="box-header">
         <i class="fa fa-table"></i> <?=  Html::encode($this->title) ?> 
         <div class="pull-right">
             <?= Html::button(SDHtml::getBtnAdd(), ['data-url'=>Url::to(['cars/create']), 'class' => 'btn btn-success btn-sm', 'id'=>'modal-addbtn-cars']). ' ' .
		      Html::button(SDHtml::getBtnDelete(), ['data-url'=>Url::to(['cars/deletes']), 'class' => 'btn btn-danger btn-sm', 'id'=>'modal-delbtn-cars', 'disabled'=>false]) 
             ?>
         </div>
    </div>
<div class="box-body">    
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <?php  Pjax::begin(['id'=>'cars-grid-pjax']);?>
    <?= GridView::widget([
	'id' => 'cars-grid',
/*	'panelBtn' => Html::button(SDHtml::getBtnAdd(), ['data-url'=>Url::to(['cars/create']), 'class' => 'btn btn-success btn-sm', 'id'=>'modal-addbtn-cars']). ' ' .
		      Html::button(SDHtml::getBtnDelete(), ['data-url'=>Url::to(['cars/deletes']), 'class' => 'btn btn-danger btn-sm', 'id'=>'modal-delbtn-cars', 'disabled'=>true]),*/
	'dataProvider' => $dataProvider,
	'filterModel' => $searchModel,
        'columns' => [
	    [
		'class' => 'yii\grid\CheckboxColumn',
		'checkboxOptions' => [
		    'class' => 'selectionCarIds'
		],
		'headerOptions' => ['style'=>'text-align: center;'],
		'contentOptions' => ['style'=>'width:40px;text-align: center;'],
	    ],
	    [
		'class' => 'yii\grid\SerialColumn',
		'headerOptions' => ['style'=>'text-align: center;'],
		'contentOptions' => ['style'=>'width:60px;text-align: center;'],
	    ],

            'T_motorname',
             'T_motormunber',
            'T_name',
            'T_home',
            'T_district',
            'T_state',
             'T_province',
             'T_numberphone',
             'carColor',
             [
                 'attribute'=>'carType',
                 'value'=>function($model){
                     if(isset($model->carType) && $model->carType != ''){
                         $items= ['1'=>'รถเก่ง','2'=>'รถกระบะ','3'=>'รถจักรยานยนต์'];
                         return $items[$model->carType];
                     }
                 }
                ],
             

	    [
		'class' => 'appxq\sdii\widgets\ActionColumn',
		'contentOptions' => ['style'=>'width:80px;text-align: center;'],
		'template' => '{qrcode} {update} {delete}',
                'buttons'=>[
                    'qrcode'=>function($url, $model){
                        return Html::a('<span class="fa fa-qrcode"></span> '.Yii::t('app', 'สร้าง Qrcode'), 
                                    yii\helpers\Url::to(['site/qrcode?id='.$model->id]), [
                                    'title' => Yii::t('app', 'สร้าง Qrcode'),
                                    'class' => 'btn btn-success btn-xs btnGenQrcode',
                                    'data-action'=>'update',
                                    'data-pjax'=>0
                        ]);
                    },
                    'update'=>function($url, $model){
                        return Html::a('<span class="fa fa-edit"></span> '.Yii::t('app', 'แก้ไข'), 
                                    yii\helpers\Url::to(['cars/update?id='.$model->id]), [
                                    'title' => Yii::t('app', 'Edit'),
                                    'class' => 'btn btn-primary btn-xs',
                                    'data-action'=>'update',
                                    'data-pjax'=>0
                        ]);
                    },
                    'delete' => function ($url, $model) {                         
                        return Html::a('<span class="fa fa-trash"></span> '.Yii::t('app', 'Delete'), 
                                yii\helpers\Url::to(['cars/delete?id='.$model->id]), [
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
    'id' => 'modal-cars',
    //'size'=>'modal-lg',
]);
?>

<?php  \richardfan\widget\JSRegister::begin([
    //'key' => 'bootstrap-modal',
    'position' => \yii\web\View::POS_READY
]); ?>
<script>
// JS script
$(".btnGenQrcode").on('click', function() {
    const url = $(this).attr('href');
    window.open(url, '_blank');
    return false;
});
$('#modal-addbtn-cars').on('click', function() {
    modalCar($(this).attr('data-url'));
});

$('#modal-delbtn-cars').on('click', function() {
    selectionCarGrid($(this).attr('data-url'));
});

$('#cars-grid-pjax').on('click', '.select-on-check-all', function() {
    window.setTimeout(function() {
	var key = $('#cars-grid').yiiGridView('getSelectedRows');
	disabledCarBtn(key.length);
    },100);
});

$('.selectionCoreOptionIds').on('click',function() {
    var key = $('input:checked[class=\"'+$(this).attr('class')+'\"]');
    disabledCarBtn(key.length);
});

$('#cars-grid-pjax').on('dblclick', 'tbody tr', function() {
    var id = $(this).attr('data-key');
    modalCar('<?= Url::to(['cars/update', 'id'=>''])?>'+id);
});	

$('#cars-grid-pjax').on('click', 'tbody tr td a', function() {
    var url = $(this).attr('href');
    var action = $(this).attr('data-action');

    if(action === 'update' || action === 'view') {
	modalCar(url);
    } else if(action === 'delete') {
	yii.confirm('<?= Yii::t('chanpan', 'คุณแน่ใจหรือว่าต้องการลบรายการนี้หรือไม่?')?>', function() {
	    $.post(
		url
	    ).done(function(result) {
		if(result.status == 'success') {
		    <?= SDNoty::show('result.message', 'result.status')?>
		    $.pjax.reload({container:'#cars-grid-pjax'});
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

function disabledCarBtn(num) {
    if(num>0) {
	$('#modal-delbtn-cars').attr('disabled', false);
    } else {
	$('#modal-delbtn-cars').attr('disabled', true);
    }
}

function selectionCarGrid(url) {
    yii.confirm('<?= Yii::t('chanpan', 'Are you sure you want to delete these items?')?>', function() {
	$.ajax({
	    method: 'POST',
	    url: url,
	    data: $('.selectionCarIds:checked[name=\"selection[]\"]').serialize(),
	    dataType: 'JSON',
	    success: function(result, textStatus) {
		if(result.status == 'success') {
		    <?= SDNoty::show('result.message', 'result.status')?>
		    $.pjax.reload({container:'#cars-grid-pjax'});
		} else {
		    <?= SDNoty::show('result.message', 'result.status')?>
		}
	    }
	});
    });
}

function modalCar(url) {
    $('#modal-cars .modal-content').html('<div class=\"sdloader \"><i class=\"sdloader-icon\"></i></div>');
    $('#modal-cars').modal('show')
    .find('.modal-content')
    .load(url);
}
</script>
<?php  \richardfan\widget\JSRegister::end(); ?>