<?php

namespace app\models;

/**
 * This is the model class for table "clientes".
 *
 * @property int $id
 * @property string $nombre
 * @property string $email
 * @property string $contrasena
 * @property string $fecha_nac
 * @property int $peso
 * @property int $altura
 * @property string $foto
 * @property string $telefono
 * @property int $tarifa
 * @property string $fecha_alta
 * @property int $monitor
 *
 * @property Monitores $monitor
 * @property Tarifas $tarifa
 * @property Entrenamientos[] $entrenamientos
 * @property Monitores[] $monitores
 */
class Clientes extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'clientes';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['nombre', 'email', 'contrasena', 'fecha_nac', 'tarifa'], 'required'],
            [['fecha_nac', 'fecha_alta'], 'safe'],
            [['peso', 'altura', 'tarifa', 'monitor'], 'default', 'value' => null],
            [['peso', 'altura', 'tarifa', 'monitor'], 'integer'],
            [['telefono'], 'number'],
            [['nombre'], 'string', 'max' => 32],
            [['email', 'contrasena'], 'string', 'max' => 60],
            [['foto'], 'string', 'max' => 255],
            [['email'], 'unique'],
            [['monitor'], 'exist', 'skipOnError' => true, 'targetClass' => Monitores::className(), 'targetAttribute' => ['monitor' => 'id']],
            [['tarifa'], 'exist', 'skipOnError' => true, 'targetClass' => Tarifas::className(), 'targetAttribute' => ['tarifa' => 'id']],
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
            'email' => 'Email',
            'contrasena' => 'Contrasena',
            'fecha_nac' => 'Fecha Nac',
            'peso' => 'Peso',
            'altura' => 'Altura',
            'foto' => 'Foto',
            'telefono' => 'Telefono',
            'tarifa' => 'Tarifa',
            'fecha_alta' => 'Fecha Alta',
            'monitor' => 'Monitor',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getMonitor()
    {
        return $this->hasOne(Monitores::className(), ['id' => 'monitor'])->inverseOf('clientes');
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTarifa()
    {
        return $this->hasOne(Tarifas::className(), ['id' => 'tarifa'])->inverseOf('clientes');
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getEntrenamientos()
    {
        return $this->hasMany(Entrenamientos::className(), ['cliente_id' => 'id'])->inverseOf('cliente');
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getMonitores()
    {
        return $this->hasMany(Monitores::className(), ['id' => 'monitor_id'])->viaTable('entrenamientos', ['cliente_id' => 'id']);
    }
}
