<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/*
 * CI-Merchant Library
 *
 * Copyright (c) 2011-2012 Adrian Macneil
 *
 * Permission is hereby granted, free of charge, to any person obtaining a copy
 * of this software and associated documentation files (the "Software"), to deal
 * in the Software without restriction, including without limitation the rights
 * to use, copy, modify, merge, publish, distribute, sublicense, and/or sell
 * copies of the Software, and to permit persons to whom the Software is
 * furnished to do so, subject to the following conditions:

 * The above copyright notice and this permission notice shall be included in
 * all copies or substantial portions of the Software.

 * THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
 * IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,
 * FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE
 * AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER
 * LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM,
 * OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN
 * THE SOFTWARE.
 */

/**
 * Merchant Class (extended by Andy Coates for use with recurrent billing) (c) 2013
 * 
 * HAD TO MAKE PRIVATE FUNCTIONS PROTECTED INSTEAD IN merchant.php IN ORDER TO EXTEND!
 *
 * Payment processing for CodeIgniter
 */
require_once dirname(__FILE__).'/merchant.php';

class Merchant_r extends Merchant
{
	
	public function subscribe($params)
	{
		return $this->_do_authorize_or_purchase('subscribe', $params);
	}

	public function purchase_return($params)
	{
		return $this->_do_authorize_or_purchase('purchase_return', $params);
	}
	
	public function cancel_agreement($params)
	{
		return $this->_do_cancel_agreement($params);
	}
	
}

/* End of file ./libraries/merchant/merchant.php */