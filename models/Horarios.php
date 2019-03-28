<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "horarios".
 *
 * @property int $id
 * @property string $dia
 * @property string $apertura
 * @property string $cierre
 */
class Horarios extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'horarios';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['dia', 'apertura', 'cierre'], 'required'],
            [['apertura', 'cierre'], 'safe'],
            [['dia'], 'string', 'max' => 15],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'dia' => 'Dia',
            'apertura' => 'Apertura',
            'cierre' => 'Cierre',
        ];
    }
}
