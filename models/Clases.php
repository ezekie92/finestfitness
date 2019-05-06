<?php

namespace app\models;

/**
 * This is the model class for table "clases".
 *
 * @property int $id
 * @property string $nombre
 * @property string $hora_inicio
 * @property string $hora_fin
 * @property int $dia
 * @property int $monitor
 * @property int $plazas
 *
 * @property Dias $dia
 * @property Monitores $monitor
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
            [['nombre', 'hora_inicio', 'hora_fin', 'dia', 'monitor'], 'required'],
            [['hora_inicio', 'hora_fin'], 'safe'],
            [['dia', 'monitor', 'plazas'], 'default', 'value' => null],
            [['dia', 'monitor', 'plazas'], 'integer'],
            [['nombre'], 'string', 'max' => 32],
            [['dia'], 'exist', 'skipOnError' => true, 'targetClass' => Dias::className(), 'targetAttribute' => ['dia' => 'id']],
            [['monitor'], 'exist', 'skipOnError' => true, 'targetClass' => Monitores::className(), 'targetAttribute' => ['monitor' => 'id']],
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
            'diaClase.dia' => 'Día',
            'monitorClase.nombre' => 'Monitor',
            'plazas' => 'Plazas',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getDiaClase()
    {
        return $this->hasOne(Dias::className(), ['id' => 'dia'])->inverseOf('clases');
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getMonitorClase()
    {
        return $this->hasOne(Monitores::className(), ['id' => 'monitor'])->inverseOf('clases');
    }
}
