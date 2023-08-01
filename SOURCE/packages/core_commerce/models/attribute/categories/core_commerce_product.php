<?php 
defined('C5_EXECUTE') or die(_("Access Denied."));
/**
 * An object that represents metadata added to products. They key object maps to the "type"
 * of metadata added to pages.
 * @author Andrew Embler <andrew@concrete5.org>
 * @package Pages
 * @category Concrete
 * @copyright  Copyright (c) 2003-2008 Concrete5. (http://www.concrete5.org)
 * @license    http://www.concrete5.org/license/     MIT License
 *
 */
class CoreCommerceProductAttributeKey extends AttributeKey {

	public function getIndexedSearchTable() {
		return 'CoreCommerceProductSearchIndexAttributes';
	}

	protected $searchIndexFieldDefinition = 'productID I(11) UNSIGNED NOTNULL DEFAULT 0 PRIMARY';

	public function sortListByDisplayOrder($a, $b) {
		if ($a->getAttributeKeyDisplayOrder() == $b->getAttributeKeyDisplayOrder()) {
			if ($a->getAttributeKeyDisplayOrder() == 0) {
				return ($a->getAttributeKeyID() < $b->getAttributeKeyID()) ? -1 : 1;
			} else {
				return 0;
			}
		} else {
			return ($a->getAttributeKeyDisplayOrder() < $b->getAttributeKeyDisplayOrder()) ? -1 : 1;
		}
	}
	
	public function getAttributeKeyDisplayOrder() {return $this->displayOrder;}
	
	public static function updateAttributesDisplayOrder($uats) {
		$db = Loader::db();
		for ($i = 0; $i < count($uats); $i++) {
			$v = array($uats[$i]);
			$db->Replace('CoreCommerceProductAttributeKeys', array('displayOrder' => $i, 'akID' => $uats[$i]), array('akID'));
		}
	}

	public function load($akID) {
		parent::load($akID);
		$db = Loader::db();
		$row = @$db->GetRow("select displayOrder from CoreCommerceProductAttributeKeys where akID = ?", array($akID));
		if (is_array($row)) {
			$this->setPropertiesFromArray($row);
		}
	}
	
	public function getAttributes($productID, $method = 'getValue') {
		$db = Loader::db();
		$values = $db->GetAll("select akID, avID from CoreCommerceProductAttributeValues where productID = ?", array($productID));
		$avl = new AttributeValueList();
		foreach($values as $val) {
			$ak = CoreCommerceProductAttributeKey::getByID($val['akID']);
			if (is_object($ak)) {
				$value = $ak->getAttributeValue($val['avID'], $method);
				$avl->addAttributeValue($ak, $value);
			}
		}
		return $avl;
	}
	
	public static function getColumnHeaderList() {
		return self::getList(array('akIsColumnHeader' => 1));	
	}

	public static function getSearchableList() {
		return self::getList(array('akIsSearchable' => 1));	
	}
	public static function getSearchableIndexedList() {
		return self::getList(array('akIsSearchableIndexed' => 1));	
	}

	public function getAttributeValue($avID, $method = 'getValue') {
		$av = CoreCommerceProductAttributeValue::getByID($avID);
		$av->setAttributeKey($this);
		return call_user_func_array(array($av, $method), array());
	}
	
	public static function getByID($akID) {
		$ak = new CoreCommerceProductAttributeKey();
		$ak->load($akID);
		if ($ak->getAttributeKeyID() > 0) {
			return $ak;	
		}
		return $ak;
	}

	public static function getByHandle($akHandle) {
		$db = Loader::db();
		$akID = $db->GetOne('select akID from AttributeKeys inner join AttributeKeyCategories on AttributeKeys.akCategoryID = AttributeKeyCategories.akCategoryID where akHandle = ? and akCategoryHandle = \'core_commerce_product\'', array($akHandle));
		$ak = new CoreCommerceProductAttributeKey();
		$ak->load($akID);
		if ($ak->getAttributeKeyID() > 0) {
			return $ak;	
		}
	}

	public static function getList($filter = array()) {
		if (isset($filter) && !is_array($filter)) {
			$filter = array(); // if some buggy addons pass a product here we need to ignore it
		}
		$list = parent::getList('core_commerce_product', $filter);	
		usort($list, array('CoreCommerceProductAttributeKey', 'sortListByDisplayOrder'));
		return $list;
	}

	protected function saveAttribute($product, $value = false) {
		$av = $product->getAttributeValueObject($this, true);
		parent::saveAttribute($av, $value);
		$db = Loader::db();
		$v = array($product->getProductID(), $this->getAttributeKeyID(), $av->getAttributeValueID());
		$db->Replace('CoreCommerceProductAttributeValues', array(
			'productID' => $product->getProductID(), 
			'akID' => $this->getAttributeKeyID(), 
			'avID' => $av->getAttributeValueID()
		), array('productID', 'akID'));
		unset($av);
		$product->reindex();
	}
	
	public function add($at, $args, $pkg = false) {
		$ak = parent::add('core_commerce_product', $at, $args, $pkg);
		return $ak;
	}
	
	public function delete() {
		parent::delete();
		$db = Loader::db();
		@$db->Execute('delete from CoreCommerceProductAttributeKeys where akID = ?', array($this->getAttributeKeyID()));
		$r = $db->Execute('select avID from CoreCommerceProductAttributeValues where akID = ?', array($this->getAttributeKeyID()));
		while ($row = $r->FetchRow()) {
			$db->Execute('delete from AttributeValues where avID = ?', array($row['avID']));
		}
		$db->Execute('delete from CoreCommerceProductAttributeValues where akID = ?', array($this->getAttributeKeyID()));
	}

}

class CoreCommerceProductAttributeValue extends AttributeValue {

	public function setProduct($product) {
		$this->product = $product;
	}
	
	public static function getByID($avID) {
		$cav = new CoreCommerceProductAttributeValue();
		$cav->load($avID);
		if ($cav->getAttributeValueID() == $avID) {
			return $cav;
		}
	}

	public function delete() {

		$db = Loader::db();
		$db->Execute('delete from CoreCommerceProductAttributeValues where productID = ? and akID = ? and avID = ?', array(
			$this->product->getProductID(), 
			$this->attributeKey->getAttributeKeyID(),
			$this->getAttributeValueID()
		));

		// Before we run delete() on the parent object, we make sure that attribute value isn't being referenced in the table anywhere else
		$num = $db->GetOne('select count(avID) from CoreCommerceProductAttributeValues where avID = ?', array($this->getAttributeValueID()));
		if ($num < 1) {
			parent::delete();
		}
	}
}