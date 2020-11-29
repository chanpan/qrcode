<?php
$qr = 'http://qrcode.newriched.com/cars/view?id='.$id;
//$name = isset($car['T_name'])?$car['T_name']:'';
//$home = isset($car['T_home'])?$car['T_home']:'';
//$tombon = isset($car['T_district'])?$car['T_district']:'';
//$amphur = isset($car['T_state'])?$car['T_state']:'';
//$province = isset($car['T_province'])?$car['T_province']:'';
//$tel = isset($car['T_numberphone'])?$car['T_numberphone']:'';
//$motorname = isset($car['T_motorname'])?$car['T_motorname']:'';
//$motormunber = isset($car['T_motormunber'])?$car['T_motormunber']:'';



//$str = "{$name}";
?>
<barcode code="<?=$qr?>" type="QR" size="2.3" error="M" disableborder = "1"/>