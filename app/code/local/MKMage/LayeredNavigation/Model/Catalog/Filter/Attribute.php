<?php
class MKMage_LayeredNavigation_Model_Catalog_Filter_Attribute extends Mage_Catalog_Model_Layer_Filter_Attribute
{
	protected $_appliedValues = array();
	protected $_optionValues = array();
	
	public function apply(Zend_Controller_Request_Abstract $request, $filterBlock) {
		$filter = $request->getParam($this->_requestVar);
		
		if (is_array($filter)) {
			return $this;
		}
		
		$optionValues = array();
		
		$text = $this->_getOptionText($filter);
		
		$options = explode('_', $filter);
		
		foreach ($options as $opt) {
			$optionValues[$opt] = $this->_getOptionText($opt);
		}
		
		$this->_optionValues = $optionValues;
		
		//if ($filter && strlen($text)) {		// comment this to allow apply multi value for filter
		if ($filter) {
		    if(!strlen($text)){
                $values = explode('_', $filter);
                foreach($values as $key => $val){
                    if(!$this->_getOptionText($val)){
                        unset($values[$key]);
                    }
                }
                $filter = implode('_', $values);
            } else {
                $values = $filter;
            }

		    if(count($values) == 0)
		        return $this;

			$this->_appliedValues = $values;
			//var_dump($this->_appliedValues); die;
			$this->_getResource()->applyFilterToCollection($this, $filter);
			$this->getLayer()->getState()->addFilter($this->_createItem($text, $filter));
			//$this->_items = array();	// prevent filter from hiding when apply to collection
		}
		return $this;
	}
	
	public function getFilterOptionValues() {
		return $this->_optionValues;
	}
	
	public function getFIlterAppliedValues() {
		return $this->_appliedValues;
	}
	
	protected function _getItemsData() {
		$attribute         = $this->getAttributeModel();
		$this->_requestVar = $attribute->getAttributeCode();
		
		$key  = $this->getLayer()->getStateKey() . '_' . $this->_requestVar;
		$data = $this->getLayer()->getAggregator()->getCacheData($key);
		
		if ($data === null) {
			$options      = $attribute->getFrontend()->getSelectOptions();
			$optionsCount = $this->_getResource()->getCount($this);
			$data         = array();
			foreach ($options as $option) {
				if (is_array($option['value'])) {
					continue;
				}
				if (Mage::helper('core/string')->strlen($option['value'])) {
					// Check filter type
					if ($this->_getIsFilterableAttribute($attribute) == self::OPTIONS_ONLY_WITH_RESULTS) {
						// keep applied options in filter
						if (!empty($optionsCount[$option['value']]) || in_array($option['value'], $this->_appliedValues)) {
							$data[] = array(
								'label' => $option['label'],
								'value' => $option['value'],
								'count' => isset($optionsCount[$option['value']]) ? $optionsCount[$option['value']] : 0		// product count fix
							);
						}
					} else {
						$data[] = array(
							'label' => $option['label'],
							'value' => $option['value'],
							'count' => isset($optionsCount[$option['value']]) ? $optionsCount[$option['value']] : 0
						);
					}
				}
			}
			
			$tags = array(
				Mage_Eav_Model_Entity_Attribute::CACHE_TAG . ':' . $attribute->getId()
			);
			
			$tags = $this->getLayer()->getStateTags($tags);
			$this->getLayer()->getAggregator()->saveCacheData($data, $key, $tags);
		}
		return $data;
	}
	
}
