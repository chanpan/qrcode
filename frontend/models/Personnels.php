<?php

namespace frontend\models;

use Yii;

/**
 * This is the model class for table "personnels".
 *
 * @property int $id
 * @property string $v_username ยูสเซอร์เนม
 * @property string $v_pass พาสเวิร์ด
 * @property string $v_name ชื่อ-สกุล
 * @property string $v_home ที่อยู่/บ้าน
 * @property string $v_district ตำบล
 * @property string $v_state อำเภอ
 * @property string $v_province จังหวัด
 * @property string $v_career ตำแหน่ง
 */
class Personnels extends \yii\db\ActiveRecord
{
    public $confirmPassword;
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'personnels';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['v_username','v_name', 'v_home', 'v_district', 'v_state', 'v_province', 'v_career'], 'required'],
            [['v_pass','confirmPassword'], 'required','on' => 'create'],
            ['confirmPassword', 'compare', 'compareAttribute'=>'v_pass', 'message'=>"รหัสผ่านไม่ตรงกัน" ],
            ['v_pass', 'string', 'min' => 6, 'max' => 72],
            ['userType','safe'],
            [['v_username', 'v_pass', 'v_name', 'v_home', 'v_district', 'v_state', 'v_province', 'v_career'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'v_username' => 'ชื่อผู้ใช้งาน',
            'v_pass' => 'รหัสผ่าน',
            'v_name' => 'ชื่อ-สกุล',
            'v_home' => 'ที่อยู่',
            'v_district' => 'ตำบล',
            'v_state' => 'อำเภอ',
            'v_province' => 'จังหวัด',
            'v_career' => 'ตำแหน่ง',
            'confirmPassword' => Yii::t('user', 'ยืนยันรหัสผ่าน'),
        ];
    }
}
