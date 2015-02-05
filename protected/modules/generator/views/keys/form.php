<?php
/* @var $this KeysController */
/* @var $model Keys */
/* @var $form CActiveForm */
?>
<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'keys-form-form',
	// Please note: When you enable ajax validation, make sure the corresponding
	// controller action is handling ajax validation correctly.
	// See class documentation of CActiveForm for details on this,
	// you need to use the performAjaxValidation()-method described there.
	'enableAjaxValidation'=>false,
)); ?>

	<p class="note">Fields with <span class="required">*</span> are required.</p>

	<?php echo $form->errorSummary($model); ?>
	<?php
	/*

		$array = array('0' => 'User', '1' => 'Admin');

		<?php echo $form->dropDownList($model,'naam',$array); ?>
	*/
	?>
	<?= $mess ?>
	<div class="row">
		<?php echo $form->labelEx($model,'limit_user'); ?>
		<?php echo $form->dropDownList($model,'limit_user', array(10 => '10 Users', 50 => '50 Users', 100 => '100 Users')); ?>
		<?php echo $form->error($model,'limit_user'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'edition'); ?>
		<?php echo $form->dropDownList($model,'edition', array('Light Edition' => 'Light Edition', 'Standart Edition' => 'Standart Edition', 'Profession Edition' => 'Profession Edition')); ?>
		<?php echo $form->error($model,'edition'); ?>
	</div>

	<div class="row buttons">
		<?php echo CHtml::submitButton('Submit'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->