<?php

namespace app\models;

/**
 * This is the model class for table "entrenamientos".
 *
 * @property int $cliente_id
 * @property int $monitor_id
 * @property string $hora_inicio
 * @property string $hora_fin
 * @property int $dia
 *
 * @property Clientes $cliente
 * @property Dias $dia
 * @property Monitores $monitor
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
            [['cliente_id', 'monitor_id', 'dia'], 'required'],
            [['cliente_id', 'monitor_id', 'dia'], 'default', 'value' => null],
            [['cliente_id', 'monitor_id', 'dia'], 'integer'],
            [['hora_inicio', 'hora_fin'], 'safe'],
            [['estado'], 'boolean'],
            [['cliente_id', 'monitor_id', 'dia'], 'unique', 'targetAttribute' => ['cliente_id', 'monitor_id', 'dia']],
            [['cliente_id'], 'exist', 'skipOnError' => true, 'targetClass' => Clientes::className(), 'targetAttribute' => ['cliente_id' => 'id']],
            [['dia'], 'exist', 'skipOnError' => true, 'targetClass' => Dias::className(), 'targetAttribute' => ['dia' => 'id']],
            [['monitor_id'], 'exist', 'skipOnError' => true, 'targetClass' => Monitores::className(), 'targetAttribute' => ['monitor_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'cliente_id' => 'Cliente ID',
            'monitor_id' => 'Monitor ID',
            'hora_inicio' => 'Hora Inicio',
            'hora_fin' => 'Hora Fin',
            'dia' => 'Dia',
            'estado' => 'Aceptado',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCliente()
    {
        return $this->hasOne(Clientes::className(), ['id' => 'cliente_id'])->inverseOf('entrenamientos');
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getDiaSemana()
    {
        return $this->hasOne(Dias::className(), ['id' => 'dia'])->inverseOf('entrenamientos');
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getMonitor()
    {
        return $this->hasOne(Monitores::className(), ['id' => 'monitor_id'])->inverseOf('entrenamientos');
    }
}
