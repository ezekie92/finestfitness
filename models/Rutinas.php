<?php

namespace app\models;

/**
 * This is the model class for table "rutinas".
 *
 * @property int $id
 * @property string $nombre
 * @property int $cliente_id
 *
 * @property Ejercicios[] $ejercicios
 * @property Clientes $cliente
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
            [['nombre', 'cliente_id'], 'required'],
            [['cliente_id'], 'default', 'value' => null],
            [['cliente_id'], 'integer'],
            [['nombre'], 'string', 'max' => 25],
            [['cliente_id'], 'exist', 'skipOnError' => true, 'targetClass' => Clientes::className(), 'targetAttribute' => ['cliente_id' => 'id']],
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
            'cliente_id' => 'Cliente ID',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getEjercicios()
    {
        return $this->hasMany(Ejercicios::className(), ['rutina_id' => 'id'])->inverseOf('rutina');
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCliente()
    {
        return $this->hasOne(Clientes::className(), ['id' => 'cliente_id'])->inverseOf('rutinas');
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getRutinaActual()
    {
        return $this->hasMany(RutinaActual::className(), ['rutina_id' => 'id'])->inverseOf('rutina');
    }
}
