<?php

namespace app\models;

/**
 * This is the model class for table "monitores".
 *
 * @property int $id
 * @property string $nombre
 * @property string $email
 * @property string $contrasena
 * @property string $fecha_nac
 * @property string $foto
 * @property string $telefono
 * @property string $horario_entrada
 * @property string $horario_salida
 * @property int $especialidad
 *
 * @property Clases[] $clases
 * @property Clientes[] $clientes
 * @property Entrenamientos[] $entrenamientos
 * @property Clientes[] $clientes0
 */
class Monitores extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'monitores';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['nombre', 'email', 'contrasena', 'fecha_nac', 'especialidad'], 'required'],
            [['fecha_nac', 'horario_entrada', 'horario_salida'], 'safe'],
            [['telefono'], 'number'],
            [['especialidad'], 'default', 'value' => null],
            [['especialidad'], 'integer'],
            [['nombre'], 'string', 'max' => 32],
            [['email', 'contrasena'], 'string', 'max' => 60],
            [['foto'], 'string', 'max' => 255],
            [['email'], 'unique'],
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
            'foto' => 'Foto',
            'telefono' => 'Telefono',
            'horario_entrada' => 'Horario Entrada',
            'horario_salida' => 'Horario Salida',
            'especialidad' => 'Especialidad',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getClases()
    {
        return $this->hasMany(Clases::className(), ['monitor' => 'id'])->inverseOf('monitor');
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getClientes()
    {
        return $this->hasMany(Clientes::className(), ['monitor' => 'id'])->inverseOf('monitor');
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getEntrenamientos()
    {
        return $this->hasMany(Entrenamientos::className(), ['monitor_id' => 'id'])->inverseOf('monitor');
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getClientesEntrenamientos()
    {
        return $this->hasMany(Clientes::className(), ['id' => 'cliente_id'])->viaTable('entrenamientos', ['monitor_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getEsp()
    {
        return $this->hasOne(Especialidades::className(), ['id' => 'especialidad'])->inverseOf('monitores');
    }
}
