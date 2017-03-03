<?php

class MealsController extends Controller {

    public $defaultAction = 'admin';

    //public $layout='//layouts/column2';

    /**
     * @return array action filters
     */
    public function filters() {
        return array(
            'accessControl', // perform access control for CRUD operations
            'postOnly + delete', // we only allow deletion via POST request
        );
    }

    /**
     * Specifies the access control rules.
     * This method is used by the 'accessControl' filter.
     * @return array access control rules
     */
    public function accessRules() {
        return array(
            array('allow', // allow all users to perform 'index' and 'view' actions
                'actions' => array(),
                'users' => array('*'),
            ),
            array('allow', // allow authenticated user to perform 'create' and 'update' actions
                'actions' => array('create', 'update', 'view', 'admin', 'delete'),
                'users' => array('@'),
            ),
            array('deny', // deny all users
                'users' => array('*'),
            ),
        );
    }

    /**
     * Displays a particular model.
     * @param integer $id the ID of the model to be displayed
     */
    public function actionView($id) {
        $model = $this->loadModel($id);
        if (!User::isSuperAdmin() && ($model->user_id != User::getCurrentUser()->id)) {
            throw new CHttpException(403, 'You are not authorized to perform this action.');
        }
        $this->render('view', array(
            'model' => $model,
        ));
    }

    /**
     * Creates a new model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     */
    public function actionCreate() {
        $model = new Meals;
        $model->date = Date('Y-m-d', time());
        $model->time = Date('H:m:s', time());
        // Uncomment the following line if AJAX validation is needed
        // $this->performAjaxValidation($model);

        if (isset($_POST['Meals'])) {
            $model->attributes = $_POST['Meals'];
            if ($model->save()) {
                Yii::app()->user->setFlash('mealSaved', Yii::t('ui', 'Thank you, Meal Successfully Added!!'));
                $this->redirect(array('admin'));
            }
        }

        $this->render('create', array(
            'model' => $model,
        ));
    }

    /**
     * Updates a particular model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id the ID of the model to be updated
     */
    public function actionUpdate($id) {
        $model = $this->loadModel($id);
        if (!User::isSuperAdmin() && ($model->user_id != User::getCurrentUser()->id)) {
            throw new CHttpException(403, 'You are not authorized to perform this action.');
        }
        // Uncomment the following line if AJAX validation is needed
        // $this->performAjaxValidation($model);

        if (isset($_POST['Meals'])) {
            $model->attributes = $_POST['Meals'];
            if ($model->save()) {
                Yii::app()->user->setFlash('mealSaved', Yii::t('ui', 'Thank you, Meal Successfully Updated!!'));
                $this->redirect(array('admin'));
            }
        }

        $this->render('update', array(
            'model' => $model,
        ));
    }

    /**
     * Deletes a particular model.
     * If deletion is successful, the browser will be redirected to the 'admin' page.
     * @param integer $id the ID of the model to be deleted
     */
    public function actionDelete($id) {
        $model = $this->loadModel($id);
        if (!User::isSuperAdmin() && ($model->user_id != User::getCurrentUser()->id)) {
            throw new CHttpException(403, 'You are not authorized to perform this action.');
        }
        $model->delete();

        // if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
        if (!isset($_GET['ajax']))
            $this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('admin'));
    }

    /**
     * Manages all models.
     */
    public function actionAdmin() {
        if (Yii::app()->user->isGuest) {
            $this->redirect(array('/UserAdmin/auth/login'));
        }
        //unset(Yii::app()->request->cookies['from_date']);
        //unset(Yii::app()->request->cookies['to_date']);

        $model = new Meals('search');
        $model->unsetAttributes();  // clear any default values

        if (isset($_POST['from_date'])) {
            unset(Yii::app()->request->cookies['from_date']);  // first unset cookie for dates
            Yii::app()->request->cookies['from_date'] = new CHttpCookie('from_date', $_POST['from_date']);
            $model->from_date = $_POST['from_date'];
        } else {
            if (isset(Yii::app()->request->cookies['from_date']))
                $model->from_date = Yii::app()->request->cookies['from_date'];
        }

        if (isset($_POST['to_date'])) {
            unset(Yii::app()->request->cookies['to_date']);
            Yii::app()->request->cookies['to_date'] = new CHttpCookie('to_date', $_POST['to_date']);
            $model->to_date = $_POST['to_date'];
        } else {
            if (isset(Yii::app()->request->cookies['to_date']))
                $model->to_date = Yii::app()->request->cookies['to_date'];
        }
        $model->user_id = Yii::app()->user->id; //always for the logged in user


        $this->render('admin', array(
            'model' => $model,
        ));
    }

    /**
     * Returns the data model based on the primary key given in the GET variable.
     * If the data model is not found, an HTTP exception will be raised.
     * @param integer the ID of the model to be loaded
     */
    public function loadModel($id) {
        $model = Meals::model()->findByPk($id);
        if ($model === null)
            throw new CHttpException(404, 'The requested page does not exist.');
        return $model;
    }

    /**
     * Performs the AJAX validation.
     * @param CModel the model to be validated
     */
    protected function performAjaxValidation($model) {
        if (isset($_POST['ajax']) && $_POST['ajax'] === 'meals-form') {
            echo CActiveForm::validate($model);
            Yii::app()->end();
        }
    }

}
