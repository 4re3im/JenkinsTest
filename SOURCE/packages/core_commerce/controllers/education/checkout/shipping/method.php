<?php  defined('C5_EXECUTE') or die(_("Access Denied.")); 

Loader::controller('/checkout');
class CheckoutShippingMethodController extends CheckoutController {
	
	public function on_start() {
		parent::on_start();
		$methods = $this->get('order')->getAvailableShippingMethods();
		$this->set('methods', $methods);
		if (count($methods) == 1) {
			$this->disableStep('/checkout/shipping/method');
		}
	}
	
	public function view() {
		$methods = $this->get('methods');
		if (count($methods) == 1) {
			// select one and go
			$this->get('order')->setShippingMethod($methods[0]);
			$sh = Loader::helper('checkout/step', 'core_commerce');
			if ($_GET['previous'] == 1) { 
				$this->redirect($sh->getPreviousCheckoutStepURL());
			} else {
				$this->redirect($sh->getNextCheckoutStepURL());
			}
		}
		if (!$this->get('order')->requiresShipping()) {
			$this->redirect($this->getNextCheckoutStep()->getRedirectURL());
		}
	}
	
	public function submit($json=0) {
		parent::submit();
		if (!$this->post('shippingMethodID')) {
			$this->error->add(t('You must specify a shipping method.'));
		}
		
		if (!$this->error->has()) {
			Loader::model('shipping/method', 'core_commerce');
			$method = CoreCommerceShippingMethod::getAvailableMethodByID($this->post('shippingMethodID'));
			if ($method) {
				$this->get('order')->setShippingMethod($method);
			}
		}
		
		if($json) {
			$result = array();
			$json = Loader::helper('json');
			
			if ($this->error->has()) {
				$result['error'] = $this->error->getList();
			} else {
				$result['success'] = 1;
			}
		
			$txt = Loader::helper('text');
			$result['nextStep'] = $txt->sanitizeFileSystem($this->getNextCheckoutStep()->getPath());
			
			echo $json->encode($result);
			exit;
		} 
		
		if(!$this->error->has()) {
			$this->redirect($this->getNextCheckoutStep()->getRedirectURL());
		} else {
			$this->view();
		}
	}
	
}