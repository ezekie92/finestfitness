<?php

namespace app\models;

/**
 * This is the model class for table "horarios".
 *
 * @property int $id
 * @property int $dia
 * @property string $apertura
 * @property string $cierre
 *
 * @property Dias $dia
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
            [['dia'], 'default', 'value' => null],
            [['dia'], 'integer'],
            [['apertura', 'cierre'], 'safe'],
            [['dia'], 'exist', 'skipOnError' => true, 'targetClass' => Dias::className(), 'targetAttribute' => ['dia' => 'id']],
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

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getDia()
    {
        return $this->hasOne(Dias::className(), ['id' => 'dia'])->inverseOf('horarios');
    }
}
