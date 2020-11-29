<?php

namespace frontend\models;

use Yii;

/**
 * This is the model class for table "report_problem".
 *
 * @property int $id
 * @property string $title เรื่อง
 * @property string $detail รายละเอียด
 * @property string $user_name ชื่อสกุลผู้แจ้งปัญหา
 * @property string $tel เบอร์โทรศัพท์
 */
class ReportProblem extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'report_problem';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['title', 'user_name','detail','tel'], 'required'],
            [['detail','date'], 'string'],
            [['status'],'integer'],
            [['title', 'user_name'], 'string', 'max' => 255],
            [['tel'], 'string', 'max' => 15],
            [['rstatus','rnote','update_date'],'safe'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'title' => 'เรื่อง',
            'detail' => 'รายละเอียด',
            'user_name' => 'ชื่อสกุลผู้แจ้งปัญหา',
            'tel' => 'เบอร์โทรศัพท์',
            'date' => 'วันที่แจ้งปัญหา',
            'status'=>'สถานะ',
            'rstatus'=>'สถานะ',
            'rnote'=>'หมายเหตุ',
            'update_date'=>'วันที่รปภแก้ไข',
        ];
    }
}
