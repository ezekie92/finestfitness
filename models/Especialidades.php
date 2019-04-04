<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "especialidades".
 *
 * @property int $id
 * @property string $especialidad
 */
class Especialidades extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'especialidades';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['especialidad'], 'string', 'max' => 25],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'especialidad' => 'Especialidad',
        ];
    }
}
