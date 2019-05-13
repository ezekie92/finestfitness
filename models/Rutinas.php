<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "rutinas".
 *
 * @property int $id
 * @property string $nombre
 *
 * @property Ejercicios[] $ejercicios
 */
class Rutinas extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'rutinas';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['nombre'], 'required'],
            [['nombre'], 'string', 'max' => 25],
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
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getEjercicios()
    {
        return $this->hasMany(Ejercicios::className(), ['rutina_id' => 'id'])->inverseOf('rutina');
    }
}
