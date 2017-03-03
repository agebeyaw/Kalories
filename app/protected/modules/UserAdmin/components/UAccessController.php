<?php

class UAccessController extends CController {

    public $freeAccess = false;
    public $freeAccessActions = array();

    public function filters() {
        return array(
            'userAdminControl'
        );
    }

    /**
     * filterUserAdminControl 
     * 
     * @param mixed $filterChain 
     * @return void
     */
    public function filterUserAdminControl($filterChain) {
        // Get login action url
        if (is_array(Yii::app()->user->loginUrl))
            $loginUrl = trim(Yii::app()->user->loginUrl[0], '/');
        else
            $loginUrl = trim(Yii::app()->user->loginUrl, '/');


        $errorAction = trim(Yii::app()->errorHandler->errorAction, '/');


        // If it's not error or login action
        if ((strtolower($this->route) === strtolower($loginUrl)) OR ( strtolower($this->route) === strtolower($errorAction))) {
            $filterChain->run();
        }
        // If this controller or this action if free to access for everyone
        elseif (($this->freeAccess === true) OR ( in_array($this->action->id, $this->freeAccessActions))) {
            $filterChain->run();
        }
        // User is guest
        elseif (Yii::app()->user->isGuest) {
            if ($this->_isRouteAllowed($this->_getGuestAllowedRoutes())) {
                $filterChain->run();
            } else {
                Yii::app()->user->returnUrl = array('/' . $this->route);
                $this->redirect(Yii::app()->user->loginUrl);
            }
        }
        // If user is SuperAdmin
        elseif (User::isSuperAdmin()) {
            $filterChain->run();
        }
        // Check if this user has access to this action
        else {
            if ($this->_isRouteAllowed(array_merge($this->_getAllowedUserRoutes(), $this->_getGuestAllowedRoutes())))
                $filterChain->run();
            else
                throw new CHttpException(403, Yii::t("UserAdminModule.front", "You are not authorized to perform this action."));
        }
    }

}
