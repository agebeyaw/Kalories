# Kalories
Kalories is an Personal Calories Management Application that provides range of server-side widgets that allow you to easily use Bootstrap with Yii Framework

User can see a list of his meals and calories.
Calories are entered manually.
Each entry could be edited and deleted.
An entry has the following fields:
- date
- time
- text
- number of calories

User can filter date (from-to).
For example: how much calories have I had in the last week?
User can set the expected number of calories per day in a settings panel.
When displayed, the total for that day is colored in green, otherwise it is red.

## How to install

Unzip the project to your server web-root directory and modify the file **app/protected/config/main.php** to configure connection to your database:

~~~
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
~~~

For MySQL, use the file **app/protected/data/Kalories-mysql.sql** to create the required tables.

You're done! Now you can start the application by navigating to: [http://localhost/app/](http://localhost/app/).

Login **user1/user1**, **user2/user2** or by registering as a new user.

Administrator user is: **admin/admin**
