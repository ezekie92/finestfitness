<?php

namespace app\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;

/**
 * ClientesClasesSearch represents the model behind the search form of `app\models\ClientesClases`.
 */
class ClientesClasesSearch extends ClientesClases
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['cliente_id', 'clase_id'], 'integer'],
            [['cliente.nombre', 'clase.nombre'], 'safe'],
        ];
    }

    public function attributes()
    {
        return array_merge(parent::attributes(), ['cliente.nombre', 'clase.nombre']);
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
        $query = ClientesClases::find()->joinWith(['cliente', 'clase']);

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $dataProvider->sort->attributes['cliente.nombre'] = [
           'asc' => ['clientes.nombre' => SORT_ASC],
           'desc' => ['clientes.nombre' => SORT_DESC],
        ];

        $dataProvider->sort->attributes['clase.nombre'] = [
           'asc' => ['clases.nombre' => SORT_ASC],
           'desc' => ['clases.nombre' => SORT_DESC],
        ];


        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        // grid filtering conditions
        $query->andFilterWhere([
            'cliente_id' => $this->cliente_id,
            'clase_id' => $this->clase_id,
        ]);

        $query->andFilterWhere(['ilike', 'clientes.nombre', $this->getAttribute('cliente.nombre')])
              ->andFilterWhere(['ilike', 'clases.nombre', $this->getAttribute('clase.nombre')]);


        return $dataProvider;
    }
}
