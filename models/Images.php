<?php

namespace app\models;
use yii\db\ActiveRecord;

class Images extends ActiveRecord
{

    public function rules()
    {
    }

    public function attributeLabels()
    {
        return [
            'name'=>'Название',
            'source'=>'Ссылка',
        ];
    }
}