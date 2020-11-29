<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\bootstrap\ActiveForm;
use appxq\sdii\helpers\SDNoty;
use appxq\sdii\helpers\SDHtml;
$this->title='ลงทะเบียนรถ';

/* @var $this yii\web\View */
/* @var $model frontend\models\Cars */
/* @var $form yii\bootstrap\ActiveForm */


?>

<div class="cars-form">

    <?php $form = ActiveForm::begin([
	'id'=>$model->formName(),
    ]); ?>

    <div class="modal-header">
        <h4 class="modal-title" id="itemModalLabel"> ลงทะเบียน</h4>
    </div>

    <div class="modal-body">
	<div>
    <?= $form->field($model, 'pid')->hiddenInput(['readonly' => true])->label(false) ?>

    <?= $form->field($model, 'T_name')->textInput(['readonly' => true]) ?>

    <?= $form->field($model, 'T_home')->textInput(['readonly' => true]) ?>
    
    <div class="row">
        <div class="col-md-4"><?= $form->field($model, 'T_district')->textInput(['readonly' => true]) ?> </div>
        <div class="col-md-4"><?= $form->field($model, 'T_state')->textInput(['readonly' => true]) ?></div>
        <div class="col-md-4"><?= $form->field($model, 'T_province')->textInput(['readonly' => true]) ?></div>
    </div> 
    </div>

	<?= $form->field($model, 'T_numberphone')->textInput(['maxlength' => true]) ?>

	<?= $form->field($model, 'T_motorname')->textInput(['maxlength' => true]) ?>

	<?= $form->field($model, 'T_motormunber')->textInput(['maxlength' => true]) ?>
    <?= $form->field($model, 'carType')->dropdownList(['1'=>'รถเก่ง','2'=>'รถกระบะ','3'=>'รถจักรยานยนต์'],['prompt'=>'เลือกประเภทรถ...']) ?>
    <?= $form->field($model, 'carColor')->textInput(['maxlength' => true]) ?>

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
            setTimeout(function(){
                location.href = '<?= Url::to(['/site/success'])?>';
            },1000);
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