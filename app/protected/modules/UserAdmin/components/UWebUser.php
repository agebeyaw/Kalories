<?php

class UWebUser extends CWebUser {

    /**
     * afterLogin 
     */
    protected function afterLogin($fromCookie) {
        parent::afterLogin($fromCookie);

        $this->_updateUserState();
    }

    /**
     * _updateUserState 
     */
    private function _updateUserState() {
        $user = User::model()->active()->findByPk((int) $this->id);

        if ($user) {
            $this->name = $user->login;

            // If it's SuperAdmin
            if ($user->is_superadmin == 1)
                $this->setState('isSuperAdmin', true);
        }
    }

}
