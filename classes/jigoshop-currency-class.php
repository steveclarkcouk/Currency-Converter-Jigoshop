<?php



/**
 * Base class
 */
if (!class_exists('Jigoshop_Mutli_Currency')) 
{
	class Jigoshop_Mutli_Currency 
	{
		public $prefix;
		public $plugin_url;
		public $plugin_path;
		public $data;
		private $version;

		/**
		 * Constructor
		 */
		public function Jigoshop_Mutli_Currency() 
		{
			$this->plugin_url = plugin_dir_url(__FILE__);
			$this->plugin_path = plugin_dir_path(__FILE__);
			$this->version = "1.0";	
		}
	
		/**
		* Set Data
		*/
		public function setData($k, $v)
		{
			$this->data[$k] = $v;
		}
		
		/**
		* Get Data
		*/
		public function getData($k)
		{
		   	return $this->data[$k];
		}
	
		/**
		* Common Call
		*/
		public function get_currency_symbol($code)
		{
			switch ($code) :
				case 'AED' : $currency_symbol = '&#1583;&#46;&#1573;'; break;
				case 'AUD' : $currency_symbol = '&#36;'; break;
				case 'BRL' : $currency_symbol = '&#82;&#36;'; break;
				case 'CAD' : $currency_symbol = '&#36;'; break;
				case 'CHF' : $currency_symbol = 'SFr.'; break;
				case 'CNY' : $currency_symbol = '&#165;'; break;
				case 'CZK' : $currency_symbol = '&#75;&#269;'; break;
				case 'DKK' : $currency_symbol = 'kr'; break;
				case 'EUR' : $currency_symbol = '&euro;'; break;
				case 'GBP' : $currency_symbol = '&pound;'; break;
				case 'HKD' : $currency_symbol = '&#36;'; break;
				case 'HRK' : $currency_symbol = '&#107;&#110;'; break;
				case 'HUF' : $currency_symbol = '&#70;&#116;'; break;
				case 'IDR' : $currency_symbol = '&#82;&#112;'; break;
				case 'ILS' : $currency_symbol = '&#8362;'; break;
				case 'INR' : $currency_symbol = '&#8360;'; break;
				case 'JPY' : $currency_symbol = '&yen;'; break;
				case 'MXN' : $currency_symbol = '&#36;'; break;
				case 'MYR' : $currency_symbol = 'RM'; break;
				case 'NGN' : $currency_symbol = '&#8358;'; break;
				case 'NOK' : $currency_symbol = 'kr'; break;
				case 'NZD' : $currency_symbol = '&#36;'; break;
				case 'PHP' : $currency_symbol = '&#8369;'; break;
				case 'PLN' : $currency_symbol = '&#122;&#322;'; break;
				case 'RON' : $currency_symbol = '&#108;&#101;&#105;'; break;
				case 'RUB' : $currency_symbol = '&#1088;&#1091;&#1073;'; break;
				case 'SEK' : $currency_symbol = 'kr'; break;
				case 'SGD' : $currency_symbol = '&#36;'; break;
				case 'THB' : $currency_symbol = '&#3647;'; break;
				case 'TRY' : $currency_symbol = '&#8356;'; break;
				case 'TWD' : $currency_symbol = '&#78;&#84;&#36;'; break;
				case 'USD' : $currency_symbol = '&#36;'; break;
				case 'ZAR' : $currency_symbol = 'R'; break;
				default : $currency_symbol = '&pound;'; break;
			endswitch;

			return $currency_symbol;
		}
		

	}
	/*******
	* Plugin Activation Hook
	*******/
	//register_activation_hook(__FILE__,array("Jigoshop_Mutli_Currency", "jmc_install"));
}


/**
 * Admin class
 */
if (!class_exists('Jigoshop_Mutli_Currency_Admin')) {
class Jigoshop_Mutli_Currency_Admin extends Jigoshop_Mutli_Currency
{

	/**
	 * Constructor
	 */
	public function Jigoshop_Mutli_Currency_Admin() {
		parent::Jigoshop_Mutli_Currency();

		// Load the plugin when Jigoshop is enabled
		if ( in_array( 'jigoshop/jigoshop.php', apply_filters( 'active_plugins', get_option( 'active_plugins' ) ) ) ) {
			add_action('init', array($this, 'load_all_hooks'));
		}
	}

	/**
	 * Load the hooks
	 */
	public function load_all_hooks() {	
		load_plugin_textdomain('jigoshop-multi-currency', false, dirname( plugin_basename( __FILE__ ) ) . '/languages/' );

		// --- Add Admin Menu
		add_action( 'admin_menu', array( $this, 'add_menu') );
	}

	/**
	 * Add the menu
	 */
	public function add_menu() {
		add_submenu_page('jigoshop', __('Manage Exchange Rates', 'jigoshop-multi-currency'), __('Manage Exchange Rates', 'jigoshop-multi-currency'), 'manage_options', 'jigoshop_exchange_rates_settings', array($this, 'jigoshop_exchange_rates_settings') );
	}

	/**
	 * Create the menu content
	 */
	public function jigoshop_exchange_rates_settings() {
		// Check the user capabilities
		if (!current_user_can('manage_options')) {
			wp_die( __('You do not have sufficient permissions to access this page.') );
		}

		// Save the field values
		$fields_submitted = $this->data['prefix'] . 'fields_submitted';
		if ( isset($_POST[ $fields_submitted ]) && $_POST[ $fields_submitted ] == 'submitted' ) {
			foreach ($_POST as $key => $value) {
				if ( get_option( $key ) != $value ) {
					update_option( $key, $value );
				}
				else {
					add_option( $key, $value, '', 'no' );
				}
			}
			
			// Force Update On Cache
			global $currency_converter;
			$currency_converter->update_cache();

			?><div id="setting-error-settings_updated" class="updated settings-error">
			<p><strong><?php _e('Settings saved.'); ?></strong></p>
		</div><?php
		}

		// Show the fields
		?>
		<div class="wrap jigoshop">
				
		<form method="post" id="mainform" action="">
			
			<input type="hidden" name="<?php echo $fields_submitted; ?>" value="submitted">
			<div id="tabs-wrap">
				<p class="submit">
					<input type="submit" name="Submit" class="button-primary" value="<?php esc_attr_e('Save Changes'); ?>" />
				</p>
				
				<ul class="tabs">
					<li><a href="#tab1">General Settings</a></li>
					<li><a href="#tab2">Enabled Currencies</a></li>
					<li><a href="#tab3">Donate</a></li>
				</ul>
				
				<div id="tab1" class="panel">
					<table class="widefat fixed" >
						<thead>
							<tr>
								<th colspan="2"><?php _e('General Settings', 'jigoshop-multi-currency'); ?></th>
							</tr>
						</thead>	
						<tbody>
							<tr>
								<td>
									<strong>Disclaimer Message</strong><br/>Wherever the conversions appear you may add a disclaimer message as to the conversion rates are just a guide.
								</td>
								<td>
									<textarea style="width:100%" name="<?php echo $this->data['prefix']; ?>disclaimer"><?php echo get_option( $this->data['prefix'] . 'disclaimer'); ?></textarea>
								</td>
							</tr>

							<tr>
								<td>
									<strong>Auto Add Conversions To Single Product Pages</strong><br/>This will add the conversion prices underneath the main base currency price. If you wish to add this manually use:<br/> <code>&lt;?php jigoshop_currency_product_conversion(); ?&gt;</code>
								</td>
								<td>
									<select name="<?php echo $this->data['prefix'] . "add_to_single_summary"; ?>">
										<option value="0" <?php if(get_option($this->data['prefix'] . "add_to_single_summary") == 0) : ?>selected="selected"<?php endif; ?>>Disabled</option>
										<option value="1" <?php if(get_option($this->data['prefix'] . "add_to_single_summary") == 1) : ?>selected="selected"<?php endif; ?>>Enabled</option>
									</select>
								</td>
							</tr>
							
							<tr>
								<td>
									<strong>Auto Add Conversions To Cart page above the billing form (Lack of Hooks)</strong><br/>If you wish to add this manually use:<br/> <code>&lt;?php jigoshop_currency_cart_conversion(); ?&gt;</code>
								</td>
								<td>
									<select name="<?php echo $this->data['prefix'] . "add_to_cart_auto"; ?>">
										<option value="0" <?php if(get_option($this->data['prefix'] . "add_to_cart_auto") == 0) : ?>selected="selected"<?php endif; ?>>Disabled</option>
										<option value="1" <?php if(get_option($this->data['prefix'] . "add_to_cart_auto") == 1) : ?>selected="selected"<?php endif; ?>>Enabled</option>
									</select>
								</td>
							</tr>
							
							<tr>
								<td>
									<strong>Display Option:</strong> 
								</td>
								<td>
									<select name="<?php echo $this->data['prefix'] . "design"; ?>">
										<option value="" <?php if(get_option($this->data['prefix'] . "design") == '') : ?>selected="selected"<?php endif; ?>>Show Text - eg. ( USD From: $9.99 )</option>
										<option value="1" <?php if(get_option($this->data['prefix'] . "design") == 1) : ?>selected="selected"<?php endif; ?>>Show Flags &amp; Price</option>
									</select>
								</td>
							</tr>

							<tr>
								<td>
									<strong>Cache Period</strong><br/>Enter the number of seconds between you wish to check the exchange rate.
								</td>
								<td>
									<input name="<?php echo $this->data['prefix']; ?>cache_period" value="<?php echo get_option( $this->data['prefix'] . 'cache_period'); ?>" />
								</td>
							</tr>
						</tbody>
					</table>
				</div>

				<div id="tab2" class="panel">
					

					
						<table class="widefat fixed" >
							<thead>
								<tr>
									<th colspan="2"><?php _e('Store Currencies', 'jigoshop-multi-currency'); ?><br/>
										<p>Select the currencies you wish to enable on your site.</p>
									</th>
								</tr>
							</thead>	
							<tbody>
							
								<?php if ($this->data['countries']) foreach ($this->data['countries'] as $key=>$val) : ?>
									<?php $enabled = get_option($this->data['prefix'] . $key . "_enabled") == 1; ?>
									<tr>
										<td width="25%"><strong><?php echo $key; ?></strong> - <?php echo $val; ?> </td>
										<td>
											<select name="<?php echo $this->data['prefix'] . $key . "_enabled"; ?>">
												<option value="0" <?php if(!$enabled) : ?>selected="selected"<?php endif; ?>>Disabled</option>
												<option value="1" <?php if($enabled): ?>selected="selected"<?php endif; ?>>Enabled</option>
											</select> 
											<?php if($enabled): ?>| Last Rate: <?php echo get_option('currency_rate_' . $key ) ; ?><?php endif; ?>
										</td>
									</tr>
			            		<?php endforeach; ?>
							</tbody>
						</table>

				</div>
				
				<div id="tab3" class="panel">
						<!-- Cheeky I Know But Hey Why Not! -->
						<form action="https://www.paypal.com/cgi-bin/webscr" method="post" style="border:2px double #333; background:#eee; padding:15px; width:20%; float:right;">
							<input type="hidden" name="cmd" value="_s-xclick">
							<input type="hidden" name="hosted_button_id" value="VAX9GTEKJ9WSA">
							<h2>Do you like this? Then buy me a beer?</h2>
							<p>If you like this plugin and use it then why not buy me a beer in support of it - I would really appreciate</p>
							<input type="image" src="https://www.paypalobjects.com/en_GB/i/btn/btn_donate_LG.gif" border="0" name="submit" alt="PayPal ó The safer, easier way to pay online.">
							<img alt="" border="0" src="https://www.paypalobjects.com/en_GB/i/scr/pixel.gif" width="1" height="1">
						</form>
				</div>
			</div>
			
		
			
			<script type="text/javascript">
			jQuery(function($) {
			    // Tabs
				jQuery('ul.tabs').show();
				jQuery('ul.tabs li:first').addClass('active');
				jQuery('div.panel:not(div.panel:first)').hide();
				jQuery('ul.tabs a').click(function(){
					jQuery('ul.tabs li').removeClass('active');
					jQuery(this).parent().addClass('active');
					jQuery('div.panel').hide();
					jQuery( jQuery(this).attr('href') ).show();

					jQuery.cookie('jigoshop_settings_tab_index', jQuery(this).parent().index('ul.tabs li'))

					return false;
				});

				<?php if (isset($_COOKIE['jigoshop_settings_tab_index']) && $_COOKIE['jigoshop_settings_tab_index'] > 0) : ?>

					jQuery('ul.tabs li:eq(<?php echo $_COOKIE['jigoshop_settings_tab_index']; ?>) a').click();

				<?php endif; ?>

				// Countries
				jQuery('select#jigoshop_allowed_countries').change(function(){
					if (jQuery(this).val()=="specific") {
						jQuery(this).parent().parent().next('tr.multi_select_countries').show();
					} else {
						jQuery(this).parent().parent().next('tr.multi_select_countries').hide();
					}
				}).change();

				// permalink double save hack
				$.get('<?php echo admin_url('options-permalink.php') ?>');

			});
			</script>
			
			<p class="submit">
				<input type="submit" name="Submit" class="button-primary" value="<?php esc_attr_e('Save Changes'); ?>" />
			</p>
		</form>
	</div><?php
	}
}
}



?>