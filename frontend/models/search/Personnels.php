<?php

namespace frontend\models\search;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use frontend\models\Personnels as PersonnelsModel;

/**
 * Personnels represents the model behind the search form about `frontend\models\Personnels`.
 */
class Personnels extends PersonnelsModel
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id'], 'integer'],
            [[
                'v_username', 'v_pass', 'v_name', 'v_home', 
                'v_district', 'v_state', 'v_province', 'v_career','role'
            ], 'safe'],
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
        $query = PersonnelsModel::find();
        if(isset($params['userType'])){
            $query->andWhere(['userType'=>$params['userType']]);
        }
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

        $query->andFilterWhere(['like', 'v_username', $this->v_username])
            ->andFilterWhere(['like', 'v_pass', $this->v_pass])
            ->andFilterWhere(['like', 'v_name', $this->v_name])
            ->andFilterWhere(['like', 'v_home', $this->v_home])
            ->andFilterWhere(['like', 'v_district', $this->v_district])
            ->andFilterWhere(['like', 'v_state', $this->v_state])
            ->andFilterWhere(['like', 'v_province', $this->v_province])
            ->andFilterWhere(['like', 'v_career', $this->v_career]);

        return $dataProvider;
    }
}
