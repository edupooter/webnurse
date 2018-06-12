<?php

namespace app\controllers;

use Yii;
use app\models\Situacao;
use app\models\SituacaoSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\AccessControl;
use yii\filters\VerbFilter;

/**
 * SituacaoController implements the CRUD actions for Situacao model.
 */
class SituacaoController extends Controller
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
     * Lists all Situacao models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new SituacaoSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Situacao model.
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
     * Creates a new Situacao model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Situacao();

        if ($model->load(Yii::$app->request->post()) && $model->save())
        {
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing Situacao model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param string $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save())
        {
            return $this->redirect(['index', 'id' => $model->id]);
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing Situacao model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param string $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
        // $this->findModel($id)->delete();
        //
        // return $this->redirect(['index']);

        $model = $this->findModel($id);

        if($model->delete())
        {
            return $this->redirect(['index']);
        } else {
            throw new \yii\web\ForbiddenHttpException('Esta situação não pode ser excluída, pois é reservada pelo sistema.');
        }
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
     * Finds the Situacao model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param string $id
     * @return Situacao the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Situacao::findOne($id)) !== null)
        {
            return $model;
        }

        throw new NotFoundHttpException('A página procurada não existe.');
    }
}
