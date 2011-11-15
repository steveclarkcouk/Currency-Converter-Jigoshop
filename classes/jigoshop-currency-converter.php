<?php
/**
* Currency Converter
*
* [ TO DO ] - Add Selected Currencies to an option array rather than reiterating through the whole option object
**/

// --- Currecny Converter Class
class currency_converter extends Jigoshop_Mutli_Currency
{
	public function currency_converter() {
		parent::Jigoshop_Mutli_Currency();
	}
	
	
	/* Makes The Price Conversion based on Yahoo Finance Exchange Rate */
	public function convert($price, $to)
	{	
		$price = str_replace(get_jigoshop_currency_symbol(), "", $price);
		if(get_option('currency_rate_' . $to) != "")
		{
			return "<span class=\"currency-symbol\">" . $this->get_currency_symbol($to) . "</span>" . number_format($price * get_option('currency_rate_' . $to), 2);
		} else {
			return "<span>Unavailable</span>";
		}
	}
	
	/* Updates The Cache */
	public function update_cache()
	{
		$currencies_to_convert = $this->getCurrenciesToConvert();
		foreach($currencies_to_convert as $currency_code)
		{
			$url = 'http://finance.yahoo.com/d/quotes.csv?e=.csv&f=sl1d1t1&s=' . get_option('jigoshop_currency') . $currency_code.'=X';
			$handle = @fopen($url, 'r');
			if ($handle) 
			{
			    $result = fgets($handle, 4096);
			    fclose($handle);
				$array = explode(',',$result);
				$ex_rate = (float)$array[1];
				
				//echo "<li>CURRENCY CODE $currency_code HAS A VALUE OF $ex_rate";
				
				update_option('currency_rate_' . $currency_code, $ex_rate);
				update_option('currency_cache_last_check', time());
			} 
		}
	}
	
	/* Returns an Array of Currencis to convert */
	public function getCurrenciesToConvert()
	{
		$countries_array = array();
		foreach($this->data['countries'] as $k => $v)
		{
			if(get_option($this->data['prefix'] . $k . '_enabled') == 1)
			{
				array_push($countries_array, $k);
			}
		}
		return $countries_array;
	}
	
	/* Checks the Cache */
	public function check_caches()
	{
		if(!is_checkout())
		{
			$last_update = get_option('currency_cache_last_check');
			if(!$last_update || (time() - $last_update) > get_option($this->data['prefix'] . 'cache_period'))
			{
				$this->update_cache();
			}
		}
	}	

	/* Public Function To Render the Conversions To Jigoshop */
	public function render()
	{
		if(is_checkout())
		{
			echo $this->add_cart_conversion_prices();
		} else {
			echo $this->add_conversion_prices();
		}
	}


	/* Render The Header */
	public function getRenderHeader()
	{
		$headerHTML = '<h2>Currency Conversions</h2><small>These are correct as of ' . date('d/M/Y h:m:s', get_option('currency_cache_last_check')) . '</small>';
		if(get_option($this->data['prefix'] . 'disclaimer') != '')
		{
			$headerHTML .= '<p class="disclamer">' . get_option($this->data['prefix'] . 'disclaimer') . '</p>';
		}
		return $headerHTML;
	}

	/* Public Rendering Functions (Product Conversion Prices)  */
	public function add_conversion_prices()
	{
		global $_product;
		
		// -- Check If Is Singleton Or Has Variations To Add From Etc
			
		$currencies_to_convert = $this->getCurrenciesToConvert();
		if($currencies_to_convert)
		{
			$priceHtML .=  $this->getRenderHeader();
			$priceHtML .= '<ul class="price-conversions">';
			foreach($currencies_to_convert as $cc)
			{
				$fromHTML = ($_product->has_child()) ? 'From: ' : '';
				if(get_option($this->data['prefix'] . 'design') == 1)
				{
					$priceHtML .= '<li><img src="' . str_replace("/classes", "", $this->plugin_url) . 'assets/images/flags/' . strtolower($cc) . '.png" alt="' . $cc . '"/> ' . $fromHTML . ' ' . $this->convert($_product->get_price(), $cc) . '</li>';
				} else {
					$priceHtML .= '<li>' . $cc . '(' . $this->get_currency_symbol($cc) . ')  ' . $fromHTML . ' ' . $this->convert($_product->get_price(), $cc) . '</li>';
				}
				
				//$priceHtML .= $this->getListItem($currency_code, $_product);
			}
			$priceHtML .= '</ul>';
			return '<div class="currency-conversion">' . $priceHtML . '</div>';
		}

	}
	
	/* Public Rendering Functions (Cart Conversion Prices) */
	public function add_cart_conversion_prices()
	{
		$currencies_to_convert = $this->getCurrenciesToConvert();
		if($currencies_to_convert)
		{
			$priceHtML .=  $this->getRenderHeader();
			$priceHtML .= '<ul class="price-conversions">';
			foreach($currencies_to_convert as $cc)
			{
				if(get_option($this->data['prefix'] . 'design') == 1)
				{
					$priceHtML .= '<li><img src="' . str_replace("/classes", "", $this->plugin_url) . 'assets/images/flags/' . strtolower($cc) . '.png" alt="' . $cc . '"/> ' . $this->convert(jigoshop_cart::get_total(), $cc) . '</li>';
				} else {
					$priceHtML .= '<li>' . $cc . '(' . $this->get_currency_symbol($cc) . ') ' . $this->convert(jigoshop_cart::get_total(), $cc) . '</li>';
				}
			}
			$priceHtML .= '</ul>';
			return '<div class="currency-conversion">' . $priceHtML . '</div>';
		}
	}

}




?>