<?php

namespace frontend\models;

use Yii;

/**
 * This is the model class for table "admins".
 *
 * @property int $id
 * @property string $P_username ยูสเซอร์เนม
 * @property string $P_pass พาสเวิร์ด
 * @property string $P_name ชื่อ-สกุล
 */
class Admins extends \yii\db\ActiveRecord
{
     public $confirmPassword;
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'admins';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['P_username', 'P_name'], 'required'],
            [['P_pass','confirmPassword'], 'required','on' => 'create'],
            [['P_username', 'P_pass', 'P_name'], 'string', 'max' => 255],
            ['confirmPassword', 'compare', 'compareAttribute'=>'P_pass', 'message'=>"รหัสผ่านไม่ตรงกัน" ],
            ['P_pass', 'string', 'min' => 6, 'max' => 72]
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'P_username' => 'ยูสเซอร์เนม',
            'P_pass' => 'พาสเวิร์ด',
            'P_name' => 'ชื่อ-สกุล',
            'confirmPassword' => Yii::t('user', 'ยืนยันรหัสผ่าน'),
        ];
    }
}
