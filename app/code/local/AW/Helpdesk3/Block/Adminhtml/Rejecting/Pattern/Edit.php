<?php
/**
 * aheadWorks Co.
 *
 * NOTICE OF LICENSE
 *
 * This source file is subject to the EULA
 * that is bundled with this package in the file LICENSE.txt.
 * It is also available through the world-wide-web at this URL:
 * http://ecommerce.aheadworks.com/AW-LICENSE.txt
 *
 * =================================================================
 *                 MAGENTO EDITION USAGE NOTICE
 * =================================================================
 * This software is designed to work with Magento community edition and
 * its use on an edition other than specified is prohibited. aheadWorks does not
 * provide extension support in case of incorrect edition use.
 * =================================================================
 *
 * @category   AW
 * @package    AW_Helpdesk3
 * @version    3.3.10
 * @copyright  Copyright (c) 2010-2012 aheadWorks Co. (http://www.aheadworks.com)
 * @license    http://ecommerce.aheadworks.com/AW-LICENSE.txt
 */


class AW_Helpdesk3_Block_Adminhtml_Rejecting_Pattern_Edit extends Mage_Adminhtml_Block_Widget_Form_Container
{
    public function __construct()
    {
        $this->_objectId = 'id';
        $this->_blockGroup = 'aw_hdu3';
        $this->_controller = 'adminhtml_rejecting_pattern';
        parent::__construct();
        $this->_formScripts[] = "
            function saveAndContinueEdit(url) {
               editForm.submit(url);
            }
        ";
    }

    public function getHeaderText()
    {
        $title = $this->__('New Rejecting Pattern');
        /** @var AW_Helpdesk3_Model_Gateway_Mail_RejectPattern $pattern */
        $pattern = Mage::registry('current_pattern');
        if (null !== $pattern->getId()) {
            $title = $this->__('Edit Rejecting Pattern "%s"', $pattern->getTitle());
        }
        return $title;
    }

    public function getHeaderCssClass()
    {
        return 'head-' . strtr($this->_controller, '_', '-');
    }

    protected function _prepareLayout()
    {
        $this->_addButton(
            'save_and_continue',
            array(
                'label'   => $this->__('Save and Continue Edit'),
                'onclick' => 'saveAndContinueEdit(\'' . $this->_getSaveAndContinueUrl() . '\')',
                'class'   => 'save'
            ), 10
        );
        parent::_prepareLayout();
    }

    protected function _getSaveAndContinueUrl()
    {
        return $this->getUrl(
            '*/*/save',
            array(
                '_current' => true,
                'continue' => 1,
            )
        );
    }
}