<?php

namespace app\models;

/**
 * This is the model class for table "clientes_clases".
 *
 * @property int $cliente_id
 * @property int $clase_id
 *
 * @property Clases $clase
 * @property Clientes $cliente
 */
class ClientesClases extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'clientes_clases';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['cliente_id', 'clase_id'], 'required'],
            [['cliente_id', 'clase_id'], 'default', 'value' => null],
            [['cliente_id', 'clase_id'], 'integer'],
            [['cliente_id', 'clase_id'], 'unique', 'targetAttribute' => ['cliente_id', 'clase_id']],
            [['clase_id'], 'exist', 'skipOnError' => true, 'targetClass' => Clases::className(), 'targetAttribute' => ['clase_id' => 'id']],
            [['cliente_id'], 'exist', 'skipOnError' => true, 'targetClass' => Clientes::className(), 'targetAttribute' => ['cliente_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'cliente_id' => 'Cliente ID',
            'clase_id' => 'Clase ID',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getClase()
    {
        return $this->hasOne(Clases::className(), ['id' => 'clase_id'])->inverseOf('clientesClases');
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCliente()
    {
        return $this->hasOne(Clientes::className(), ['id' => 'cliente_id'])->inverseOf('clientesClases');
    }
}
