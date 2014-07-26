<?php
class Magentothem_Allbrands_Block_Allbrands extends Mage_Catalog_Block_Product_Abstract
{
	public function _prepareLayout()
    {
		return parent::_prepareLayout();
    }
    
     public function getAllbrands2()     
     { 
        if (!$this->hasData('allbrands')) {
            $this->setData('allbrands', Mage::registry('allbrands'));
        }
        return $this->getData('allbrands');
    }
	public function getBestSeller()
    {
    	$storeId    = Mage::app()->getStore()->getId();
    	$products = Mage::getResourceModel('reports/product_collection')
    		->addOrderedQty()
            ->addAttributeToSelect('*')
			->addMinimalPrice()
			->addUrlRewrite()
			->addTaxPercents()
            ->addAttributeToSelect(array('name', 'price', 'small_image'))
            ->setStoreId($storeId)
            ->addStoreFilter($storeId)
            ->setOrder('ordered_qty', 'desc');		
        Mage::getSingleton('catalog/product_status')->addVisibleFilterToCollection($products);
        Mage::getSingleton('catalog/product_visibility')->addVisibleInCatalogFilterToCollection($products);
        $products->setPageSize($this->getConfig('qty'))->setCurPage(1);
        $this->setProductCollection($products);
    }
	public function getOnsale()
    {
		$todayDate  = Mage::app()->getLocale()->date()->toString(Varien_Date::DATETIME_INTERNAL_FORMAT);
    	$storeId    = Mage::app()->getStore()->getId();
		$products = Mage::getResourceModel('catalog/product_collection')
			->addAttributeToSelect(Mage::getSingleton('catalog/config')->getProductAttributes())
			->addMinimalPrice()
			->addUrlRewrite()
			->addTaxPercents()			
			->addStoreFilter()
			->addAttributeToFilter('special_to_date', array('date'=>true, 'from'=> $todayDate));
        Mage::getSingleton('catalog/product_status')->addVisibleFilterToCollection($products);
        Mage::getSingleton('catalog/product_visibility')->addVisibleInCatalogFilterToCollection($products);
        $products->setPageSize($this->getConfig('qty'))->setCurPage(1);
        $this->setProductCollection($products);
    }
	public function getNew()
    {
		$todayDate  = Mage::app()->getLocale()->date()->toString(Varien_Date::DATETIME_INTERNAL_FORMAT);
    	$storeId    = Mage::app()->getStore()->getId();
		$products = Mage::getResourceModel('catalog/product_collection')
			->addAttributeToSelect(Mage::getSingleton('catalog/config')->getProductAttributes())
			->addMinimalPrice()
			->addUrlRewrite()
			->addTaxPercents()			
			->addStoreFilter()
			->addAttributeToFilter('news_from_date', array('date'=>true, 'to'=> $todayDate))
			->addAttributeToFilter(array(array('attribute'=>'news_to_date', 'date'=>true, 'from'=>$todayDate), array('attribute'=>'news_to_date', 'is' => new Zend_Db_Expr('null'))),'','left')
			->addAttributeToSort('news_from_date','desc');		
        Mage::getSingleton('catalog/product_status')->addVisibleFilterToCollection($products);
        Mage::getSingleton('catalog/product_visibility')->addVisibleInCatalogFilterToCollection($products);
        $products->setPageSize($this->getConfig('qty'))->setCurPage(1);
        $this->setProductCollection($products);
    }
	public function getMostviewed()
    {
    	$storeId    = Mage::app()->getStore()->getId();
		$products = Mage::getResourceModel('reports/product_collection')
            ->addAttributeToSelect('*')
			->addMinimalPrice()
			->addUrlRewrite()
			->addTaxPercents()			
            ->addAttributeToSelect(array('name', 'price', 'small_image')) //edit to suit tastes
            ->setStoreId($storeId)
            ->addStoreFilter($storeId)
            ->addViewsCount()
            ;			
        Mage::getSingleton('catalog/product_status')->addVisibleFilterToCollection($products);
        Mage::getSingleton('catalog/product_visibility')->addVisibleInCatalogFilterToCollection($products);
        $products->setPageSize($this->getConfig('qty'))->setCurPage(1);
        $this->setProductCollection($products);
    }
	public function getLastest($fieldorder = 'updated_at', $order = 'desc')
    {
    	$storeId    = Mage::app()->getStore()->getId();
		$products = Mage::getResourceModel('catalog/product_collection')
			->addAttributeToSelect(Mage::getSingleton('catalog/config')->getProductAttributes())
			->addMinimalPrice()
			->addUrlRewrite()
			->addTaxPercents()			
			->addStoreFilter()
			->setOrder ($fieldorder,$order);
		Mage::getSingleton('catalog/product_status')->addVisibleFilterToCollection($products);
		Mage::getSingleton('catalog/product_visibility')->addVisibleInCatalogFilterToCollection($products);
        $products->setPageSize($this->getConfig('qty'))->setCurPage(1);
        $this->setProductCollection($products);
    }
	public function getFeatured()
    {
    	$storeId    = Mage::app()->getStore()->getId();
		$products = Mage::getResourceModel('catalog/product_collection')
			->addAttributeToSelect(Mage::getSingleton('catalog/config')->getProductAttributes())
			->addMinimalPrice()
			->addUrlRewrite()
			->addTaxPercents()			
			->addStoreFilter()
			->addAttributeToFilter("featured", 1);		
        Mage::getSingleton('catalog/product_status')->addVisibleFilterToCollection($products);
        Mage::getSingleton('catalog/product_visibility')->addVisibleInCatalogFilterToCollection($products);
        $products->setPageSize($this->getConfig('qty'))->setCurPage(1);
        $this->setProductCollection($products);
    }
	public function getCatBrands($catId = 4)
    {
    	//$collection = Mage::getModel('catalog/product')
//        ->getCollection()
//		 ->joinTable('catalog_category_product', 'product_id=entity_id', array('category_id'=>'category_id'), null, 'left')
//		//->joinField('category_id', 'catalog/category_product', 'category_id', 'product_id = entity_id', null, 'left')
//		->addAttributeToFilter('category_id', array('in' => array('finset' => '166,4')))
//		->addAttributeToSelect('name');
		// ->setPageSize(5)
		
	//	$collection = Mage::getResourceModel('reports/product_collection')
//   ->addAttributeToSelect('name')
//   ->addAttributeToFilter('category_ids',array('finset'=>'166,4'));

//$collection = Mage::getModel('catalog/product')
// ->getCollection()
// ->joinField('category_id', 'catalog/category_product', 'category_id', 'product_id = entity_id', null, 'left')
// ->addAttributeToSelect('*')
// ->addAttributeToFilter('category_id', array(
//     array('finset' => '166'),
//     array('finset' => '4'))
// )
// ->addAttributeToSort('created_at', 'desc');
		
		
//		$product = Mage::getModel('catalog/product');
//$collection = $product->getCollection()
//  ->addAttributeToSelect('*')
//  ->addAttributeToFilter('status',1)
//  
//->addStoreFilter();
  
  
  
 //  $categories = array(166,4);
//    $collection = mage::getModel('catalog/product')->getCollection()
//        ->addAttributeToSelect('*')
//        ->joinField('category_id',
//            'catalog/category_product',
//            'category_id',
//            'product_id=entity_id',
//            null,
//            'left')
//        ->addAttributeToFilter('category_id', array('in' => $categories));
//    $collection->getSelect()->group('e.entity_id');
	
	
	$collection = mage::getModel('catalog/product')->getCollection()
        ->addAttributeToSelect('*')
	->joinField('category_id_1', 'catalog/category_product', 'category_id', 'product_id=entity_id', null, 'left')
    ->joinField('category_id_2', 'catalog/category_product', 'category_id', 'product_id=entity_id', null, 'left')
    ->addAttributeToFilter('category_id_1', array('eq' => 166))
    ->addAttributeToFilter('category_id_2', array('eq' => 4));
	 $collection->getSelect()->group('e.entity_id');
		//return count($collection);
		return $collection;
    }
	public function getAllSubcat($catId = 166)
    {
		$i = 0; $brandOut = array(); $imgOut = array(); $urlOut = array(); $dataOut = array();
		
		$cat = Mage::getModel('catalog/category')->load($catId);
		$subcats = $cat->getChildren();
		$media_url = Mage::getBaseUrl(Mage_Core_Model_Store::URL_TYPE_MEDIA);
		foreach(explode(',',$subcats) as $subCatid)
		{
			$brand = Mage::getModel('catalog/category')->load($subCatid);
			$dataOut[$i][0] = ucfirst($brand->getName());
			//$dataOut[$i][1] = $brand->getImageUrl();
			//$dataOut[$i][1] = $brand->getThumbnail();
			$dataOut[$i][1] = $media_url.'catalog/category/'.$brand->getThumbnail();
			$dataOut[$i][2] = $brand->getUrl();
			$dataOut[$i][3] = $brand->getId();
			$i++;
		}

		return $dataOut;
    }
	public function test() 
	{
		return "test passed";
	}
}