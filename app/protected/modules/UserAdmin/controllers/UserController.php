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

        // Fill roleIds for checkBoxList
        foreach ($model->roles as $role)
            $model->roleIds[] = $role->code;

        if (isset($_POST['User']['roleIds'])) {
            UserHasUserRole::model()->deleteAllByAttributes(array(
                'user_id' => $id,
            ));

            // Reset cache
            UserCache::model()->updateAll(array(
                'status' => 0,
            ));

            if (is_array($_POST['User']['roleIds'])) {
                foreach ($_POST['User']['roleIds'] as $roleId) {
                    $newRole = new UserHasUserRole;
                    $newRole->user_id = $id;
                    $newRole->user_role_code = $roleId;
                    $newRole->save(false);
                }
            }

            Yii::app()->user->setFlash('roleSaved', 'aga');
            $this->redirect(array('view', 'id' => $id));
        }


        // Fill taskIds for checkBoxList
        foreach ($model->tasks as $task)
            $model->taskIds[] = $task->code;

        if (isset($_POST['User']['taskIds'])) {
            UserHasUserTask::model()->deleteAllByAttributes(array(
                'user_id' => $id,
            ));

            // Reset cache
            UserCache::model()->updateAll(array(
                'status' => 0,
            ));

            if (is_array($_POST['User']['taskIds'])) {
                foreach ($_POST['User']['taskIds'] as $taskId) {
                    $newTask = new UserHasUserTask;
                    $newTask->user_id = $id;
                    $newTask->user_task_code = $taskId;
                    $newTask->save(false);
                }
            }

            Yii::app()->user->setFlash('taskSaved', 'aga');
            $this->redirect(array('view', 'id' => $id));
        }

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
