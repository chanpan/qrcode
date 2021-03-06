<?php

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use appxq\sdii\helpers\SDNoty;
use appxq\sdii\helpers\SDHtml;

/* @var $this yii\web\View */
/* @var $model frontend\models\ReportProblem */
/* @var $form yii\bootstrap\ActiveForm */
?>

<div class="report-problem-form">

    <?php $form = ActiveForm::begin([
	'id'=>$model->formName(),
    ]); ?>

    <div class="modal-header">
	<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
        <h4 class="modal-title" id="itemModalLabel"><i class="fa fa-table"></i> จัดการการแจ้งปัญหา</h4>
    </div>

    <div class="modal-body">
	<?= $form->field($model, 'title')->textInput(['maxlength' => true]) ?>

	<?= $form->field($model, 'detail')->textarea(['rows' => 6]) ?>

	<?= $form->field($model, 'user_name')->textInput(['maxlength' => true]) ?>

	<?= $form->field($model, 'tel')->textInput(['maxlength' => true]) ?>

    <?php
        $items = ['0'=>'ยังไม่จัดการปัญหา','1'=>'จัดการปัญหาแล้ว'];
    ?>
    <?= $form->field($model, 'status')->inline()->radioList($items) ?>


    <div style='border:1px solid blue;padding:10px'>
        <h4>สถานะเจ้าหน้าที่ รปภ.</h4>
         
        <div><b>สถานะ: <b><?= isset($model->rstatus)?$items[$model->rstatus]:'';?>  
        วันที่แก้ไข <?= isset($model->update_date)?\appxq\sdii\utils\SDdate::mysql2phpDateTime($model->update_date):''?></div>
        <div><b>หมายเหตุ</b> <br><?= isset($model->rnote)?$model->rnote:'';?></div>
    </div>

    </div>
    <div class="modal-footer">
        <div class="row">
            <div class="col-md-6 col-md-offset-3">
                <?= Html::submitButton($model->isNewRecord ? Yii::t('app', 'Create') : Yii::t('app', 'Update'), ['class' => $model->isNewRecord ? 'btn btn-success btn-lg btn-block' : 'btn btn-primary btn-lg btn-block']) ?>
	
            </div>
        </div>
    </div> 

    <?php ActiveForm::end(); ?>

</div>

<?php  \richardfan\widget\JSRegister::begin([
    //'key' => 'bootstrap-modal',
    'position' => \yii\web\View::POS_READY
]); ?>
<script>
// JS script
$('form#<?= $model->formName()?>').on('beforeSubmit', function(e) {
    var $form = $(this);
    $.post(
        $form.attr('action'), //serialize Yii2 form
        $form.serialize()
    ).done(function(result) {
        if(result.status == 'success') {
            <?= SDNoty::show('result.message', 'result.status')?>
            if(result.action == 'create') {
                //$(\$form).trigger('reset');
                $(document).find('#modal-report-problem').modal('hide');
                $.pjax.reload({container:'#report-problem-grid-pjax'});
            } else if(result.action == 'update') {
                $(document).find('#modal-report-problem').modal('hide');
                $.pjax.reload({container:'#report-problem-grid-pjax'});
            }
        } else {
            <?= SDNoty::show('result.message', 'result.status')?>
        } 
    }).fail(function() {
        <?= SDNoty::show("'" . SDHtml::getMsgError() . "Server Error'", '"error"')?>
        console.log('server error');
    });
    return false;
});
</script>
<?php  \richardfan\widget\JSRegister::end(); ?>