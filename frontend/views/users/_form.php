<?php

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use appxq\sdii\helpers\SDNoty;
use appxq\sdii\helpers\SDHtml;

/* @var $this yii\web\View */
/* @var $model frontend\models\Users */
/* @var $form yii\bootstrap\ActiveForm */
?>

<div class="users-form">

    <?php $form = ActiveForm::begin([
	'id'=>$model->formName(),
    ]); ?>

    <div class="modal-header">
	<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
        <h4 class="modal-title" id="itemModalLabel"><i class="fa fa-table"></i> จัดการผู้ใช้</h4>
    </div>

    <div class="modal-body">
	<?= $form->field($model, 'k_name')->textInput(['maxlength' => true]) ?>

	<?= $form->field($model, 'k_home')->textInput(['maxlength' => true]) ?>
        
        <div class="row">
            <div class="col-md-4"><?= $form->field($model, 'k_district')->textInput(['maxlength' => true]) ?> </div>
            <div class="col-md-4"><?= $form->field($model, 'k_state')->textInput(['maxlength' => true]) ?></div>
            <div class="col-md-4"><?= $form->field($model, 'k_province')->textInput(['maxlength' => true]) ?></div>
        </div> 
	<?= $form->field($model, 'k_numberphone')->textInput(['maxlength' => true]) ?>

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
                $(document).find('#modal-users').modal('hide');
                $.pjax.reload({container:'#users-grid-pjax'});
            } else if(result.action == 'update') {
                $(document).find('#modal-users').modal('hide');
                $.pjax.reload({container:'#users-grid-pjax'});
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