<?php

namespace backend\controllers;

use common\models\searchs\QuestionSearch;
use common\models\services\QuestionService;
use DomainException;
use nickdenry\grid\toggle\actions\ToggleAction;
use common\models\Question;
use common\models\forms\QuestionForm;
use Throwable;
use Yii;
use yii\db\StaleObjectException;
use yii\filters\VerbFilter;
use yii\web\Controller;
use yii\web\NotFoundHttpException;

/**
 * QuestionController implements the CRUD actions for Question model.
 */
class QuestionController extends Controller {

    private $service;

    public function __construct($id, $module, QuestionService $service, $config = []) {
        parent::__construct($id, $module, $config);
        $this->service = $service;
    }

    /* @inheritdoc */
    public function behaviors() {
        return [
            'verbs' => [
                'class' => VerbFilter::class,
                'actions' => [
                    'delete' => ['post'],
                ],
            ],
        ];
    }

    public function actions() {
        return [
            'toggle' => [
                'class' => ToggleAction::class,
                'modelClass' => 'common\models\Question',// Your model class
            ],
        ];
    }

    /**
     * Lists all models
     *
     * @return mixed
     */
    public function actionIndex() {
        $searchModel = new QuestionSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single model
     *
     * @param integer $id
     *
     * @return mixed
     * @throws NotFoundHttpException
     */
    public function actionView(int $id) {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     *
     * @return mixed
     */
    public function actionCreate() {
        $modelForm = new QuestionForm();

        if ($modelForm->load(Yii::$app->request->post())) {
            try {
                $model = $this->service->create($modelForm);

                return $this->redirect([
                    'view',
                    'id' => $model->id,
                ]);
            } catch (DomainException $e) {
                Yii::$app->errorHandler->logException($e);
                Yii::$app->session->setFlash('error', $e->getMessage());
            }
        }

        return $this->render('create', [
            'modelForm' => $modelForm,
        ]);
    }

    /**
     * Updates an existing model.
     * If update is successful, the browser will be redirected to the 'view' page.
     *
     * @param integer $id
     *
     * @return mixed
     * @throws NotFoundHttpException
     */
    public function actionUpdate(int $id) {
        $model = $this->findModel($id);
        $modelForm = new QuestionForm($model);

        if ($modelForm->load(Yii::$app->request->post())) {
            try {
                $this->service->edit($modelForm);

                return $this->redirect([
                    'view',
                    'id' => $model->id,
                ]);
            } catch (DomainException $e) {
                Yii::$app->errorHandler->logException($e);
                Yii::$app->session->setFlash('error', $e->getMessage());
            }
        }

        return $this->render('update', [
            'modelForm' => $modelForm,
        ]);
    }

    /**
     * Deletes an existing model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     *
     * @param integer $id
     *
     * @return mixed
     * @throws NotFoundHttpException
     * @throws Throwable
     * @throws StaleObjectException
     */
    public function actionDelete($id) {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     *
     * @param integer $id
     *
     * @return Question the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id) {
        if (($model = Question::findOne($id)) !== null) {
            return $model;
        }
        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
