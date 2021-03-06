<?php 
class Ecomwise_Creditlimit_Block_Credit_Rules_Edit_Form extends Mage_Adminhtml_Block_Widget_Form
{
	
	public function __construct()
	{
		parent::__construct();
		$this->setId('credit_limit_form');
		$this->setTitle(Mage::helper('ecomwisecredit')->__('Rule Information'));
	}
	
	protected function _prepareForm()
	{
		$form = new Varien_Data_Form(
				array(
						'id' => 'edit_form', 
						'action' => $this->getData('action'), 
						'method' => 'post',
						'enctype' => 'multipart/form-data'
				)
		);
		$form->setUseContainer(true);
		$this->setForm($form);
		return parent::_prepareForm();
	}			 
	
} 