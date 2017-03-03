<?php

class UserController extends AdminDefaultController {

    public $modelName = 'User';
    public $noPages = array('index', 'redirect' => array('admin'));
    public $createRedirect = array('admin');
    public $updateRedirect = array('admin');

    /**
     * actionCreate 
     */
    public function actionCreate() {
        $model = new User;

        $this->_checkAccessLevel($model);

        if (isset($_POST['User'])) {
            $model->attributes = $_POST['User'];

            // Additional check. Only superadmin can create superadmins
            if (User::isSuperAdmin())
                $model->is_superadmin = $_POST['User']['is_superadmin'];
            else
                $model->is_superadmin = 0;


            if ($model->save()) {
                $this->redirect($this->createRedirect);
            }
        }

        $this->render('create', compact('model'));
    }

    /**
     * actionUpdate 
     * 
     * @param int $id 
     */
    public function actionUpdate($id) {
        $model = $this->loadModel($id);

        $this->_checkAccessLevel($model);

        if (isset($_POST['User'])) {
            $model->attributes = $_POST['User'];

            // Additional check. Only superadmin can create superadmins
            if (User::isSuperAdmin()) {
                // Superadmin can't decrease his own access level
                if (Yii::app()->user->id == $id)
                    $model->is_superadmin = 1;
                else
                    $model->is_superadmin = $_POST['User']['is_superadmin'];
            }
            else {
                $model->is_superadmin = 0;
            }

            if ($model->save()) {
                Yii::app()->clientScript->registerScript('goBack', "
                                        history.go(-2);
                                ");
            }
        }

        $this->render('update', compact('model'));
    }

    
    /**
     * actionView 
     * 
     * @param int $id 
     */
    public function actionView($id) {
        $model = $this->loadModel($id);
        $this->_checkAccessLevel($model);
        $this->render('view', compact('model'));
    }

    /**
     * _checkAccessLevel 
     * 
     * Check if accessed user is not superadmin
     * and if he is, than accessor also should be a superadmin
     *
     * @param CActiveRecord $model - User
     *
     * @throw CHttpException 403
     */
    private function _checkAccessLevel($model) {
        if (($model->is_superadmin == 1) AND ! User::isSuperAdmin())
            throw new CHttpException(403, Yii::t("UserAdminModule.front", "You are not authorized to perform this action."));
    }

}
