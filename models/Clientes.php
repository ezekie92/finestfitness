<?php

namespace app\models;

use Yii;

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
 * @property Rutinas[] $rutinas
 */
class Clientes extends \yii\db\ActiveRecord
{
    /**
     * Escenario para la creación de clientes.
     * @var string
     */
    const SCENARIO_CREATE = 'create';
    /**
     * Escenario para la modificación de clientes.
     * @var string
     */
    const SCENARIO_UPDATE = 'update';

    /**
     * Se usa para comparar las contraseñas al cambiarlas.
     * @var string
     */
    public $contrasena_repeat;


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
            [['nombre', 'email', 'fecha_nac', 'tarifa'], 'required'],
            [['contrasena'], 'required', 'on' => [self::SCENARIO_CREATE]],
            [['contrasena_repeat'], 'safe', 'on' => [self::SCENARIO_UPDATE]],
            [['contrasena'], 'compare', 'on' => [self::SCENARIO_UPDATE]],
            [['fecha_nac', 'fecha_alta', 'confirmado', 'token'], 'safe'],
            [['peso', 'altura', 'tarifa', 'monitor'], 'default', 'value' => null],
            [['peso', 'altura', 'tarifa', 'monitor'], 'integer'],
            [['telefono'], 'number'],
            [['nombre'], 'string', 'max' => 32],
            [['email', 'contrasena'], 'string', 'max' => 60],
            [['foto'], 'string', 'max' => 255],
            [['email'], 'unique'],
            [['email'], 'unique',
               'targetClass' => Administradores::ClassName(),
                'targetAttribute' => ['email'],
            ],
            [['email'], 'unique',
               'targetClass' => Monitores::ClassName(),
                'targetAttribute' => ['email'],
            ],
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
            'contrasena' => 'Contraseña',
            'fecha_nac' => 'Fecha de nacimiento',
            'peso' => 'Peso',
            'altura' => 'Altura',
            'foto' => 'Foto',
            'telefono' => 'Teléfono',
            'tarifa' => 'Tarifa',
            'fecha_alta' => 'Fecha de alta',
            'monitor' => 'Monitor',
            'token' => 'Token',
            'confirmado' => 'Confirmado',
            'contrasena_repeat' => 'Repetir Contraseña',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getEntrenador()
    {
        return $this->hasOne(Monitores::className(), ['id' => 'monitor'])->inverseOf('clientes');
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTarifas()
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

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getRutinas()
    {
        return $this->hasMany(Rutinas::className(), ['cliente_id' => 'id'])->inverseOf('cliente');
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
                $this->token = Yii::$app->security->generateRandomString();
            }
        }
        return true;
    }
}
