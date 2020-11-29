<?php

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use appxq\sdii\helpers\SDNoty;
use appxq\sdii\helpers\SDHtml; 
$this->title='จัดการปัญหา';
?>

<div class="report-problem-form">

    
 
    <?php $form = ActiveForm::begin([
	    'id'=>$model->formName(),
    ]); ?>
 <a href="#" onclick='window.history.back()'>ย้อนกลับ</a>
     <h3><?= $this->title; ?></h3>

     <div style='border:1px solid blue;padding:10px'>
        <div><b>ปัญหาเรื่อง</b> <br><?= isset($model->title)?$model->title:'';?></div>
        <div><b>รายละเอียด</b> <br><?= isset($model->detail)?$model->detail:'';?></div>
    </div>

    <div> 
        <?php
            $items = ['0'=>'ยังไม่จัดการปัญหา','1'=>'จัดการปัญหาแล้ว'];
        ?>
        <?= $form->field($model, 'rstatus')->inline()->radioList($items) ?>
        <?= $form->field($model, 'rnote')->textarea() ?>
    </div>
    <div >
        <?= Html::submitButton('บันทึก',['class'=>'btn btn-primary']) ?>
        <a href="#" onclick='window.history.back()'>ยกเลิก</a>
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
               setTimeout(function(){
                window.history.back();
               },1500) 
            } else if(result.action == 'update') {
                
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