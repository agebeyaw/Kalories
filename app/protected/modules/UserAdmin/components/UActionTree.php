<?php

class UActionTree {

    /**
     * getControllerActions 
     *
     * @return string $path - path to the controllers folder
     * @return string $moduleId - name of the module (or NULL if we call for general controllers)
     * @return array
     */
    public static function getControllersActions($path, $moduleId = null) {
        $controllers = self::getControllers($path);

        $result = array();
        foreach ($controllers as $controller) {
            $result = array_merge($result, self::getActions($controller, $moduleId));
        }

        return $result;
    }

    /**
     * getModuleControllersActions 
     * 
     * @return array
     */
    public static function getModuleControllersActions() {
        $result = array();
        foreach (Yii::app()->getModules() as $module) {
            if (($module['class'] == 'system.gii.GiiModule') OR ( $module['class'] == 'Yii2DebugModule'))
                continue;

            $tmp = explode('.', $module['class']);
            $moduleId = $tmp[0];

            $result = array_merge($result, self::getControllersActions(Yii::app()->getModule($moduleId)->controllerPath, $moduleId));
        }

        return $result;
    }

    /**
     * getControllers 
     * 
     * @param string $path
     * @return array
     */
    public static function getControllers($path) {
        return glob($path . '/*Controller.php');
    }

    /**
     * getActions 
     *
     * Return array of actions for given controller
     * 
     * @param string $controllerFullPath 
     * @return string $moduleId - name of the module (or NULL if we call for general controllers)
     * @return array
     */
    public static function getActions($controllerFullPath, $moduleId) {
        $explodedPath = explode('/', str_replace('.php', '', $controllerFullPath));
        $controllerName = end($explodedPath);

        //=========== Extracted from the dark heart of the "Rights" module ===========
        $fileActions = array();
        $file = fopen($controllerFullPath, 'r');

        while (feof($file) === false) {
            $line = fgets($file);

            preg_match('/public[ \t]+function[ \t]+action([A-Z]{1}[a-zA-Z0-9]+)[ \t]*\(/', $line, $function);
            preg_match('/public[ \t]+[\$]moderatedActions[ \t]+=[ \t]+array\({1}([a-zA-Z0-9, "\']+)\){1}/', $line, $moderatedActions);

            if ($moderatedActions !== array()) {
                $moderatedActions = explode(',', $moderatedActions[1]);

                foreach ($moderatedActions as $mAction) {
                    $mAction = trim($mAction);
                    $mAction = trim($mAction, '"');
                    $mAction = trim($mAction, "'");
                    $ma[] = ucfirst(strtolower($mAction));
                }

                $fileActions = array_merge($fileActions, $ma);
            }

            if ($function !== array()) {
                $fileActions[] = $function[1];
            }
        }
        //----------- Extracted from the dark heart of the "Rights" module -----------
        // Name of the controller without "Controller" (e.g. "SiteController" ====> "site")
        $controllerCuteName = lcfirst(substr($controllerName, 0, -10));

        $actions = array();
        // Add route + wilcard (e.g site/* or module/controller)
        if ($moduleId)
            $actions[] = $moduleId . '/' . $controllerCuteName . '/*';
        else
            $actions[] = $controllerCuteName . '/*';

        foreach ($fileActions as $action) {
            if ($moduleId)
                $actions[] = $moduleId . '/' . $controllerCuteName . '/' . lcfirst($action);
            else
                $actions[] = $controllerCuteName . '/' . lcfirst($action);
        }

        $actions = array_unique($actions);

        return $actions;
    }

}
