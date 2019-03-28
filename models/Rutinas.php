<?php

namespace app\models;

/**
 * This is the model class for table "rutinas".
 *
 * @property int $id
 * @property string $nombre
 * @property int $ejercicios
 * @property int $autor
 *
 * @property Ejercicios $ejercicios0
 * @property Personas $autor0
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
            [['nombre', 'ejercicios', 'autor'], 'required'],
            [['ejercicios', 'autor'], 'default', 'value' => null],
            [['ejercicios', 'autor'], 'integer'],
            [['nombre'], 'string', 'max' => 25],
            [['ejercicios'], 'exist', 'skipOnError' => true, 'targetClass' => Ejercicios::className(), 'targetAttribute' => ['ejercicios' => 'id']],
            [['autor'], 'exist', 'skipOnError' => true, 'targetClass' => Personas::className(), 'targetAttribute' => ['autor' => 'id']],
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
            'ejercicios' => 'Ejercicios',
            'autor' => 'Autor',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getEjercicio()
    {
        return $this->hasOne(Ejercicios::className(), ['id' => 'ejercicios'])->inverseOf('rutinas');
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getAutor()
    {
        return $this->hasOne(Personas::className(), ['id' => 'autor'])->inverseOf('rutinas');
    }
}
