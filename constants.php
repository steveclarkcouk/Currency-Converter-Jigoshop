<?php

// Prefix Of Plugin (Needs to be access'd via widget so setData value in base class used)
$prefix = 'jmc_lite_';

// Country List
$countries = apply_filters('jigoshop_currencies', array(
	'USD' => __('US Dollars (&#36;)', 'jigoshop'),
	'EUR' => __('Euros (&euro;)', 'jigoshop'),
	'GBP' => __('Pounds Sterling (&pound;)', 'jigoshop'),
	'AUD' => __('Australian Dollars (&#36;)', 'jigoshop'),
	'BRL' => __('Brazilian Real (&#36;)', 'jigoshop'),
	'CAD' => __('Canadian Dollars (&#36;)', 'jigoshop'),
	'CZK' => __('Czech Koruna', 'jigoshop'),
	'DKK' => __('Danish Krone', 'jigoshop'),
	'HKD' => __('Hong Kong Dollar (&#36;)', 'jigoshop'),
	'HUF' => __('Hungarian Forint', 'jigoshop'),
	'IDR' => __('Indonesia Rupiah (&#52;)', 'jigoshop'),
	'ILS' => __('Israeli Shekel', 'jigoshop'),
	'JPY' => __('Japanese Yen (&yen;)', 'jigoshop'),
	'MYR' => __('Malaysian Ringgits', 'jigoshop'),
	'MXN' => __('Mexican Peso (&#36;)', 'jigoshop'),
	'NZD' => __('New Zealand Dollar (&#36;)', 'jigoshop'),
	'NOK' => __('Norwegian Krone', 'jigoshop'),
	'PHP' => __('Philippine Pesos', 'jigoshop'),
	'PLN' => __('Polish Zloty', 'jigoshop'),
	'RUB' => __('Russian Ruble (&#440;)', 'jigoshop'),
	'SGD' => __('Singapore Dollar (&#36;)', 'jigoshop'),
	'SEK' => __('Swedish Krona', 'jigoshop'),
	'CHF' => __('Swiss Franc', 'jigoshop'),
	'TWD' => __('Taiwan New Dollars', 'jigoshop'),
	'THB' => __('Thai Baht', 'jigoshop')
	)
);
?>