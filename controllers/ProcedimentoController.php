<?php

namespace app\controllers;

use Yii;
use app\models\Procedimento;
use app\models\ProcedimentoSearch;
use app\models\ProcedimentoProfissional;
use app\models\ProcedimentoEquipamento;
use app\models\Profissional;
use app\models\Equipamento;
use app\models\Situacao;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\AccessControl;
use yii\filters\VerbFilter;
use yii\helpers\ArrayHelper;

/**
 * ProcedimentoController implements the CRUD actions for Procedimento model.
 */
class ProcedimentoController extends Controller
{
    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'only' => ['index', 'view', 'create', 'update', 'delete'],
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

    /**
     * Lists all Procedimento models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new ProcedimentoSearch();
        // define filtro padrão de início e fim para hoje
        //$searchModel->inicio = date('Y-m-d H:i', \yii::$app->formatter->asTimestamp(('today')));
        //$searchModel->fim = date('Y-m-d H:i', \yii::$app->formatter->asTimestamp(('tomorrow')));

        // Define filtro padrão de início para a data de hoje
        $searchModel->inicio = date('Y-m-d 00:00:00');
        // define filtro padrão de início últimas 12 horas e fim próximas 24 horas
        //$searchModel->inicio = date('Y-m-d H:i', \yii::$app->formatter->asTimestamp(('-12 hour')));
        //$searchModel->fim = date('Y-m-d H:i', \yii::$app->formatter->asTimestamp(('+168 hour')));
        //$searchModel->fimestimado = date('Y-m-d H:i', \yii::$app->formatter->asTimestamp(('+168 hour')));

        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Procedimento model.
     * @param string $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new Procedimento model.
     * If creation is successful, the browser will be redirected to the 'view' page. */
     /* @return mixed
     */
    // public function actionCreate()
    // {
    //     $model = new Procedimento();
    //     if ($model->load(Yii::$app->request->post()) && $model->save()) {
    //         return $this->redirect(['view', 'id' => $model->id]);
    //     } else {
    //         return $this->render('create', [
    //             'model' => $model,
    //         ]);
    //     }
    // }

    public function actionCreate()
    {
        $model = new Procedimento();

        if ($model->load(Yii::$app->request->post()) && $model->save())
        {
            Yii::$app->getSession()->setFlash('success', Yii::t('app', 'Procedimento atualizado.'));
            return $this->redirect(['view', 'id' => $model->id ]);
        } elseif (!\Yii::$app->request->isPost)
        {
            $model->load(Yii::$app->request->get());
            $model->profissionais_ids = ArrayHelper::map($model->profissionais, 'nome', 'nome');
            $model->equipamentos_ids = ArrayHelper::map($model->equipamentos, 'nome', 'nome');
        }
        return $this->render('create', ['model' => $model]);
    }


    /**
     * Updates an existing Procedimento model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param string $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    // public function actionUpdate($id)
    // {
    //     $model = $this->findModel($id);    //
    //     if ($model->load(Yii::$app->request->post()) && $model->save()) {
    //         // return $this->redirect(['view', 'id' => $model->id]);
    //         return $this->redirect(['index', 'id' => $model->id]);
    //     } else {
    //         return $this->render('update', [
    //             'model' => $model,
    //         ]);
    //     }
    // }

    public function actionUpdate($id)
    {
        $model = $this->findModel($id);
        if ($model->load(Yii::$app->request->post()) && $model->save())
        {
            Yii::$app->getSession()->setFlash('success', Yii::t('app', 'Procedimento atualizado.'));
            return $this->redirect(['index', 'id' => $model->id]);
        } elseif (!\Yii::$app->request->isPost)
        {
            $model->load(Yii::$app->request->get());
            $model->profissionais_ids = ArrayHelper::map($model->profissionais, 'id', 'nome');
            $model->equipamentos_ids = ArrayHelper::map($model->equipamentos, 'id', 'nome');
        }
        return $this->render('update', ['model' => $model]);
    }

    /**
     * Deletes an existing Procedimento model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param string $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    public function actionUndelete($id)
    {
        $model = $this->findModel($id);

        if($model->excluido !== null)
        {
            $this->findModel($id)->unDelete();
        }

        return $this->redirect(['index']);
    }

    /**
     * Finds the Procedimento model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param string $id
     * @return Procedimento the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Procedimento::findOne($id)) !== null)
        {
            return $model;
        } else {
            throw new NotFoundHttpException('A página procurada não existe.');
        }
    }

        // public function actionFinalizar($id)
        // {
        //     $this->findModel($id)->delete();
        //
        //     return $this->redirect(['index']);
        // }

}
