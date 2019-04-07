<?php

namespace app\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Monitores;

/**
 * MonitoresSearch represents the model behind the search form of `app\models\Monitores`.
 */
class MonitoresSearch extends Monitores
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'especialidad'], 'integer'],
            [['nombre', 'email', 'contrasena', 'fecha_nac', 'foto', 'horario_entrada', 'horario_salida'], 'safe'],
            [['telefono'], 'number'],
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
        $query = Monitores::find();

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
            'fecha_nac' => $this->fecha_nac,
            'telefono' => $this->telefono,
            'horario_entrada' => $this->horario_entrada,
            'horario_salida' => $this->horario_salida,
            'especialidad' => $this->especialidad,
        ]);

        $query->andFilterWhere(['ilike', 'nombre', $this->nombre])
            ->andFilterWhere(['ilike', 'email', $this->email])
            ->andFilterWhere(['ilike', 'contrasena', $this->contrasena])
            ->andFilterWhere(['ilike', 'foto', $this->foto]);

        return $dataProvider;
    }
}
