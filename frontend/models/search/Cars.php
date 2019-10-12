<?php

namespace frontend\models\search;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use frontend\models\Cars as CarsModel;

/**
 * Cars represents the model behind the search form about `frontend\models\Cars`.
 */
class Cars extends CarsModel
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id'], 'integer'],
            [['T_name', 'T_home', 'T_district', 'T_state', 'T_province', 'T_numberphone', 'T_motorname', 'T_motormunber'], 'safe'],
        ];
    }

    /**
     * @inheritdoc
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
        $query = CarsModel::find();

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        $query->andFilterWhere([
            'id' => $this->id,
        ]);

        $query->andFilterWhere(['like', 'T_name', $this->T_name])
            ->andFilterWhere(['like', 'T_home', $this->T_home])
            ->andFilterWhere(['like', 'T_district', $this->T_district])
            ->andFilterWhere(['like', 'T_state', $this->T_state])
            ->andFilterWhere(['like', 'T_province', $this->T_province])
            ->andFilterWhere(['like', 'T_numberphone', $this->T_numberphone])
            ->andFilterWhere(['like', 'T_motorname', $this->T_motorname])
            ->andFilterWhere(['like', 'T_motormunber', $this->T_motormunber]);

        return $dataProvider;
    }
}
