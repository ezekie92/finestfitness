<?php

namespace app\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;

/**
 * ClasesSearch represents the model behind the search form of `app\models\Clases`.
 */
class ClasesSearch extends Clases
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'dia', 'monitor', 'plazas'], 'integer'],
            [['nombre', 'hora_inicio', 'hora_fin', 'diaClase.dia', 'monitorClase.nombre'], 'safe'],
        ];
    }

    public function attributes()
    {
        return array_merge(parent::attributes(), ['diaClase.dia', 'monitorClase.nombre']);
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
        $query = Clases::find()->joinWith(['diaClase', 'monitorClase']);

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $dataProvider->sort->attributes['diaClase.dia'] = [
           'asc' => ['dias.dia' => SORT_ASC],
           'desc' => ['dias.dia' => SORT_DESC],
        ];

        $dataProvider->sort->attributes['monitorClase.nombre'] = [
           'asc' => ['monitores.nombre' => SORT_ASC],
           'desc' => ['monitores.nombre' => SORT_DESC],
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
            'hora_inicio' => $this->hora_inicio,
            'hora_fin' => $this->hora_fin,
            'dia' => $this->dia,
            'monitor' => $this->monitor,
            'plazas' => $this->plazas,
        ]);

        $query->andFilterWhere(['ilike', 'nombre', $this->nombre])
        ->andFilterWhere(['ilike', 'dias.dia', $this->getAttribute('diaClase.dia')])
        ->andFilterWhere(['ilike', 'monitores.nombre', $this->getAttribute('monitorClase.nombre')]);

        return $dataProvider;
    }
}
