<?php

namespace app\models;

use Yii;
use yii\db\Expression;
use \yii\db\Query;

/**
 * This is the model class for table "marcadas_hoje".
 *
 * @property string $marcadas
 */
class Dashboard extends ProcedimentoSearch
{
    /**
     * {@inheritdoc}
     */

    public function marcados()
    {
        $hoje1 = date('Y-m-d 00:00:00');
        $hoje2 = date('Y-m-d 23:59:59');

        $query = (new Query())
            ->from('{{procedimento}}')
            ->where(['>', '[[inicio]]', $hoje1])
            ->andWhere(['<', '[[inicio]]', $hoje2])
            ->count();

        return $query;
    }

    public function atrasados()
    {
        $hoje = Yii::$app->formatter->asDate('now', 'php:Y-m-d');
        $agora = Yii::$app->formatter->asDate('now', 'php:Y-m-d H:i:s');

        $query = (new Query())
            ->from('{{procedimento}}')
            ->where(['like', '[[inicio]]', $hoje])
            ->andWhere(['<', '[[inicio]]', $agora])
            ->andWhere(['not in', '[[situacaoId]]', [5, 7, 9]])
            ->count();
        return $query;
    }

    public function andamento()
    {
        $query = (new Query())
            ->from('{{procedimento}}')
            ->where(['in', '[[situacaoId]]', [5]])
            ->count();
        return $query;
    }

    public function finalizados()
    {
        $hoje1 = date('Y-m-d 00:00:00');
        $hoje2 = date('Y-m-d 23:59:59');

        $query = (new Query())
            ->from('{{procedimento}}')
            ->where(['>', '[[inicio]]', $hoje1])
            ->andWhere(['<', '[[inicio]]', $hoje2])
            ->andWhere(['IS NOT', '[[fim]]', null])
            ->count();
        return $query;
    }

    public function repetidos()
    {

    }

    public function salas()
    {

    }

    public function participantes()
    {

    }

}
