<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "clases".
 *
 * @property int $id
 * @property string $nombre
 * @property string $fecha
 * @property int $monitor
 * @property int $plazas
 *
 * @property Monitores $monitor0
 * @property ClientesClases[] $clientesClases
 * @property Clientes[] $clientes
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
            [['nombre', 'fecha', 'monitor'], 'required'],
            [['fecha'], 'safe'],
            [['monitor', 'plazas'], 'default', 'value' => null],
            [['monitor', 'plazas'], 'integer'],
            ['plazas', 'compare', 'compareValue' => '0', 'operator' => '>='],
            [['nombre'], 'string', 'max' => 32],
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
            'fecha' => 'Fecha',
            'monitorClase.nombre' => 'Monitor',
            'plazas' => 'Plazas',
        ];
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
