<?php

namespace app\models;

/**
 * This is the model class for table "ejercicios".
 *
 * @property int $id
 * @property string $nombre
 * @property int $series
 * @property int $repeticiones
 * @property int $descanso
 * @property int $peso
 *
 * @property Rutinas[] $rutinas
 */
class Ejercicios extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'ejercicios';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['nombre'], 'required'],
            [['series', 'repeticiones', 'descanso', 'peso'], 'default', 'value' => null],
            [['series', 'repeticiones', 'descanso', 'peso'], 'integer'],
            [['nombre'], 'string', 'max' => 60],
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
            'series' => 'Series',
            'repeticiones' => 'Repeticiones',
            'descanso' => 'Descanso',
            'peso' => 'Peso',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getRutinas()
    {
        return $this->hasMany(Rutinas::className(), ['ejercicios' => 'id'])->inverseOf('ejercicio');
    }
}
