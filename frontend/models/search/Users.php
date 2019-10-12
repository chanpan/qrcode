<?php

namespace frontend\models\search;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use frontend\models\Users as UsersModel;

/**
 * Users represents the model behind the search form about `frontend\models\Users`.
 */
class Users extends UsersModel
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id'], 'integer'],
            [['k_name', 'k_home', 'k_district', 'k_state', 'k_province', 'k_numberphone'], 'safe'],
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
        $query = UsersModel::find();

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

        $query->andFilterWhere(['like', 'k_name', $this->k_name])
            ->andFilterWhere(['like', 'k_home', $this->k_home])
            ->andFilterWhere(['like', 'k_district', $this->k_district])
            ->andFilterWhere(['like', 'k_state', $this->k_state])
            ->andFilterWhere(['like', 'k_province', $this->k_province])
            ->andFilterWhere(['like', 'k_numberphone', $this->k_numberphone]);

        return $dataProvider;
    }
}
