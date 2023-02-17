<?php

namespace app\models;

use yii\base\Model;
use yii\web\UploadedFile;

class UploadImagesForm extends Model
{
    /**
     * @var UploadedFile
     */
    public $imageFiles;

    public function rules()
    {
        return [
            [['imageFiles'], 'file', 'skipOnEmpty' => false, 'extensions' => 'png, jpg, svg','maxFiles' => 4],
        ];
    }

    public function upload()
    {
        $count = 0;
        if ($this->validate()) {
            foreach ($this->imageFiles as $file) {
                $filename = $this->transliterate($file->baseName);
                $timestamp = date('Y_m_d_H_i_s');
                $file->saveAs('UploadImages/' . $filename.'_'.$timestamp.'_'.$count. '.' . $file->extension);
                $count +=1;
            }
            return true;
        } else {
            return false;
        }
    }
    public function attributeLabels()
    {
        return [
            'name'=>'Название',
            'source'=>'Ссылка',
            'imageFiles'=>'Загрузка: '
        ];
    }
    public static function transliterate($name) {
        $cyr = array(' ',
            'ё',  'ж',  'х',  'ц',  'ч',  'щ',   'ш',  'ъ',  'э',  'ю',  'я',  'а', 'б', 'в', 'г', 'д', 'е', 'з', 'и', 'й', 'к', 'л', 'м', 'н', 'о', 'п', 'р', 'с', 'т', 'у', 'ф', 'ь',
            'Ё',  'Ж',  'Х',  'Ц',  'Ч',  'Щ',   'Ш',  'Ъ',  'Э',  'Ю',  'Я',  'А', 'Б', 'В', 'Г', 'Д', 'Е', 'З', 'И', 'Й', 'К', 'Л', 'М', 'Н', 'О', 'П', 'Р', 'С', 'Т', 'У', 'Ф', 'Ь');
        $lat = array('_',
            'yo', 'zh', 'kh', 'ts', 'ch', 'shh', 'sh', '``', 'eh', 'yu', 'ya', 'a', 'b', 'v', 'g', 'd', 'e', 'z', 'i', 'j', 'k', 'l', 'm', 'n', 'o', 'p', 'r', 's', 't', 'u', 'f', '`',
            'Yo', 'Zh', 'Kh', 'Ts', 'Ch', 'Shh', 'Sh', '``', 'Eh', 'Yu', 'Ya', 'A', 'B', 'V', 'G', 'D', 'E', 'Z', 'I', 'J', 'K', 'L', 'M', 'N', 'O', 'P', 'R', 'S', 'T', 'U', 'F', '`');
        $filename = mb_strtolower(str_replace($cyr, $lat, $name));
        return $filename;
    }
}