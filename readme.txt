=== Jigoshop Multi Currency ===

== V1.1 ===

Because of the load_template call the cart conversion was being based on a singular product rather that the entire cart. To avoid this issue in the render method of the class
I have made two new functions (see below). 

New Function Calls
==================
<?php jigoshop_currency_product_conversion(); ?> - This adds the currency conversion dialog and does the conversion based on the current product
<?php jigoshop_currency_cart_conversion(); ?> - This adds the currency conversion dialog and does the conversion based on the current cart contents

Deprecated
===========
<?php jigoshop_currency_convert(); ?> is no longer supported as in the cart the post global loses scope. so to peform conversions now you will need to do the following:

== v1.0 ==

== Description ==
A simple plugin which allows for the display of alternate currencies on the product view and the cart view. The plugin uses Yahoo Finance to grab all of its base exchange rates.
This is an offspring of a bigger project I am working on to get Jigoshop 100% multi currency enabled.

== Installation ==

= Install =

1. Unzip the zip file. 
1. Upload the the `Currency-Converter-Jigoshop` folder (not just the files in it!) to your `wp-contents/plugins` folder.

= Activate =

1. In your WordPress administration, go to the Plugins page
2. Activate the Jigoshop - Multi Currency Lite For Jigoshop and an exchange rates settings link will appear underneath the Jigoshop menu in Wordpress admin

== Documentation ==

-- Base Usage

Once installed you will see a exchange rates settings menu appear under the Jigoshop section of the WP admin navigation. The settings are split into two tabbed sections General Settings and Enabled Currencies.

-- General Settings 

1. Disclaimer Message
You may wish to add a disclaimer message to any converted rates displayed as most banks exchange rates differ depending on the source. 

2. Auto Add Conversions To Single Product Pages
If enabled the conversions will be added via the jigoshop 'jigoshop_template_single_summary' action and will appear beneath the product tile on the product specific page.

3. Auto Add Conversions To Cart page above the billing form
If enabled a cart total conversion is added to the bottom of the checkout page.

4. Display Option
Choose wether you would just like text conversions e.g: USD ($) From: $14.99 or a flag images.

5. Cache Duration
The cache duration is a value in milliseconds as to how often the plugin polls Yahoo Finance to get the latest exchange rates.

-- Custom Conversion Placement
If you do not wish to use the automatic conversion placement. then just add the following code <?php jigoshop_currency_convert(); ?> where you would like a conversion to appear. 

-- Enabled Currencies

This page allows you to enable and disable currencies you wish to display on your site. When you change this page Yahoo Finance will be polled and the cache will be updated to reflect these changes.

