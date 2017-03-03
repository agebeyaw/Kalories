<!doctype html>
<html>
    <head>
        <?php
        Yii::app()->controller->widget('ext.seo.widgets.SeoHead', array(
            'defaultDescription' => Yii::app()->params['appDescription'],
            'httpEquivs' => array('Content-Type' => 'text/html; charset=utf-8', 'Content-Language' => 'en-US'),
            'title' => array('class' => 'ext.seo.widgets.SeoTitle', 'separator' => ' :: '),
        ));
        ?>
        <link rel="shortcut icon" href="<?php echo Yii::app()->request->baseUrl; ?>/favicon.ico">
        <?php Yii::app()->bootstrap->registerAllCss(); ?>
        <?php Yii::app()->bootstrap->registerCoreScripts(); ?>
        <?php Yii::app()->clientScript->registerCssFile(Yii::app()->request->baseUrl . '/css/styles.css'); ?>
        <!--[if lt IE 9]>
                <script type="text/javascript" src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script>
        <![endif]-->
        <script type="text/javascript">
            /*
             var _gaq = _gaq || [];
             _gaq.push(['_setAccount', 'UA-29040179-1']);
             _gaq.push(['_trackPageview']);
             
             (function () {
             var ga = document.createElement('script');
             ga.type = 'text/javascript';
             ga.async = true;
             ga.src = ('https:' == document.location.protocol ? 'https://ssl' : 'http://www') + '.google-analytics.com/ga.js';
             var s = document.getElementsByTagName('script')[0];
             s.parentNode.insertBefore(ga, s);
             })();
             */
        </script>
    </head>

    <body id="top">

        <?php
        $this->widget('bootstrap.widgets.TbNavbar', array(
            'type' => 'inverse',
            'brand' => CHtml::encode(Yii::app()->name),
            'brandUrl' => Yii::app()->homeUrl,
            'collapse' => true,
            'items' => array(
                array(
                    'class' => 'bootstrap.widgets.TbMenu',
                    'items' => array(
                        array('label' => 'Meals', 'url' => Yii::app()->homeUrl, 'visible' => !Yii::app()->user->isGuest,
                            'active' => Yii::app()->controller->id === 'meals' && Yii::app()->controller->action->id === 'admin'),
                        array('label' => 'Daily Calories Limit', 'url' => array('/dailyGoal/admin'), 'visible' => !Yii::app()->user->isGuest,
                            'active' => Yii::app()->controller->id === '/dailyGoal' && Yii::app()->controller->action->id === 'admin'),
                        array('label' => 'Setup', 'url' => array('/site/setup')),
                    ),
                    'htmlOptions' => array('class' => 'pull-left'),
                ),
                array(
                    'class' => 'bootstrap.widgets.TbMenu',
                    'items' => array(
                        array('label' => "Users", 'url' => array('/UserAdmin/user/admin'), 'visible' => User::isSuperAdmin()),
                        array('label' => "Login", 'url' => array('/UserAdmin/auth/login'), 'visible' => Yii::app()->user->isGuest),
                        array('label' => "Logout", 'url' => array('/UserAdmin/auth/logout'), 'visible' => !Yii::app()->user->isGuest),
                        array('label' => "Registration", 'url' => array('/UserAdmin/auth/registration'), 'visible' => Yii::app()->user->isGuest),
                        array('label' => "Profile", 'url' => array('/UserAdmin/profile/personal'), 'visible' => (!Yii::app()->user->isGuest)),
                    ),
                    'htmlOptions' => array('class' => 'pull-right'),
                ),
            ),
        ));
        ?>

        <div class="container">

            <?php echo $content; ?>

            <hr />

            <footer>

                <div class="row">

                    <div class="span6">

                        <p class="powered">
                            Powered by <?php echo CHtml::link('Yii', 'http://www.yiiframework.com', array('target' => '_blank')); ?> /
                            <?php echo CHtml::link('Yii-Bootstrap', 'http://www.yiiframework.com/extension/bootstrap', array('target' => '_blank')); ?> /
                            <?php echo CHtml::link('Yii-SEO', 'http://www.yiiframework.com/extension/seo', array('target' => '_blank')); ?> /
                            <?php echo CHtml::link('Yii-useradmin', 'http://www.yiiframework.com/extension/useradmin/', array('target' => '_blank')); ?> /                            
                            <?php echo CHtml::link('Bootstrap', 'http://twitter.github.com/bootstrap', array('target' => '_blank')); ?> /
                            <?php echo CHtml::link('jQuery', 'http://www.jquery.com', array('target' => '_blank')); ?> /
                            <?php echo CHtml::link('LESS', 'http://www.lesscss.org', array('target' => '_blank')); ?>
                            Requrements by: <?php echo CHtml::link('MotorK', 'http://www.motork.co.uk/it/', array('target' => '_blank')); ?>
                        </p>

                    </div>

                    <div class="span6">

                        <p class="copy">
                            &copy; Aneteneh Gebeyaw <?php echo date('Y'); ?>
                        </p>

                    </div>

                </div>

            </footer>

        </div>

    </body>
</html>
