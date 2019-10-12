<?php

namespace frontend\models;

use Yii;

/**
 * This is the model class for table "users".
 *
 * @property int $id
 * @property string $k_name ชื่อ-สกุล
 * @property string $k_home ที่อยู่/บ้าน
 * @property string $k_district ตำบล
 * @property string $k_state อำเภอ
 * @property string $k_province จังหวัด
 * @property string $k_numberphone เบอร์โทรศัพท์
 */
class Users extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'users';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['k_numberphone','k_name', 'k_home', 'k_district', 'k_state', 'k_province'], 'required'],
            [['k_name', 'k_home', 'k_district', 'k_state', 'k_province'], 'string', 'max' => 255],
            [['k_numberphone'], 'string', 'max' => 15],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'k_name' => 'ชื่อ-สกุล',
            'k_home' => 'ที่อยู่/บ้าน',
            'k_district' => 'ตำบล',
            'k_state' => 'อำเภอ',
            'k_province' => 'จังหวัด',
            'k_numberphone' => 'เบอร์โทรศัพท์',
        ];
    }
}
