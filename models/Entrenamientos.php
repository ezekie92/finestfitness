<?php

namespace app\models;

/**
 * This is the model class for table "entrenamientos".
 *
 * @property int $cliente_id
 * @property int $entrenador_id
 * @property string $hora_inicio
 * @property string $hora_fin
 *
 * @property Personas $cliente
 * @property Personas $entrenador
 */
class Entrenamientos extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'entrenamientos';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['cliente_id', 'entrenador_id'], 'required'],
            [['cliente_id', 'entrenador_id'], 'default', 'value' => null],
            [['cliente_id', 'entrenador_id'], 'integer'],
            [['hora_inicio', 'hora_fin'], 'safe'],
            [['cliente_id', 'entrenador_id'], 'unique', 'targetAttribute' => ['cliente_id', 'entrenador_id']],
            [['cliente_id'], 'exist', 'skipOnError' => true, 'targetClass' => Personas::className(), 'targetAttribute' => ['cliente_id' => 'id']],
            [['entrenador_id'], 'exist', 'skipOnError' => true, 'targetClass' => Personas::className(), 'targetAttribute' => ['entrenador_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'cliente_id' => 'Cliente ID',
            'entrenador_id' => 'Entrenador ID',
            'hora_inicio' => 'Hora Inicio',
            'hora_fin' => 'Hora Fin',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCliente()
    {
        return $this->hasOne(Personas::className(), ['id' => 'cliente_id'])->inverseOf('entrenamientosCliente');
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getEntrenador()
    {
        return $this->hasOne(Personas::className(), ['id' => 'entrenador_id'])->inverseOf('entrenamientosEntrenador');
    }
}
