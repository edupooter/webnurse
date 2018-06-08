<?php

namespace app\controllers;

use Yii;
use app\models\Dashboard;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\AccessControl;
use yii\filters\VerbFilter;
use yii\data\ArrayDataProvider;

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
                'only' => ['index', 'view'],
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

    public function actionView()
    {
        $marcados = Dashboard::marcados();
        $atrasados = Dashboard::atrasados();
        $andamento = Dashboard::andamento();
        $finalizados = Dashboard::finalizados();
        // $repetidos = Dashboard::repetidos();
        // $salas = Dashboard::salas();
        // $participantes = Dashboard::participantes();

        return $this->render('view', [
            'marcados' => $marcados,
            'atrasados' => $atrasados,
            'andamento' => $andamento,
            'finalizados' => $finalizados,
            // 'repetidos' => $repetidos,
            // 'salas' => $salas,
            // 'participantes' => $participantes,
        ]);
    }

}
