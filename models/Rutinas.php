<?php

namespace app\models;

/**
 * This is the model class for table "rutinas".
 *
 * @property int $id
 * @property string $nombre
 * @property int $ejercicio
 * @property int $dia
 *
 * @property Dias $dia
 * @property Ejercicios $ejercicio
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
            [['nombre', 'ejercicio', 'dia'], 'required'],
            [['ejercicio', 'dia'], 'default', 'value' => null],
            [['ejercicio', 'dia'], 'integer'],
            [['nombre'], 'string', 'max' => 25],
            [['dia'], 'exist', 'skipOnError' => true, 'targetClass' => Dias::className(), 'targetAttribute' => ['dia' => 'id']],
            [['ejercicio'], 'exist', 'skipOnError' => true, 'targetClass' => Ejercicios::className(), 'targetAttribute' => ['ejercicio' => 'id']],
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
            'ejercicio' => 'Ejercicio',
            'dia' => 'Dia',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getDiaRutina()
    {
        return $this->hasOne(Dias::className(), ['id' => 'dia'])->inverseOf('rutinas');
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getEjercicios()
    {
        return $this->hasOne(Ejercicios::className(), ['id' => 'ejercicio'])->inverseOf('rutinas');
    }
}
