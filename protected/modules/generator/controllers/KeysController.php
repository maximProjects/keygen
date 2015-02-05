<?php

class KeysController extends Controller
{
	public function actionIndex()
	{
		$this->render('index');
	}

	function generateKey($model)
	{

		$characters = '0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ';
    	$randstring = '';
    	$i=0;
    	while(strlen($randstring) < 19) 
    	{
        	$randstring .= $characters[rand(0, strlen($characters))];
        	if(strlen($randstring)==4||strlen($randstring)==9||strlen($randstring)==14)
        	{
        		$randstring .='-';
        	}
    	}
    	
    	$exist_key = Keys :: model () -> findByAttributes(array('key' =>$randstring));

		/* 
		 check for unique if key exist recursive generate once more
	    */
    	if($exist_key)
    	{
    		generateKey($model);
    		echo "exist <br>";
    	}
    	else
    	{
    		return $randstring;
    	}

	}

	public function actionForm()
	{
	    $model=new Keys;


	    if(isset($_POST['Keys']))
	    {
	    	$arrVendor = array
	    				(
	    					'10' => array
	    							(
	    								'Light Edition' => 'NET02-01LGT0010-00001',
	    								'Standart Edition' => 'NET02-01STD0010-00004',
	    								'Profession Edition' => 'NET02-01STD0010-00007'
	    							),

	    					'50' => array
	    							(
	    								'Light Edition' => 'NET02-01LGT0050-00002',
	    								'Standart Edition' => 'NET02-01STD0010-00005',
	    								'Profession Edition' => 'NET02-01STD0010-00008'
	    							),
	    					'100' => array
	    							(
	    								'Light Edition' => 'NET02-01LGT0100-00003',
	    								'Standart Edition' => 'NET02-01STD0010-00005',
	    								'Profession Edition' => 'NET02-01STD0010-00009'
	    							)
	    				);
	       
	    	$model->attributes=$_POST['Keys'];

	    	$model -> vendor = $arrVendor[$model -> limit_user][$model -> edition]; // select vendor number from array by selected user_limit and edition	

		    for ($x = $model -> limit_user; $x > 0; $x--) // loop to create 1/5/10 keys
		    {

	    		$model -> key = $this -> generateKey($model);    
		        

		        if($model->validate())
		        {

		        	$model -> id = null;
		        	$model-> isNewRecord = true;
			        $model -> save();
	            
		            //return;
		        }
		        else
		        {
		        	$error = true;
		        }
		    }
			if($error)
			{
				$mess = "ERROR";
			}
			else
			{
				$mess = "Generated OK";
			}
			$this->render('form',array('model'=>$model, 'mess' => $mess));		    
	    }
	    else{
	    	$this->render('form',array('model'=>$model,'mess'=>''));	
	    }
	    
	}
}