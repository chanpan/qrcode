
<?php 
    use \yii\helpers\Url;
    $admin = isset(Yii::$app->session['admin']) ? Yii::$app->session['admin'] : '';

    $person = isset(Yii::$app->session['person']) ? Yii::$app->session['person'] : '';
?>
<div class="dropdown">
                    <a style='cursor:pointer;font-size:18pt;' class="dropdown-toggle" type="button" data-toggle="dropdown"> 
                    สวัสดีคุณ
                    <?php echo $admin != '' ? $admin['P_name'] : '' ?>
                    <?php echo $person != '' ? $person['v_name'] : '' ?>
                        <span class="caret"></span></a>
                    <ul class="dropdown-menu">
                        <li>
                            <a href="<?= Url::to(['/site/admin-loout']) ?>">
                                <i class="fa fa-sign-out"></i> ออกจากระบบ
                            </a>
                        </li>
                    </ul>

                </div>