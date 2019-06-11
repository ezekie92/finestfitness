<?php

namespace app\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;

/**
 * PagosSearch represents the model behind the search form of `app\models\Pagos`.
 */
class PagosSearch extends Pagos
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'cliente_id'], 'integer'],
            [['concepto', 'cliente.nombre'], 'string'],
            [['fecha'], 'date'],
            [['cantidad'], 'number'],
        ];
    }


    public function attributes()
    {
        return array_merge(parent::attributes(), ['cliente.nombre']);
    }

    /**
     * {@inheritdoc}
     */
    public function scenarios()
    {
        // bypass scenarios() implementation in the parent class
        return Model::scenarios();
    }

    /**
     * Creates data provider instance with search query applied.
     *
     * @param array $params
     *
     * @return ActiveDataProvider
     */
    public function search($params)
    {
        $query = Pagos::find()->joinWith('cliente');

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $dataProvider->sort->attributes['cliente.nombre'] = [
           'asc' => ['clientes.nombre' => SORT_ASC],
           'desc' => ['clientes.nombre' => SORT_DESC],
        ];


        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        // grid filtering conditions
        $query->andFilterWhere([
            'id' => $this->id,
            'fecha' => $this->fecha,
            'cliente_id' => $this->cliente_id,
            'cantidad' => $this->cantidad,
        ]);

        $query->andFilterWhere(['ilike', 'concepto', $this->concepto])
        ->andFilterWhere(['ilike', 'clientes.nombre', $this->getAttribute('cliente.nombre')]);

        return $dataProvider;
    }
}
