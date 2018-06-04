<?php

namespace app\models;

/**
 * This is the ActiveQuery class for [[Procedimento]].
 *
 * @see Procedimento
 */
class ProcedimentoQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    /**
     * {@inheritdoc}
     * @return Procedimento[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * {@inheritdoc}
     * @return Procedimento|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
