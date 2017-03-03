<?php
$this->pageTitle = array('Setup', Yii::app()->params['appTitle']);
?>

<h2>Setup</h2>

<p>Download Kalories application from github:</p>

<p>
    <?php
    $this->widget('bootstrap.widgets.TbButton', array(
        'type' => 'primary',
        'size' => 'medium',
        'icon' => 'download-alt white',
        'label' => 'Download CaloriesK',
        'url' => 'http://www.yiiframework.com/extension/bootstrap/',
        'htmlOptions' => array('target' => '_blank'),
    ));
    ?>
</p>

<p>Unzip the project to your server web-root directory and modify the file <strong>app/protected/config/main.php</strong> to configure connection to your database:</p>
<p>For MySQL, use the file <strong>app/protected/data/Kalories-mysql.sql</strong> to create the required tables.</p>

<?php echo $parser->safeTransform("~~~
[php]
// Set the path of Bootstrap to be the root of the project.
Yii::setPathOfAlias('bootstrap', realpath(__DIR__ . '/../../../'));

return array(
    'basePath' => realpath(__DIR__ . '/..'),
    'name' => 'Kalories',
    'defaultController' => 'meals',
    ...
    'components' => array(
        ...        
        'db' => array(
            'connectionString' => 'mysql:host=localhost;dbname=kalories',
            'emulatePrepare' => true,
            'username' => 'root',
            'password' => '',
            'charset' => 'utf8',
        ),
    ),
    ...
);
~~~"); ?>

<p>

    You're done! Now you can start the application by navigating to: 
    <?php echo CHtml::link('http://localhost/app/', 'http://localhost/app/'); ?>.
    <br/><br/>Login as <strong>user1/user1</strong> or <strong>user2/user2</strong> 
    <br/>Administrator user is: <strong>admin/admin</strong>
</p>

