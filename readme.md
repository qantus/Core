Installation
------------------

- Download yii-admin or clone the files to `protected/modules/admin`
- Edit Yii main configuration file `protected/config/main.php`. Enable module, set username, password and models you want to manage.

~~~
	'modules'=>array(
		...
		'admin'=>array(
			'username'=>'YOUR USERNAME',
			'password'=>'YOUR PASSWORD',
			'registerModels'=>array(
				//'application.models.Blog', // one model
				'application.models.*', // all models in folder
			),
			'uploadCreate'=>true, // create upload folder automatically
			'redactorUpload'=>true, // enable Redactor image upload
		),
		...
	),
~~~