<?php

namespace app\models;

use Yii;

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
            ['hora_fin', 'compare', 'compareAttribute' => 'hora_inicio', 'operator' => '>'],
            [['dia', 'monitor', 'plazas'], 'default', 'value' => null],
            [['dia', 'monitor', 'plazas'], 'integer'],
            ['plazas', 'compare', 'compareValue' => '0', 'operator' => '>='],
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

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getClientesClases()
    {
        return $this->hasMany(ClientesClases::className(), ['clase_id' => 'id'])->inverseOf('clase');
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getClientes()
    {
        return $this->hasMany(Clientes::className(), ['id' => 'cliente_id'])->viaTable('clientes_clases', ['clase_id' => 'id']);
    }

    /**
     * Comprueba si un cliente está inscrito a una clase.
     * @return [type] [description]
     */
    public function clienteInscrito()
    {
        $inscripcion = $this->getClientesClases()->where(['cliente_id' => Yii::$app->user->identity->getNId()])->one();

        return $inscripcion;
    }

    /**
     * Devuelve el número de plazas libres de una clase.
     * @return int El número de plazas libres
     */
    public function plazasLibres()
    {
        $ocupadas = count($this->getClientes()->all());
        $libres = $this->plazas - $ocupadas;
        return $libres;
    }
}
