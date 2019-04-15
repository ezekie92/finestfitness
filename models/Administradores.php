<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "administradores".
 *
 * @property int $id
 * @property string $nombre
 * @property string $email
 * @property string $contrasena
 */
class Administradores extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'administradores';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['nombre', 'email', 'contrasena'], 'required'],
            [['nombre'], 'string', 'max' => 32],
            [['email', 'contrasena'], 'string', 'max' => 60],
            [['email'], 'unique'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'nombre' => 'Nombre',
            'email' => 'Email',
            'contrasena' => 'Contrasena',
        ];
    }
}
