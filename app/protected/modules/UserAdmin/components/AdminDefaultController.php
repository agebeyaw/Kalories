<?php

class AdminDefaultController extends Controller {

    public $layout = '//layouts/main';
    public $modelName;
    public $ajaxValidation = false;
    public $freeAccess = false;
    public $freeAccessActions = array();
    // You can copy it in inherited controller, to choose, which actions will be moderated
    //public $moderatedActions = array('index', 'view', 'create', 'update', 'admin', 'delete', 'deleteSelected', 'toggleState', 'sorterUpdate');

    public $noPages = array();
    public $createRedirect = array();
    public $updateRedirect = 'goBack';

    public function actionView($id) {
        if (in_array('view', $this->noPages))
            $this->redirect($this->noPages['redirect']);

        $this->render('view', array(
            'model' => $this->loadModel($id),
        ));
    }

    public function actionCreate() {
        if (in_array('create', $this->noPages))
            $this->redirect($this->noPages['redirect']);

        $model = new $this->modelName;

        if ($this->ajaxValidation)
            $this->performAjaxValidation($model);

        if (isset($_POST[$this->modelName])) {
            $model->attributes = $_POST[$this->modelName];
            if ($model->save()) {
                if ($this->createRedirect)
                    $this->redirect($this->createRedirect);
                else
                    $this->redirect(array('view', 'id' => $model->id));
            }
        }

        $this->render('create', array(
            'model' => $model,
        ));
    }

    public function actionUpdate($id) {
        if (in_array('update', $this->noPages))
            $this->redirect($this->noPages['redirect']);

        $model = $this->loadModel($id);

        if ($this->updateRedirect AND ( $this->updateRedirect == 'goBack')) {
            if (!Yii::app()->user->hasFlash('_updateGoBack') AND ( isset($_SERVER['HTTP_REFERER'])))
                Yii::app()->user->setFlash('_updateGoBack', $_SERVER['HTTP_REFERER']);
            elseif (Yii::app()->user->hasFlash('_updateGoBack'))
                Yii::app()->user->setFlash('_updateGoBack', Yii::app()->user->getFlash('_updateGoBack'));
        }

        if ($this->ajaxValidation)
            $this->performAjaxValidation($model);

        if (isset($_POST[$this->modelName])) {
            $model->attributes = $_POST[$this->modelName];
            if ($model->save()) {
                $redirect = Yii::app()->user->getFlash('_updateGoBack');
                if (strpos($redirect, $this->route) !== false)
                    $redirect = array('admin');

                if ($this->updateRedirect AND $redirect)
                    $this->redirect($redirect);
                else
                    $this->redirect(array('view', 'id' => $model->id));
            }
        }

        $this->render('update', array(
            'model' => $model,
        ));
    }

    public function actionIndex() {
        if (in_array('index', $this->noPages))
            $this->redirect($this->noPages['redirect']);

        $dataProvider = new CActiveDataProvider($this->modelName);

        $this->render('index', array(
            'dataProvider' => $dataProvider,
        ));
    }

    public function actionAdmin() {
        if (in_array('admin', $this->noPages))
            $this->redirect($this->noPages['redirect']);

        if (isset($_GET['pageSize'])) {
            Yii::app()->user->setState('pageSize', (int) $_GET['pageSize']);
            unset($_GET['pageSize']);
        }

        $model = new $this->modelName('search');
        $model->unsetAttributes();
        if (isset($_GET[$this->modelName]))
            $model->attributes = $_GET[$this->modelName];

        $this->render('admin', array(
            'model' => $model,
        ));
    }

    public function actionDelete($id) {
        if (Yii::app()->request->isPostRequest) {
            $this->loadModel($id)->delete();

            if (!isset($_GET['ajax']))
                $this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('admin'));
        } else
            throw new CHttpException(400, 'Invalid request. Please do not repeat this request again.');
    }

    /**
     * loadModel 
     * 
     * @param int $id 
     * @param string $scope 
     * @param string $with 
     *
     * @return CActiveRecord
     */
    public function loadModel($id, $scope = null, $with = null) {
        $modelName = $this->modelName;

        if ($scope and ! $with) {
            $model = $modelName::model()->$scope()->findByPk((int) $id);
        } elseif ($with and ! $scope) {
            $model = $modelName::model()->with($with)->findByPk((int) $id);
        } elseif ($with and $scope) {
            $model = $modelName::model()->$scope()->with($with)->findByPk((int) $id);
        } else {
            $model = $modelName::model()->findByPk((int) $id);
        }

        if ($model === null)
            throw new CHttpException(404, Yii::t("yii", 'The requested page does not exist.'));
        return $model;
    }

    /**
     * For toggler in CGridView 
     * 
     * @param int $id 
     * @param string $attribute 
     * @param string $value 
     */
    public function actionToggleState($id, $attribute, $value) {
        $model = $this->loadModel($id);
        $model->{$attribute} = $value;
        $model->save(false);
    }

    /**
     * For grid checkbox "Delete selected" 
     */
    public function actionDeleteSelected() {
        if (!isset($_POST['autoId']) OR count($_POST['autoId']) == 0)
            return;

        $autoIdAll = $_POST['autoId'];
        foreach ($autoIdAll as $autoId)
            $model = $this->loadModel($autoId)->delete();
    }

    /**
     * For grid update sorter (order) 
     */
    public function actionSorterUpdate() {
        if (!isset($_POST['sortOrder']) OR ( count($_POST['sortOrder']) == 0))
            return;

        $sortOrderAll = $_POST['sortOrder'];
        foreach ($sortOrderAll as $menuId => $sortOrder) {
            $model = $this->loadModel($menuId);
            $model->sorter = $sortOrder;
            $model->save(false);
        }
    }

    protected function performAjaxValidation($model) {
        if (isset($_POST['ajax']) && $_POST['ajax'] === '' . strtolower($this->modelName) . '-form') {
            echo CActiveForm::validate($model);
            Yii::app()->end();
        }
    }

}
