<?php

namespace app\models;

use Yii;
use yii\base\Model;

class MyForm extends Model
{
    public $name;
    public $email;
    public $order;
    public $file;

    public function rules() {
        return [
          [['name', 'email', 'order'], 'required', 'message' => 'Все поля длжны быть зполнены'],
          ['email', 'email', 'message' => 'Не корректный e-mail адрес'],
          [['file'], 'file', 'extensions' => 'jpg, png']
        ];
    }

} 