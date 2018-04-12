<?php

namespace sky\emailqueue\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use sky\emailqueue\models\EmailQueue;

/**
 * EmailQueueSearch represents the model behind the search form of `sky\emailqueue\models\EmailQueue`.
 */
class EmailQueueSearch extends EmailQueue
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'priority', 'type', 'server_id', 'status'], 'integer'],
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
        $query = EmailQueue::find();

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'sort' => [
                'defaultOrder' => [
                    'status' => SORT_ASC,
                    'time_send' => SORT_ASC,
                ],
            ],
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
            'type' => $this->type,
            'server_id' => $this->server_id,
            'status' => $this->status,
        ]);

        return $dataProvider;
    }
}