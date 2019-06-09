<?php

namespace app\models;

/**
 * This is the model class for table "entrenamientos".
 *
 * @property int $cliente_id
 * @property int $monitor_id
 * @property string $fecha
 * @property bool $estado
 *
 * @property Clientes $cliente
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
            [['cliente_id', 'monitor_id', 'fecha'], 'required'],
            [['cliente_id', 'monitor_id'], 'default', 'value' => null],
            [['cliente_id', 'monitor_id'], 'integer'],
            [['fecha'], 'safe'],
            [['estado'], 'boolean'],
            [['cliente_id', 'monitor_id', 'fecha'], 'unique', 'targetAttribute' => ['cliente_id', 'monitor_id', 'fecha']],
            [['cliente_id'], 'exist', 'skipOnError' => true, 'targetClass' => Clientes::className(), 'targetAttribute' => ['cliente_id' => 'id']],
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
            'fecha' => 'Día',
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
    public function getMonitor()
    {
        return $this->hasOne(Monitores::className(), ['id' => 'monitor_id'])->inverseOf('entrenamientos');
    }
}
