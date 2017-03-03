<?php

class ProfileController extends Controller {

    public $freeAccess = true;

    /**
     * actionPersonal 
     * 
     * Personal profile page.
     *
     * @return void
     */
    public function actionPersonal() {
        if (Yii::app()->user->isGuest)
            throw new CHttpException(403, Yii::t("UserAdminModule.front", "You are not authorized to perform this action."));

        $user = User::model()->active()->findByPk((int) Yii::app()->user->id);

        if (!$user)
            throw new CHttpException(403, Yii::t("UserAdminModule.front", "You are not authorized to perform this action."));


        //=========== Here you can implement some logic (like changing password) ===========
        //----------------------------------------------------------------------------------

        if (isset($_POST['User'])) {
            $user->attributes = $_POST['User'];

            // Additional check. Only superadmin can create superadmins
            if (User::isSuperAdmin()) {
                // Superadmin can't decrease his own access level
                if (Yii::app()->user->id == $id)
                    $user->is_superadmin = 1;
                else
                    $user->is_superadmin = $_POST['User']['is_superadmin'];
            }
            else {
                $user->is_superadmin = 0;
            }

            if ($user->save()) {
                Yii::app()->user->setFlash('profileSaved', Yii::t('ui', 'Profile updated!!'));
                $this->refresh();
            }
        }
        $this->render('personal', compact('user'));
    }

}
