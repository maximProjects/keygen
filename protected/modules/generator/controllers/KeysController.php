<?php

class KeysController extends Controller
{
	public function actionIndex()
	{
		$this->render('index');
	}

	function generateKey()
	{
		$characters = '0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ';
    	$randstring = '';
    	$i=0;
    	while(strlen($randstring) < 24) 
    	{
        	$randstring .= $characters[rand(0, strlen($characters))];
        	if(strlen($randstring)==5||strlen($randstring)==11||strlen($randstring)==17)
        	{
        		$randstring .='-';
        	}
    	}
    	return $randstring;
	}

	public function actionForm()
	{
	    $model=new Keys;

	    // uncomment the following code to enable ajax-based validation
	    /*
	    if(isset($_POST['ajax']) && $_POST['ajax']==='keys-form-form')
	    {
	        echo CActiveForm::validate($model);
	        Yii::app()->end();
	    }
	    */

	    if(isset($_POST['Keys']))
	    {
	    	$model->attributes=$_POST['Keys'];
	    	$model -> key = $this -> generateKey();
	       
	        if($model->validate())
	        {

	        	$model -> save();
	            
	            //return;
	        }
	    }
	    $this->render('form',array('model'=>$model));
	}

	// Uncomment the following methods and override them if needed
	/*
	public function filters()
	{
		// return the filter configuration for this controller, e.g.:
		return array(
			'inlineFilterName',
			array(
				'class'=>'path.to.FilterClass',
				'propertyName'=>'propertyValue',
			),
		);
	}

	public function actions()
	{
		// return external action classes, e.g.:
		return array(
			'action1'=>'path.to.ActionClass',
			'action2'=>array(
				'class'=>'path.to.AnotherActionClass',
				'propertyName'=>'propertyValue',
			),
		);
	}
	*/
}