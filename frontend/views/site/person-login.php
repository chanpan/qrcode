<?php

use appxq\sdii\helpers\SDNoty;
?>
<div class="panel panel-primary">
    <div class="panel-heading">
        เจ้าหน้าที่ Login
    </div>
    <div class="panel-body">
        <form id="frmPersonLogin">

            <div>
                <label for="username">Username</label>
                <input class="form-control" type="text" name="username" id="username" required autofocus="">

            </div>
            <div>
                <label for="password">Password</label>
                <input class="form-control" type="password" name="password" id="password" required>

            </div><br>
            <div>
                <button type="submit" class="btn btn-primary">Login</button>
            </div>
        </form>
    </div>
</div>




<?php
\richardfan\widget\JSRegister::begin([
    //'key' => 'bootstrap-modal',
    'position' => \yii\web\View::POS_READY
]);
?>
<script>
// JS script
    $('#frmPersonLogin').on('submit', function (e) {
        const url = '<?= \yii\helpers\Url::to(['/site/person-login']) ?>';

        var $form = $(this);
        $.post(
                url, //serialize Yii2 form
                $form.serialize()
                ).done(function (result) {
            if (result['status'] == 'error') {
<?= SDNoty::show('result.message', 'result.status') ?>
            } else if (result['status'] == 'success') {
                const reurl = '<?= \yii\helpers\Url::to(['/site/index']) ?>';
                location.href = reurl;
            }
        }).fail(function () {
        });
        return false;
    });
</script>
<?php \richardfan\widget\JSRegister::end(); ?>