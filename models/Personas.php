<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "personas".
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
 * @property string $tipo
 * @property int $monitor
 * @property string $horario_entrada
 * @property string $horario_salida
 * @property string $especialidad
 *
 * @property Clases[] $clases
 * @property Entrenamientos[] $entrenamientos
 * @property Entrenamientos[] $entrenamientos0
 * @property Personas[] $entrenadors
 * @property Personas[] $clientes
 * @property Personas $monitor0
 * @property Personas[] $personas
 * @property Tarifas $tarifa0
 * @property Rutinas[] $rutinas
 */
class Personas extends \yii\db\ActiveRecord
{
    const SCENARIO_CREATE = 'create';
    const SCENARIO_UPDATE = 'update';
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'personas';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['nombre', 'email', 'fecha_nac', 'tipo'], 'required'],
            [['contrasena'], 'required', 'on' => [self::SCENARIO_CREATE]],
            [['contrasena'], 'safe', 'on' => [self::SCENARIO_UPDATE]], // quitar cuando comparemos contraseñas
            [['fecha_nac', 'fecha_alta', 'horario_entrada', 'horario_salida'], 'safe'],
            [['peso', 'altura', 'tarifa', 'monitor'], 'default', 'value' => null],
            [['peso', 'altura', 'tarifa', 'monitor'], 'integer'],
            [['telefono'], 'number'],
            [['nombre'], 'string', 'max' => 32],
            [['email', 'contrasena'], 'string', 'max' => 60],
            [['foto'], 'string', 'max' => 255],
            [['tipo', 'especialidad'], 'string', 'max' => 10],
            [['email'], 'unique'],
            [['monitor'], 'exist', 'skipOnError' => true, 'targetClass' => self::className(), 'targetAttribute' => ['monitor' => 'id']],
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
            'contrasena' => 'Contraseña',
            'fecha_nac' => 'Fecha de nacimiento',
            'peso' => 'Peso',
            'altura' => 'Altura',
            'foto' => 'Foto',
            'telefono' => 'Teléfono',
            'tarifa' => 'Tarifa',
            'fecha_alta' => 'Fecha de alta',
            'tipo' => 'Tipo',
            'monitor' => 'Monitor',
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
        return $this->hasMany(Clases::className(), ['monitor' => 'id'])->inverseOf('monitorClase');
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getEntrenamientosCliente()
    {
        return $this->hasMany(Entrenamientos::className(), ['cliente_id' => 'id'])->inverseOf('cliente');
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getEntrenamientosEntrenador()
    {
        return $this->hasMany(Entrenamientos::className(), ['entrenador_id' => 'id'])->inverseOf('entrenador');
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getEntrenadores()
    {
        return $this->hasMany(self::className(), ['id' => 'entrenador_id'])->viaTable('entrenamientos', ['cliente_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getClientes()
    {
        return $this->hasMany(self::className(), ['id' => 'cliente_id'])->viaTable('entrenamientos', ['entrenador_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getMonitor()
    {
        return $this->hasOne(self::className(), ['id' => 'monitor'])->inverseOf('personas');
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPersonas()
    {
        return $this->hasMany(self::className(), ['monitor' => 'id'])->inverseOf('monitor');
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTarifa()
    {
        return $this->hasOne(Tarifas::className(), ['id' => 'tarifa'])->inverseOf('personas');
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getRutinas()
    {
        return $this->hasMany(Rutinas::className(), ['autor' => 'id'])->inverseOf('autor');
    }

    public function beforeSave($insert)
    {
        if (!parent::beforeSave($insert)) {
            return false;
        }
        if ($insert) {
            if ($this->scenario === self::SCENARIO_CREATE) {
                goto salto;
            }
        } elseif ($this->scenario === self::SCENARIO_UPDATE) {
            if ($this->contrasena === '') {
                $this->contrasena = $this->getOldAttribute('contrasena');
            } else {
                salto:
                $this->contrasena = Yii::$app->security
                    ->generatePasswordHash($this->contrasena);
            }
        }
        return true;
    }
}
