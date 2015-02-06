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
    	while(strlen($randstring) < 14) 
    	{
        	$randstring .= $characters[rand(0, strlen($characters))];
        	if(strlen($randstring)==4||strlen($randstring)==9)
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
	    								'Light Edition' => array('code' => 'NET02-01LGT0010-00001', 'name' => 'Light Edition limited to 10 Users'),
	    								'Standart Edition' => array('code' => 'NET02-01STD0010-00004', 'name' => 'Standard Edition limited to 10 Users'),
	    								'Profession Edition' => array('code' => 'NET02-01PRF0010-00007', 'name' => 'Professional Edition limited to 10 Users')
	    							),

	    					'50' => array
	    							(
	    								'Light Edition' => array('code' => 'NET02-01LGT0050-00002', 'name' => 'Light Edition limited to 50 Users'),
	    								'Standart Edition' => array('code' => 'NET02-01STD0050-00005', 'name' => 'Standard Edition limited to 50 Users'),
	    								'Profession Edition' => array('code' => 'NET02-01PRF0050-00008', 'name' => 'Professional Edition limited to 50 Users')
	    							),
	    					'100' => array
	    							(
	    								'Light Edition' => array('code' => 'NET02-01LGT0100-00003', 'name' => 'Light Edition limited to 100 Users'),
	    								'Standart Edition' => array('code' => 'NET02-01STD0100-00006', 'name' => 'Standard Edition limited to 100 Users'),
	    								'Profession Edition' => array('code' => 'NET02-01PRF0100-00009', 'name' => 'Professional Edition limited to 100 Users')
	    							)
	    				);


	    	$model->attributes=$_POST['Keys'];

	    	$model -> vendor = $arrVendor[$model -> limit_user][$model -> edition]['code']; // select vendor number from array by selected user_limit and edition	

	    	$model -> edition = $arrVendor[$model -> limit_user][$model -> edition]['name'];

	        /*
				SINGLE insert 
	        */    
			/*
		    for ($x = 50; $x > 0; $x--) // generates keys array
		    {

				$model -> key = $this -> generateKey($model);
		        if($model->validate())
		        {

		        	$model -> id = null;
		        	$model-> isNewRecord = true;
			        $model -> save();
	            
		        }
		        else
		        {
		        	$error = true;
		        }

		    }
			*/		        
	        /*
				SINGLE insert End
	        */


	        /*
				MULTIPLE insert 
	        */
			
	        if($model->validate())
	        {
	    		$arrKeys = array();
			    for ($x = 50; $x > 0; $x--) // generates keys array
			    {
			    	$arrKeys[] = $this -> generateKey($model); 
			    }

	        	$i=1;
	        	$values='';
	        	foreach($arrKeys as $item)
	        	{
	        		$values .= "('".$item."','".$model -> vendor."',".$model -> limit_user.",'".$model -> edition."')";
	        		if($i != count($arrKeys)){
	        			$values .= ",";
	        		}
	        		$i++;	
	        	}

		    	$sql = "INSERT INTO keys (key, vendor, limit_user, edition) VALUES ".$values;
				$connection = Yii::app()->db;
				$command=$connection->createCommand($sql);
				$command->execute();
	        }
	        else
	        {
	        	$error = true;
	        }
			
	        /*
				MULTIPLE insert End
	        */

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