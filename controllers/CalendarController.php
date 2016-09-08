<?php

namespace app\controllers;

use app\models\CalendarAccess;
use Yii;
use app\models\Calendar;
use app\models\search\CalendarSearch;
use app\models\search\CalendarGuestSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use yii\web\ForbiddenHttpException;

/**
 * CalendarController implements the CRUD actions for Calendar model.
 */
class CalendarController extends Controller
{
    /**
     * @inheritdoc
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
     * Lists all Calendar models.
     * @return mixed
     */
    public function actionIndex()
    {
         $searchOwnerModel = new CalendarSearch();
        $ownerDataProvider = $searchOwnerModel->searchOwner(Yii::$app->request->queryParams);

        $searchGuestModel = new CalendarGuestSearch();
        $guestDataProvider = $searchGuestModel->searchGuest(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchOwnerModel' => $searchOwnerModel,
            'searchGuestModel' => $searchGuestModel,
            'ownerDataProvider' => $ownerDataProvider,
            'guestDataProvider' => $guestDataProvider
        ]);
    }

    /**
     * Displays a single Calendar model.
     * @param integer $id
     * @return mixed
     * @throws \yii\web\ForbiddenHttpException
     */
    public function actionView($id)
    {
        $model = $this->findModel($id);


        switch (CalendarAccess::checkAccess($model)) {
            case CalendarAccess::ACCESS_CREATOR:
                $view = 'viewOwner';
                break;
            case CalendarAccess::ACCESS_GUEST:
                $view = 'viewGuest';
                break;
            case CalendarAccess::ACCESS_FORBIDDEN:
            default:
                throw new ForbiddenHttpException("Not allowed!");
        }

        return $this->render($view, [
            'model' => $model,
        ]);
    }

    /**
     * Creates a new Calendar model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Calendar();
        $model->creator = Yii::$app->user->id;

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            return $this->render('create', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Updates an existing Calendar model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws \yii\web\ForbiddenHttpException
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if (CalendarAccess::checkAccess($model) !== CalendarAccess::ACCESS_CREATOR) {
            throw new ForbiddenHttpException("Not allowed!");
        }

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            return $this->render('update', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Deletes an existing Calendar model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     * @throws \yii\web\ForbiddenHttpException
     */
    public function actionDelete($id)
    {
        $model = $this->findModel($id);

        if (CalendarAccess::checkAccess($model) !== CalendarAccess::ACCESS_CREATOR) {
            throw new ForbiddenHttpException("Not allowed!");
        }

        $model->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the Calendar model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Calendar the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Calendar::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
