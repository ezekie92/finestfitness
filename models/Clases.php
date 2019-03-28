<?php

namespace app\models;

/**
 * This is the model class for table "clases".
 *
 * @property int $id
 * @property string $nombre
 * @property string $hora_inicio
 * @property string $hora_fin
 * @property int $monitor
 * @property int $plazas
 *
 * @property Personas $monitor0
 */
class Clases extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'clases';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['nombre', 'hora_inicio', 'hora_fin', 'monitor'], 'required'],
            [['hora_inicio', 'hora_fin'], 'safe'],
            [['monitor', 'plazas'], 'default', 'value' => null],
            [['monitor', 'plazas'], 'integer'],
            [['nombre'], 'string', 'max' => 32],
            [['monitor'], 'exist', 'skipOnError' => true, 'targetClass' => Personas::className(), 'targetAttribute' => ['monitor' => 'id']],
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
            'hora_inicio' => 'Hora Inicio',
            'hora_fin' => 'Hora Fin',
            'monitor' => 'Monitor',
            'plazas' => 'Plazas',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getMonitorClase()
    {
        return $this->hasOne(Personas::className(), ['id' => 'monitor'])->inverseOf('clases');
    }
}
