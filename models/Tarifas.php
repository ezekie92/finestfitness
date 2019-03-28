<?php

namespace app\models;

/**
 * This is the model class for table "tarifas".
 *
 * @property int $id
 * @property string $tarifa
 * @property string $precio
 * @property string $hora_entrada_min
 * @property string $hora_entrada_max
 *
 * @property Personas[] $personas
 */
class Tarifas extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'tarifas';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['tarifa', 'precio', 'hora_entrada_min', 'hora_entrada_max'], 'required'],
            [['precio'], 'number'],
            [['hora_entrada_min', 'hora_entrada_max'], 'safe'],
            [['tarifa'], 'string', 'max' => 30],
            [['tarifa'], 'unique'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'tarifa' => 'Tarifa',
            'precio' => 'Precio',
            'hora_entrada_min' => 'Hora Entrada Min',
            'hora_entrada_max' => 'Hora Entrada Max',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPersonas()
    {
        return $this->hasMany(Personas::className(), ['tarifa' => 'id'])->inverseOf('tarifa');
    }
}
