<?php

namespace frontend\models;

use Yii;

/**
 * This is the model class for table "cars".
 *
 * @property int $id
 * @property string $T_name ชื่อ-สกุล
 * @property string $T_home ที่อยู่/บ้าน
 * @property string $T_district ตำบล
 * @property string $T_state อำเภอ
 * @property string $T_province จังหวัด
 * @property string $T_numberphone เบอร์โทรศัพท์
 * @property string $T_motorname ยี่ห้อรถ
 * @property string $T_motormunber ทะเบียนรถ
 */
class Cars extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'cars';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['T_name', 'T_home', 'T_district', 'T_state', 'T_province', 'T_motorname', 'T_motormunber'], 'required'],
            [['T_name', 'T_home', 'T_district', 'T_state', 'T_province', 'T_motorname', 'T_motormunber','carType','carColor'], 'string', 'max' => 255],
            [['T_numberphone'], 'string', 'max' => 15],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'T_name' => 'ชื่อ-สกุล',
            'T_home' => 'ที่อยู่/บ้าน',
            'T_district' => 'ตำบล',
            'T_state' => 'อำเภอ',
            'T_province' => 'จังหวัด',
            'T_numberphone' => 'เบอร์โทรศัพท์',
            'T_motorname' => 'ยี่ห้อรถ',
            'T_motormunber' => 'ทะเบียนรถ',
            'carType'=>'ชนิดรถ เช่น รถเก๋ง รถกระบะ',
            'carColor'=>'สีรถ'
        ];
    }
}
