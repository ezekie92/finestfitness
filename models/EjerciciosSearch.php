<?php

namespace app\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Ejercicios;

/**
 * EjerciciosSearch represents the model behind the search form of `app\models\Ejercicios`.
 */
class EjerciciosSearch extends Ejercicios
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'dia_id', 'rutina_id', 'descanso', 'peso'], 'integer'],
            [['nombre', 'series', 'repeticiones'], 'safe'],
        ];
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
     * Creates data provider instance with search query applied
     *
     * @param array $params
     *
     * @return ActiveDataProvider
     */
    public function search($params)
    {
        $query = Ejercicios::find();

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        // grid filtering conditions
        $query->andFilterWhere([
            'id' => $this->id,
            'dia_id' => $this->dia_id,
            'rutina_id' => $this->rutina_id,
            'descanso' => $this->descanso,
            'peso' => $this->peso,
        ]);

        $query->andFilterWhere(['ilike', 'nombre', $this->nombre])
            ->andFilterWhere(['ilike', 'series', $this->series])
            ->andFilterWhere(['ilike', 'repeticiones', $this->repeticiones]);

        return $dataProvider;
    }
}
