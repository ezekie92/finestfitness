<?php

namespace app\models;

/**
 * This is the model class for table "ejercicios".
 *
 * @property int $id
 * @property string $nombre
 * @property int $dia_id
 * @property int $rutina_id
 * @property string $series
 * @property string $repeticiones
 * @property int $descanso
 * @property int $peso
 *
 * @property Dias $dia
 * @property Rutinas $rutina
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
            [['nombre', 'dia_id', 'rutina_id'], 'required'],
            [['dia_id', 'rutina_id', 'descanso', 'peso'], 'default', 'value' => null],
            [['dia_id', 'rutina_id', 'descanso', 'peso'], 'integer'],
            [['nombre'], 'string', 'max' => 60],
            [['series'], 'string', 'max' => 5],
            [['repeticiones'], 'string', 'max' => 15],
            [['dia_id'], 'exist', 'skipOnError' => true, 'targetClass' => Dias::className(), 'targetAttribute' => ['dia_id' => 'id']],
            [['rutina_id'], 'exist', 'skipOnError' => true, 'targetClass' => Rutinas::className(), 'targetAttribute' => ['rutina_id' => 'id']],
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
            'dia_id' => 'Día',
            'rutina_id' => 'Rutina ID',
            'series' => 'Series',
            'repeticiones' => 'Repeticiones',
            'descanso' => 'Descanso',
            'peso' => 'Peso (kg)',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getDia()
    {
        return $this->hasOne(Dias::className(), ['id' => 'dia_id'])->inverseOf('ejercicios');
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getRutina()
    {
        return $this->hasOne(Rutinas::className(), ['id' => 'rutina_id'])->inverseOf('ejercicios');
    }
}
