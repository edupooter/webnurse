<?php

namespace app\controllers;

use Yii;
use app\models\Dashboard;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\AccessControl;
use yii\filters\VerbFilter;
use yii\data\ArrayDataProvider;
use yii\helpers\ArrayHelper;
use app\models\ProcedimentoSearch;

class DashboardController extends \yii\web\Controller
{
    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'only' => ['index'],
                'rules' => [
                    [
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                    [
                        'actions' => ['logout'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['POST'],
                ],
            ],
        ];
    }

    public function actionIndex()
    {
        $marcados = Dashboard::marcados();
        // $marcadosLink = Dashboard::marcadosLink();
        $atrasados = Dashboard::atrasados();
        $andamento = Dashboard::andamento();
        $finalizados = Dashboard::finalizados();
        $salas = Dashboard::salas();
        $participantes = Dashboard::participantes();
        $repetidos = Dashboard::repetidos();

        return $this->render('index', [
            'marcados' => $marcados,
            // 'marcadosLink' => $marcadosLink,
            'atrasados' => $atrasados,
            'andamento' => $andamento,
            'finalizados' => $finalizados,
            'salas' => $salas,
            'participantes' => $participantes,
            'repetidos' => $repetidos,
        ]);
    }

}
