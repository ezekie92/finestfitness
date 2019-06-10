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
 * @property string $token
 * @property bool $confirmado
 *
 * @property Tarifas $tarifa
 * @property ClientesClases[] $clientesClases
 * @property Clases[] $clases
 * @property Entrenamientos[] $entrenamientos
 * @property Pagos[] $pagos
 * @property RutinaActual $rutinaActual
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
     * Escenario donde se convierte un monitor a cliente.
     * @var string
     */
    const SCENARIO_CONVERTIR = 'convertir';

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
            [['peso', 'altura', 'tarifa'], 'default', 'value' => null],
            [['peso', 'altura', 'tarifa'], 'integer'],
            [['telefono'], 'number'],
            [['confirmado'], 'boolean'],
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
                'except' => self::SCENARIO_CONVERTIR,
            ],
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
            'peso' => 'Peso (kg)',
            'altura' => 'Altura (cm)',
            'foto' => 'Foto',
            'telefono' => 'Teléfono',
            'tarifa' => 'Tarifa',
            'fecha_alta' => 'Fecha de alta',
            'token' => 'Token',
            'confirmado' => 'Confirmado',
            'contrasena_repeat' => 'Repetir Contraseña',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTarifaNombre()
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

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getRutinaActual()
    {
        return $this->hasOne(RutinaActual::className(), ['cliente_id' => 'id'])->inverseOf('cliente');
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getClientesClases()
    {
        return $this->hasMany(ClientesClases::className(), ['cliente_id' => 'id'])->inverseOf('cliente');
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getClases()
    {
        return $this->hasMany(Clases::className(), ['id' => 'clase_id'])->viaTable('clientes_clases', ['cliente_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPagos()
    {
        return $this->hasMany(Pagos::className(), ['cliente_id' => 'id'])->inverseOf('cliente');
    }

    /**
     * Devuelve el número de días desde el último pago realizado.
     * @return int El número de días
     */
    public function getTiempoUltimoPago()
    {
        $tiempo = Pagos::find()->select('fecha')->where(['cliente_id' => $this->id])->orderBy(['fecha' => SORT_DESC])->scalar();
        $tiempo = strtotime($tiempo);
        $hoy = strtotime(date('y-m-d'));
        return ($hoy - $tiempo) / (60 * 60 * 24);
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
            if ($this->foto === '') {
                $this->foto = $this->getOldAttribute('foto');
            }
        }
        return true;
    }
}
