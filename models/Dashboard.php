<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\db\Expression;
use yii\db\Query;
use yii\data\SqlDataProvider;
use yii\data\ActiveDataProvider;
use app\models\ProcedimentoSearch;

/**
 * This is the model class for table "marcadas_hoje".
 *
 * @property string $marcadas
 */
class Dashboard extends Model
{
    /**
     * {@inheritdoc}
     */

    // private $banco;
    //
    // public function __constructor() {
    //     $banco = Yii::$app->user->identity->hospital;
    // }
    //
    // public function __getBanco()
    // {
    //     return $this->$banco;
    // }
    //
    // public function __setBanco($value)
    // {
    //     $this->$banco = Yii::$app->user->identity->hospital;
    // }

    public function marcados()
    {
        $banco = Yii::$app->user->identity->hospital;
        $hoje1 = date('Y-m-d 00:00:00');
        $hoje2 = date('Y-m-d 23:59:59');

        $query = (new Query())
            ->from('{{'.$banco.'}}.{{procedimento}}')
            ->where(['>=', '[[inicio]]', $hoje1])
            ->andWhere(['<=', '[[inicio]]', $hoje2])
            ->andWhere(['is', '[[excluido]]', null])
            //->andWhere(['is', '[[fim]]', null])
            ->count();

        return $query;
    }

    // public function marcadosLink()
    // {
    //     $hoje1 = date('Y-m-d 00:00:00');
    //     $hoje2 = date('Y-m-d 23:59:59');
    //
    //     $dataProvider = new SqlDataProvider([
    //         'sql' => "
    //             SELECT
    //               [[procedimento.id]] as id,
    //             FROM
    //               {{procedimento}}
    //             WHERE
    //               ([[procedimento.inicio]] BETWEEN :hoje1 AND :hoje2) and
    //               ([[procedimento.excluido]] is null)
    //             ORDER BY
    //               id asc",
    //         'params' => [
    //           ':hoje1' => $hoje1,
    //           ':hoje2' => $hoje2,
    //         ],
    //     ]);
    //     $marcadosLink = $dataProvider;
    //     return $marcadosLink;
    // }

    public function andamento()
    {
        $banco = Yii::$app->user->identity->hospital;
        $hoje1 = date('Y-m-d 00:00:00');
        $hoje2 = date('Y-m-d 23:59:59');

        $query = (new Query())
            ->from('{{'.$banco.'}}.{{procedimento}}')
            ->where(['>=', '[[inicio]]', $hoje1])
            ->andWhere(['<=', '[[inicio]]', $hoje2])
            ->andWhere(['=', '[[situacaoId]]', 5])
            ->andWhere(['is', '[[excluido]]', null])
            ->andWhere(['is', '[[fim]]', null])
            ->count();
        return $query;
    }

    public function atrasados()
    {
        $banco = Yii::$app->user->identity->hospital;
        $hoje = Yii::$app->formatter->asDate('now', 'php:Y-m-d');
        $agora = Yii::$app->formatter->asDate('now', 'php:Y-m-d H:i:s');

        $query = (new Query())
            ->from('{{'.$banco.'}}.{{procedimento}}')
            ->where(['like', '[[inicio]]', $hoje])
            ->andWhere(['<=', '[[inicio]]', $agora])
            ->andWhere(['not in', '[[situacaoId]]', [5, 7, 9]])
            ->andWhere(['is', '[[excluido]]', null])
            ->andWhere(['is', '[[fim]]', null])
            ->count();
        return $query;
    }

    public function finalizados()
    {
        $banco = Yii::$app->user->identity->hospital;
        $hoje1 = date('Y-m-d 00:00:00');
        $hoje2 = date('Y-m-d 23:59:59');

        $query = (new Query())
            ->from('{{'.$banco.'}}.{{procedimento}}')
            ->where(['>=', '[[inicio]]', $hoje1])
            ->andWhere(['<=', '[[inicio]]', $hoje2])
            ->andWhere(['is not', '[[fim]]', null])
            ->andWhere(['is', '[[excluido]]', null])
            ->count();
        return $query;
    }

    public function salas()
    {
        $banco = Yii::$app->user->identity->hospital;
        $hoje = date('Y-m-d 00:00:00');
        $agora = Yii::$app->formatter->asDate('now', 'php:Y-m-d H:i:s');

        $dataProvider = new SqlDataProvider([
            'sql' => "
                SELECT
                    [[sala.nome]] as sala,
                    [[procedimento_lt.nome]] as tipo,
                    [[procedimento.inicio]] as inicio,
                    [[procedimento.fimestimado]] as fimestimado,
                    [[situacao.nome]] as situacao
                FROM
                    $banco.{{procedimento}}
                INNER JOIN {{sala}} ON [[sala.id]] = [[procedimento.salaId]]
                INNER JOIN {{procedimento_lt}} ON [[procedimento.nomeId]] =
                    [[procedimento_lt.id]]
                INNER JOIN {{situacao}} ON [[procedimento.situacaoId]] = [[situacao.id]]
                WHERE
                    ([[procedimento.inicio]] BETWEEN :hoje AND :agora) and
                    ([[procedimento.fimestimado]] >=:agora) and
                    ([[procedimento.fim]] is null) and
                    ([[procedimento.excluido]] is null)
                ORDER BY
                    sala asc",
            'params' => [
                ':hoje' => $hoje,
                ':agora' => $agora,
            ],
        ]);
        $salas = $dataProvider;
        return $salas;
    }

    public function participantes()
    {
        $banco = Yii::$app->user->identity->hospital;
        $hoje1 = date('Y-m-d 00:00:00');
        $hoje2 = date('Y-m-d 23:59:59');

        $dataProvider = new SqlDataProvider([
            'sql' => "
                SELECT
                    [[categoria.nome]] as categoria
                    , count([[categoria.id]]) as total
                FROM
                    $banco.{{procedimento}}
                INNER JOIN {{procedimento_profissional}} ON [[procedimento.id]] =
                    [[procedimento_profissional.procedimentoId]]
                INNER JOIN {{profissional}} ON [[procedimento_profissional.profissionalId]] =
                    [[profissional.id]]
                INNER JOIN {{categoria}} ON [[profissional.categoriaId]] = [[categoria.id]]
                WHERE
                    ([[procedimento.inicio]] BETWEEN :hoje1 AND :hoje2) AND
                    ([[procedimento.excluido]] IS null)
                GROUP BY
                    [[categoria.id]]
                HAVING
                    total > 1
                ORDER BY
                    categoria DESC",
            'params' => [
                ':hoje1' => $hoje1,
                ':hoje2' => $hoje2,
            ],
        ]);
        $repetidos = $dataProvider;
        return $repetidos;
    }

    public function repetidos()
    {
        $banco = Yii::$app->user->identity->hospital;
        $hoje1 = date('Y-m-d 00:00:00');
        $hoje2 = date('Y-m-d 23:59:59');

        $dataProvider = new SqlDataProvider([
            'sql' => "
                SELECT
                    [[procedimento_lt.nome]] as tipo
                ,	count([[procedimento_lt.nome]]) as total
                FROM
                    $banco.{{procedimento}}
                INNER JOIN {{procedimento_lt}} ON [[procedimento.nomeId]] =
                    [[procedimento_lt.id]]
                WHERE
                    ([[procedimento.inicio]] BETWEEN :hoje1 AND :hoje2) AND
                    ([[procedimento.excluido]] IS null)
                GROUP BY
                    [[procedimento_lt.nome]]
                HAVING
                    total > 1
                ORDER BY
                    total DESC",
            'params' => [
                ':hoje1' => $hoje1,
                ':hoje2' => $hoje2,
            ],
        ]);
        $repetidos = $dataProvider;
        return $repetidos;
    }

}
