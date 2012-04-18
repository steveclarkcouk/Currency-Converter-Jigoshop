<?php

// Prefix Of Plugin (Needs to be access'd via widget so setData value in base class used)
$prefix = 'jmc_lite_';

// Country List
$countries = apply_filters('jigoshop_currencies', array(
	'AED' => __('United Arab Emirates dirham (&#1583;&#46;&#1573;)', 'jigoshop'),
	'AUD' => __('Australian Dollar (&#36;)', 'jigoshop'),
	'BRL' => __('Brazilian Real (&#82;&#36;)', 'jigoshop'),
	'CAD' => __('Canadian Dollar (&#36;)', 'jigoshop'),
	'CHF' => __('Swiss Franc (SFr.)', 'jigoshop'),
	'CNY' => __('Chinese yuan (&#165;)', 'jigoshop'),
	'CZK' => __('Czech Koruna (&#75;&#269;)', 'jigoshop'),
	'DKK' => __('Danish Krone (kr)', 'jigoshop'),
	'EUR' => __('Euro (&euro;)', 'jigoshop'),
	'GBP' => __('Pounds Sterling (&pound;)', 'jigoshop'),
	'HKD' => __('Hong Kong Dollar (&#36;)', 'jigoshop'),
	'HRK' => __('Croatian Kuna (&#107;&#110;)', 'jigoshop'),
	'HUF' => __('Hungarian Forint (&#70;&#116;)', 'jigoshop'),
	'IDR' => __('Indonesia Rupiah (&#82;&#112;)', 'jigoshop'),
	'ILS' => __('Israeli Shekel (&#8362;)', 'jigoshop'),
	'INR' => __('Indian Rupee (&#8360;)', 'jigoshop'),
	'JPY' => __('Japanese Yen (&yen;)', 'jigoshop'),
	'MXN' => __('Mexican Peso (&#36;)', 'jigoshop'),
	'MYR' => __('Malaysian Ringgits (RM)', 'jigoshop'),
	'NGN' => __('Nigerian Naira (&#8358;)', 'jigoshop'),
	'NOK' => __('Norwegian Krone (kr)', 'jigoshop'),
	'NZD' => __('New Zealand Dollar (&#36;)', 'jigoshop'),
	'PHP' => __('Philippine Pesos (&#8369;)', 'jigoshop'),
	'PLN' => __('Polish Zloty (&#122;&#322;)', 'jigoshop'),
	'RON' => __('Romanian New Leu (&#108;&#101;&#105;)', 'jigoshop'),
	'RUB' => __('Russian Ruble (&#1088;&#1091;&#1073;)', 'jigoshop'),
	'SEK' => __('Swedish Krona (kr)', 'jigoshop'),
	'SGD' => __('Singapore Dollar (&#36;)', 'jigoshop'),
	'THB' => __('Thai Baht (&#3647;)', 'jigoshop'),
	'TRY' => __('Turkish Lira (&#8356;)', 'jigoshop'),
	'TWD' => __('Taiwan New Dollar (&#36;)', 'jigoshop'),
	'USD' => __('US Dollar (&#36;)', 'jigoshop'),
	'ZAR' => __('South African rand (R)', 'jigoshop')
	)
);
?>