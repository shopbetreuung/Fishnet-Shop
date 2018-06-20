<?php
  /* --------------------------------------------------------------
   $Id: column_left.php 4298 2013-01-13 20:04:19Z Tomcraft1980 $

   modified eCommerce Shopsoftware
   http://www.modified-shop.org

   Copyright (c) 2009 - 2013 [www.modified-shop.org]
   --------------------------------------------------------------
   based on:
   (c) 2000-2001 The Exchange Project  (earlier name of osCommerce)
   (c) 2002-2003 osCommerce(column_left.php,v 1.15 2002/01/11); www.oscommerce.com
   (c) 2003 nextcommerce (column_left.php,v 1.25 2003/08/19); www.nextcommerce.org
   (c) 2006 XT-Commerce (content_manager.php 1304 2005-10-12)

   Released under the GNU General Public License
   --------------------------------------------------------------*/
 
  defined( '_VALID_XTC' ) or die( 'Direct Access to this location is not allowed.' );
  
  if ($_SESSION['customers_status']['customers_status_id'] == '0') {
	
	$menues = array();
	$menu_items = array();
	$admin_access_query = xtc_db_query("select * from " . TABLE_ADMIN_ACCESS . " where customers_id = '" . (int)$_SESSION['customer_id'] . "'");
	$admin_access = xtc_db_fetch_array($admin_access_query); 
	$admin_access["admin"] = '1';
  
	$menues[] = array("name" => BOX_MENU_CUSTOMERS, "array" => "customers");
	$menues[] = array("name" => BOX_MENU_PRODUCTS, "array" => "products");
	$menues[] = array("name" => BOX_MENU_CONTENT, "array" => "content");
	$menues[] = array("name" => BOX_MENU_MARKETING, "array" => "marketingseo");
	$menues[] = array("name" => BOX_MENU_CONFIGURATION, "array" => "configuration");
  
  
	// Setup: Customers
	// =================================================================================================================
	$menu_items['customers'][] = array(		"name" 		=> BOX_CUSTOMERS,
											"is_main"	=> true,
											"link" 		=> xtc_href_link(FILENAME_CUSTOMERS, '', 'NONSSL'),
											"access"	=> "customers",
											"check"		=> true);
										
	$menu_items['customers'][] = array(		"name" 		=> BOX_CUSTOMERS_STATUS,
											"is_main"	=> true,
											"link" 		=> xtc_href_link(FILENAME_CUSTOMERS_STATUS, '', 'NONSSL'),
											"access"	=> "customers_status",
											"check"		=> true);		
										
	$menu_items['customers'][] = array(		"name" 		=> BOX_CUSTOMERS_GROUP,
											"is_main"	=> true,
											"link" 		=> xtc_href_link(FILENAME_CUSTOMERS_GROUP, '', 'NONSSL'),
											"access"	=> "customers_group",
											"check"		=> GROUP_CHECK);		
	
	$menu_items['customers'][] = array(		"name" 		=> BOX_ORDERS,
											"is_main"	=> true,
											"link" 		=> xtc_href_link(FILENAME_ORDERS, '', 'NONSSL'),
											"access"	=> "orders",
											"check"		=> true);							
											
	$menu_items['customers'][] = array(		"name" 		=> BOX_PAYPAL,
											"is_main"	=> true,
											"link" 		=> xtc_href_link('paypal.php'),
											"access"	=> "paypal",
											"check"		=> true);		
											
											
					
	
	// Setup: Products
	// =================================================================================================================					
	$menu_items['products'][] = array(		"name" 		=> BOX_CATEGORIES,
											"is_main"	=> true,
											"link" 		=> xtc_href_link(FILENAME_CATEGORIES, '', 'NONSSL'),
											"access"	=> "categories",
											"check"		=> true);		
	
    $menu_items['products'][] = array(		"name" 		=> BOX_PRODUCTS_CONTENT,
                                            "is_main"   => true,
                                            "link"      => xtc_href_link(FILENAME_PRODUCTS_CONTENT, '', 'NONSSL'),
                                            "access"    => "products_content",
                                            "check"     => true);
    
        $menu_items['products'][] = array(		"name" 		=> BOX_WASTE_PAPER_BIN,
											"is_main"	=> true,
											"link" 		=> xtc_href_link(FILENAME_WASTE_PAPER_BIN, '', 'NONSSL'),
											"access"	=> "waste_paper_bin",
											"check"		=> true);                                    
    
	
	$menu_items['products'][] = array(		"name" 		=> BOX_ATTRIBUTES,
											"is_main"	=> true,
											"link" 		=> false,
											"access"	=> false,
											"check"		=> true);								
										
	$menu_items['products'][] = array(		"name" 		=> BOX_PRODUCTS_ATTRIBUTES,
											"is_main"	=> false,
											"link" 		=> xtc_href_link(FILENAME_PRODUCTS_ATTRIBUTES, '', 'NONSSL'),
											"access"	=> "products_attributes",
											"check"		=> true);	
    
	$menu_items['products'][] = array(		"name" 		=> BOX_ATTRIBUTES_MANAGER,
											"is_main"	=> false,
											"link" 		=> xtc_href_link(FILENAME_NEW_ATTRIBUTES, '', 'NONSSL'),
											"access"	=> "new_attributes",
											"check"		=> true);	    
											
	$menu_items['products'][] = array(		"name" 		=> BOX_CONFIGURATION_13,
											"is_main"	=> true,
											"link" 		=> xtc_href_link(FILENAME_CONFIGURATION, 'gID=13', 'NONSSL'),
											"access"	=> "configuration",
											"check"		=> true);		
										
	$menu_items['products'][] = array(		"name" 		=> BOX_MANUFACTURERS,
											"is_main"	=> true,
											"link" 		=> xtc_href_link(FILENAME_MANUFACTURERS, '', 'NONSSL'),
											"access"	=> "manufacturers",
											"check"		=> true);	
										
    $menu_items['products'][] = array(		"name" 		=> BOX_WHOLESALERS,
                                            "is_main"	=> true,
                                            "link" 		=> xtc_href_link(FILENAME_WHOLESALERS, '', 'NONSSL'),
                                            "access"	=> "wholesalers",
                                            "check"		=> true);
										
	$menu_items['products'][] = array(		"name" 		=> BOX_REVIEWS,
											"is_main"	=> true,
											"link" 		=> xtc_href_link(FILENAME_REVIEWS, '', 'NONSSL'),
											"access"	=> "reviews",
											"check"		=> true);										
										
	$menu_items['products'][] = array(		"name" 		=> BOX_SPECIALS,
											"is_main"	=> true,
											"link" 		=> xtc_href_link(FILENAME_SPECIALS, '', 'NONSSL'),
											"access"	=> "specials",
											"check"		=> true);									
	
	$menu_items['products'][] = array(		"name" 		=> BOX_PRODUCTS_EXPECTED,
											"is_main"	=> true,
											"link" 		=> xtc_href_link(FILENAME_PRODUCTS_EXPECTED, '', 'NONSSL'),
											"access"	=> "products_expected",
											"check"		=> true);	
											
	$menu_items['products'][] = array(		"name" 		=> BOX_REMOVEOLDPICS,
											"is_main"	=> true,
											"link" 		=> xtc_href_link(FILENAME_REMOVEOLDPICS, '', 'NONSSL'),
											"access"	=> "removeoldpics",
											"check"		=> true);											

	// Setup: Content
	// =================================================================================================================	
	$menu_items['content'][] = array(		"name" 		=> BOX_CONTENT,
											"is_main"	=> true,
											"link" 		=> xtc_href_link(FILENAME_CONTENT_MANAGER, '', 'NONSSL'),
											"access"	=> "content_manager",
											"check"		=> true);	
											
        $menu_items['content'][] = array(	"name" 		=> BOX_EMAIL,
											"is_main"	=> true,
											"link" 		=> xtc_href_link(FILENAME_EMAIL_MANAGER, '', 'NONSSL'),
											"access"	=> "email_manager",
											"check"		=> true);
											
	$menu_items['content'][] = array(		"name" 		=> BOX_IMAGESLIDERS,
											"is_main"	=> true,
											"link" 		=> xtc_href_link(FILENAME_IMAGESLIDERS, '', 'NONSSL'),
											"access"	=> "imagesliders",
											"check"		=> true);
												
  $menu_items['content'][] = array(		"name" 		=> BOX_BLACKLIST_LOGS,
											"is_main"	=> true,
											"link" 		=> xtc_href_link(FILENAME_BLACKLIST_LOGS, '', 'NONSSL'),
											"access"	=> "blacklist_logs",
											"check"		=> true);
	  
	  $menu_items['content'][] = array("name" => BOX_WHITELIST_LOGS,
									"is_main"	=> true,
									"link" 		=> xtc_href_link(FILENAME_WHITELIST_LOGS, '', 'NONSSL'),
									"access"	=> "whitelist_logs",
									"check"		=> true);
	  
	$menu_items['content'][] = array(		"name" 		=> BOX_IMPORT_EXPORT,
											"is_main"	=> true,
											"link" 		=> false,
											"access"	=> false,
											"check"		=> true);	
					
	$menu_items['content'][] = array(		"name" 		=> BOX_BLZ_UPDATE,
											"is_main"	=> false,
											"link" 		=> xtc_href_link(FILENAME_BLZ_UPDATE, '', 'NONSSL'),
											"access"	=> "blz_update",
											"check"		=> true);
        $menu_items['content'][] = array(		"name" 		=> BOX_DSGVO_CUSTOMER_EXPORT,
							"is_main"	=> false,
							"link" 		=> xtc_href_link(FILENAME_DSGVO_EXPORT, '', 'NONSSL'),
							"access"	=> "dsgvo_export",
							"check"		=> true);
											
	$menu_items['content'][] = array(		"name" 		=> BOX_IMPORT,
											"is_main"	=> false,
											"link" 		=> xtc_href_link('csv_backend.php', '', 'NONSSL'),
											"access"	=> "csv_backend",
											"check"		=> true);											
				
	$menu_items['content'][] = array(		"name" 		=> BOX_LAW,
											"is_main"	=> true,
											"link" 		=> false,
											"access"	=> false,
											"check"		=> true);	
					
	$menu_items['content'][] = array(		"name" 		=> BOX_JANOLAW,
											"is_main"	=> false,
											"link" 		=> xtc_href_link(FILENAME_JANOLAW, '', 'NONSSL'),
											"access"	=> "janolaw",
											"check"		=> true);				
	
	$menu_items['content'][] = array(		"name" 		=> BOX_IT_RECHT_KANZLEI,
											"is_main"	=> false,
											"link" 		=> xtc_href_link(FILENAME_IT_RECHT_KANZLEI, '', 'NONSSL'),
											"access"	=> "it_recht_kanzlei",
											"check"		=> true);	
											
	$menu_items['content'][] = array(		"name" 		=> BOX_HAENDLERBUND,
											"is_main"	=> false,
											"link" 		=> xtc_href_link(FILENAME_HAENDLERBUND, '', 'NONSSL'),
											"access"	=> "haendlerbund",
											"check"		=> true);		
											
	$menu_items['content'][] = array(		"name" 		=> BOX_SAFETERMS,
											"is_main"	=> false,
											"link" 		=> xtc_href_link(FILENAME_SAFETERMS, '', 'NONSSL'),
											"access"	=> "safeterms",
											"check"		=> true);		
											
				
	// Setup: Marketing / Seo
	// =================================================================================================================											
	$menu_items['marketingseo'][] = array(	"name" 		=> BOX_COUPON_ADMIN,
											"is_main"	=> true,
											"link" 		=> xtc_href_link(FILENAME_COUPON_ADMIN, '', 'NONSSL'),
											"access"	=> "coupon_admin",
											"check"		=> ACTIVATE_GIFT_SYSTEM);	
	
	$menu_items['marketingseo'][] = array(	"name" 		=> BOX_HEADING_GV,
											"is_main"	=> true,
											"link" 		=> false,
											"access"	=> false,
											"check"		=> ACTIVATE_GIFT_SYSTEM);	
											
	$menu_items['marketingseo'][] = array(	"name" 		=> BOX_GV_ADMIN_QUEUE,
											"is_main"	=> false,
											"link" 		=> xtc_href_link(FILENAME_GV_QUEUE, '', 'NONSSL'),
											"access"	=> "gv_queue",
											"check"		=> ACTIVATE_GIFT_SYSTEM);	
	
	$menu_items['marketingseo'][] = array(	"name" 		=> BOX_GV_ADMIN_MAIL,
											"is_main"	=> false,
											"link" 		=> xtc_href_link(FILENAME_GV_MAIL, '', 'NONSSL'),
											"access"	=> "gv_mail",
											"check"		=> ACTIVATE_GIFT_SYSTEM);	
	
	$menu_items['marketingseo'][] = array(	"name" 		=> BOX_GV_ADMIN_SENT,
											"is_main"	=> false,
											"link" 		=> xtc_href_link(FILENAME_GV_SENT, '', 'NONSSL'),
											"access"	=> "gv_sent",
											"check"		=> ACTIVATE_GIFT_SYSTEM);	
	
	$menu_items['marketingseo'][] = array(	"name" 		=> BOX_BANNER_MANAGER,
											"is_main"	=> true,
											"link" 		=> xtc_href_link(FILENAME_BANNER_MANAGER, '', 'NONSSL'),
											"access"	=> "banner_manager",
											"check"		=> true);							
											
	$menu_items['marketingseo'][] = array(	"name" 		=> BOX_GOOGLE_SITEMAP,
											"is_main"	=> true,
											"link" 		=> xtc_href_link(FILENAME_GOOGLE_SITEMAP, 'auto=true'),
											"access"	=> "admin",
											"check"		=> true);	
											
	$menu_items['marketingseo'][] = array(	"name" 		=> BOX_MODULE_NEWSLETTER,
											"is_main"	=> true,
											"link" 		=> xtc_href_link(FILENAME_MODULE_NEWSLETTER, '', 'NONSSL'),
											"access"	=> "module_newsletter",
											"check"		=> true);																																
											
	$menu_items['marketingseo'][] = array(	"name" 		=> BOX_CONFIGURATION_16,
											"is_main"	=> true,
											"link" 		=> xtc_href_link(FILENAME_CONFIGURATION, 'gID=16', 'NONSSL'),
											"access"	=> "configuration",
											"check"		=> true);																	
											
	$menu_items['marketingseo'][] = array(	"name" 		=> BOX_HEADING_REPORTS,
											"is_main"	=> true,
											"link" 		=> false,
											"access"	=> false,
											"check"		=> true);	
	
	$menu_items['marketingseo'][] = array(	"name" 		=> BOX_WHOS_ONLINE,
											"is_main"	=> false,
											"link" 		=> xtc_href_link(FILENAME_WHOS_ONLINE, '', 'NONSSL'),
											"access"	=> "whos_online",
											"check"		=> true);
											
	$menu_items['marketingseo'][] = array(	"name" 		=> BOX_PRODUCTS_VIEWED,
											"is_main"	=> false,
											"link" 		=> xtc_href_link(FILENAME_STATS_PRODUCTS_VIEWED, '', 'NONSSL'),
											"access"	=> "stats_products_viewed",
											"check"		=> true);	
											
	$menu_items['marketingseo'][] = array(	"name" 		=> BOX_PRODUCTS_PURCHASED,
											"is_main"	=> false,
											"link" 		=> xtc_href_link(FILENAME_STATS_PRODUCTS_PURCHASED, '', 'NONSSL'),
											"access"	=> "stats_products_purchased",
											"check"		=> true);	
											
	$menu_items['marketingseo'][] = array(	"name" 		=> BOX_STATS_CUSTOMERS,
											"is_main"	=> false,
											"link" 		=> xtc_href_link(FILENAME_STATS_CUSTOMERS, '', 'NONSSL'),
											"access"	=> "stats_customers",
											"check"		=> true);
											
	$menu_items['marketingseo'][] = array(	"name" 		=> BOX_SALES_REPORT,
											"is_main"	=> false,
											"link" 		=> xtc_href_link(FILENAME_SALES_REPORT, '', 'NONSSL'),
											"access"	=> "stats_sales_report",
											"check"		=> true);
											
	$menu_items['marketingseo'][] = array(	"name" 		=> BOX_CAMPAIGNS_REPORT,
											"is_main"	=> false,
											"link" 		=> xtc_href_link(FILENAME_CAMPAIGNS_REPORT, '', 'NONSSL'),
											"access"	=> "stats_campaigns",
											"check"		=> true);

	$menu_items['marketingseo'][] = array(	"name" 		=> BOX_STOCK_WARNING,
											"is_main"	=> false,
											"link" 		=> xtc_href_link(FILENAME_STATS_STOCK_WARNING, '', 'NONSSL'),
											"access"	=> "stats_stock_warning",
											"check"		=> true);
        $menu_items['marketingseo'][] = array(	"name" 		=> BOX_INVENTORY,
											"is_main"	=> false,
											"link" 		=> xtc_href_link(FILENAME_INVENTORY, '', 'NONSSL'),
											"access"	=> "inventory",
											"check"		=> true);
        $menu_items['marketingseo'][] = array(	"name" 		=> BOX_INVOICED_ORDERS,
											"is_main"	=> false,
											"link" 		=> xtc_href_link(FILENAME_INVOICED_ORDERS, '', 'NONSSL'),
											"access"	=> "invoiced_orders",
											"check"		=> true);
        $menu_items['marketingseo'][] = array(	"name" 		=> BOX_OUTSTANDING_ORDERS,
											"is_main"	=> false,
											"link" 		=> xtc_href_link(FILENAME_OUTSTANDING_ORDERS, '', 'NONSSL'),
											"access"	=> "outstanding",
											"check"		=> true);
        $menu_items['marketingseo'][] = array(	"name" 		=> BOX_INVENTORY_TURNOVER,
											"is_main"	=> false,
											"link" 		=> xtc_href_link(FILENAME_INVENTORY_TURNOVER_ORDERS, '', 'NONSSL'),
											"access"	=> "inventory_turnover",
											"check"		=> true);
        $menu_items['marketingseo'][] = array(	"name" 		=> BOX_STOCK_RANGE,
                          "is_main"	=> false,
                          "link" 		=> xtc_href_link(FILENAME_STOCK_RANGE, '', 'NONSSL'),
                          "access"	=> "stock_range",
                          "check"		=> true);

	$menu_items['marketingseo'][] = array(	"name" 		=> BOX_CONFIGURATION_24,
											"is_main"	=> true,
											"link" 		=> xtc_href_link(FILENAME_CONFIGURATION, 'gID=24', 'NONSSL'),
											"access"	=> "configuration",
											"check"		=> true);
											
	$menu_items['marketingseo'][] = array(	"name" 		=> BOX_CAMPAIGNS,
											"is_main"	=> true,
											"link" 		=> xtc_href_link(FILENAME_CAMPAIGNS, '', 'NONSSL'),
											"access"	=> "campaigns",
											"check"		=> true);										

	$menu_items['marketingseo'][] = array(	"name" 		=> BOX_ORDERS_XSELL_GROUP,
											"is_main"	=> true,
											"link" 		=> xtc_href_link(FILENAME_XSELL_GROUPS, '', 'NONSSL'),
											"access"	=> "cross_sell_groups",
											"check"		=> true);			

	$menu_items['marketingseo'][] = array(	"name" 		=> BOX_MODULE_EXPORT,
											"is_main"	=> true,
											"link" 		=> xtc_href_link(FILENAME_MODULE_EXPORT, '', 'NONSSL'),
											"access"	=> "module_export",
											"check"		=> true);
												
	// Setup: Configuration
	// =================================================================================================================											
	$menu_items['configuration'][] = array(	"name" 		=> BOX_BASIC_SETTINGS,
											"is_main"	=> true,
											"link" 		=> false,
											"access"	=> false,
											"check"		=> true);																
	
	$menu_items['configuration'][] = array(	"name" 		=> BOX_CONFIGURATION_1,
											"is_main"	=> false,
											"link" 		=> xtc_href_link(FILENAME_CONFIGURATION, 'gID=1', 'NONSSL'),
											"access"	=> "configuration",
											"check"		=> true);	
														
	$menu_items['configuration'][] = array(	"name" 		=> BOX_CONFIGURATION_12,
											"is_main"	=> false,
											"link" 		=> xtc_href_link(FILENAME_CONFIGURATION, 'gID=12', 'NONSSL'),
											"access"	=> "configuration",
											"check"		=> true);	
											
	$menu_items['configuration'][] = array(	"name" 		=> BOX_CONFIGURATION_18,
											"is_main"	=> false,
											"link" 		=> xtc_href_link(FILENAME_CONFIGURATION, 'gID=18', 'NONSSL'),
											"access"	=> "configuration",
											"check"		=> true);	

	$menu_items['configuration'][] = array(	"name" 		=> BOX_PRODUCTS_VPE,
											"is_main"	=> false,
											"link" 		=> xtc_href_link(FILENAME_PRODUCTS_VPE, '', 'NONSSL'),
											"access"	=> "products_vpe",
											"check"		=> true);	

	$menu_items['configuration'][] = array(	"name" 		=> BOX_PDFBILL_CONFIG,
											"is_main"	=> false,
											"link" 		=> xtc_href_link(FILENAME_PDFBILL_CONFIG, '', 'NONSSL'),
											"access"	=> "pdfbill_config",
											"check"		=> true);	
		
	$menu_items['configuration'][] = array(	"name" 		=> BOX_SERVER_SETTINGS,
											"is_main"	=> true,
											"link" 		=> false,
											"access"	=> false,
											"check"		=> true);																
														
	$menu_items['configuration'][] = array(	"name" 		=> BOX_SERVER_INFO,
											"is_main"	=> false,
											"link" 		=> xtc_href_link(FILENAME_SERVER_INFO, '', 'NONSSL'),
											"access"	=> "server_info",
											"check"		=> true);								

	$menu_items['configuration'][] = array(	"name" 		=> BOX_CONFIGURATION_10,
											"is_main"	=> false,
											"link" 		=> xtc_href_link(FILENAME_CONFIGURATION, 'gID=10', 'NONSSL'),
											"access"	=> "configuration",
											"check"		=> true);	
											
	$menu_items['configuration'][] = array(	"name" 		=> BOX_CONFIGURATION_11,
											"is_main"	=> false,
											"link" 		=> xtc_href_link(FILENAME_CONFIGURATION, 'gID=11', 'NONSSL'),
											"access"	=> "configuration",
											"check"		=> true);	
											
	$menu_items['configuration'][] = array(	"name" 		=> BOX_CONFIGURATION_14,
											"is_main"	=> false,
											"link" 		=> xtc_href_link(FILENAME_CONFIGURATION, 'gID=14', 'NONSSL'),
											"access"	=> "configuration",
											"check"		=> true);		
											
	$menu_items['configuration'][] = array(	"name" 		=> BOX_CONFIGURATION_15,
											"is_main"	=> false,
											"link" 		=> xtc_href_link(FILENAME_CONFIGURATION, 'gID=15', 'NONSSL'),
											"access"	=> "configuration",
											"check"		=> true);		
											
	$menu_items['configuration'][] = array(	"name" 		=> BOX_CONFIGURATION_9,
											"is_main"	=> true,
											"link" 		=> xtc_href_link(FILENAME_CONFIGURATION, 'gID=9', 'NONSSL'),
											"access"	=> "configuration",
											"check"		=> true);			
	
	$menu_items['configuration'][] = array(	"name" 		=> BOX_CONFIGURATION_17,
											"is_main"	=> true,
											"link" 		=> xtc_href_link(FILENAME_CONFIGURATION, 'gID=17', 'NONSSL'),
											"access"	=> "configuration",
											"check"		=> true);																														

	$menu_items['configuration'][] = array(	"name" 		=> false, "is_main"	=> true);
		
	$menu_items['configuration'][] = array(	"name" 		=> BOX_LANGUAGES,
											"is_main"	=> true,
											"link" 		=> xtc_href_link(FILENAME_LANGUAGES, '', 'NONSSL'),
											"access"	=> "languages",
											"check"		=> true);
	
	$menu_items['configuration'][] = array(	"name" 		=> BOX_HEADING_ZONE,
											"is_main"	=> true,
											"link" 		=> false,
											"access"	=> false,
											"check"		=> true);																
														
																				
	$menu_items['configuration'][] = array(	"name" 		=> BOX_COUNTRIES,
											"is_main"	=> false,
											"link" 		=> xtc_href_link(FILENAME_COUNTRIES, '', 'NONSSL'),
											"access"	=> "countries",
											"check"		=> true);
																				
	$menu_items['configuration'][] = array(	"name" 		=> BOX_CURRENCIES,
											"is_main"	=> false,
											"link" 		=> xtc_href_link(FILENAME_CURRENCIES, '', 'NONSSL'),
											"access"	=> "currencies",
											"check"		=> true);
																				
	$menu_items['configuration'][] = array(	"name" 		=> BOX_ZONES,
											"is_main"	=> false,
											"link" 		=> xtc_href_link(FILENAME_ZONES, '', 'NONSSL'),
											"access"	=> "zones",
											"check"		=> true);
																				
	$menu_items['configuration'][] = array(	"name" 		=> BOX_GEO_ZONES,
											"is_main"	=> false,
											"link" 		=> xtc_href_link(FILENAME_GEO_ZONES, '', 'NONSSL'),
											"access"	=> "geo_zones",
											"check"		=> true);
																				
	$menu_items['configuration'][] = array(	"name" 		=> BOX_TAX_CLASSES,
											"is_main"	=> false,
											"link" 		=> xtc_href_link(FILENAME_TAX_CLASSES, '', 'NONSSL'),
											"access"	=> "tax_classes",
											"check"		=> true);
																				
	$menu_items['configuration'][] = array(	"name" 		=> BOX_TAX_RATES,
											"is_main"	=> false,
											"link" 		=> xtc_href_link(FILENAME_TAX_RATES, '', 'NONSSL'),
											"access"	=> "tax_rates",
											"check"		=> true);		
											
	$menu_items['configuration'][] = array(	"name" 		=> false, "is_main"	=> true);							
											
	$menu_items['configuration'][] = array(	"name" 		=> BOX_SHIPPING_AND_PAYMENT,
											"is_main"	=> true,
											"link" 		=> false,
											"access"	=> false,
											"check"		=> true);											
														
	$menu_items['configuration'][] = array(	"name" 		=> BOX_SHIPPING,
											"is_main"	=> false,
											"link" 		=> xtc_href_link(FILENAME_MODULES, 'set=shipping', 'NONSSL'),
											"access"	=> "modules",
											"check"		=> true);
	
	$menu_items['configuration'][] = array(	"name" 		=> BOX_CONFIGURATION_7,
											"is_main"	=> false,
											"link" 		=> xtc_href_link(FILENAME_CONFIGURATION, 'gID=7', 'NONSSL'),
											"access"	=> "configuration",
											"check"		=> true);
	
	$menu_items['configuration'][] = array(	"name" 		=> BOX_PARCEL_CARRIERS,
											"is_main"	=> false,
											"link" 		=> xtc_href_link(FILENAME_PARCEL_CARRIERS, '', 'NONSSL'),
											"access"	=> "parcel_carriers",
											"check"		=> true);
														
	$menu_items['configuration'][] = array(	"name" 		=> BOX_PAYMENT,
											"is_main"	=> false,
											"link" 		=> xtc_href_link(FILENAME_MODULES, 'set=payment', 'NONSSL'),
											"access"	=> "modules",
											"check"		=> true);
														
	$menu_items['configuration'][] = array(	"name" 		=> BOX_ORDER_TOTAL,
											"is_main"	=> false,
											"link" 		=> xtc_href_link(FILENAME_MODULES, 'set=ordertotal', 'NONSSL'),
											"access"	=> "modules",
											"check"		=> true);
    
  ## PayPal
	include(DIR_FS_EXTERNAL.'paypal/modules/column_left.php');  
	
	$menu_items['configuration'][] = array(	"name" 		=> BOX_ORDERS_STATUS,
											"is_main"	=> true,
											"link" 		=> xtc_href_link(FILENAME_ORDERS_STATUS, '', 'NONSSL'),
											"access"	=> "orders_status",
											"check"		=> true);	
											
	$menu_items['configuration'][] = array(	"name" 		=> BOX_SHIPPING_STATUS,
											"is_main"	=> true,
											"link" 		=> xtc_href_link(FILENAME_SHIPPING_STATUS, '', 'NONSSL'),
											"access"	=> "shipping_status",
											"check"		=> ACTIVATE_SHIPPING_STATUS);											
																						
	$menu_items['configuration'][] = array(	"name" 		=> BOX_FRONTEND,
											"is_main"	=> true,
											"link" 		=> false,
											"access"	=> false,
											"check"		=> true);											
	
	$menu_items['configuration'][] = array(	"name" 		=> BOX_CONFIGURATION_5,
											"is_main"	=> false,
											"link" 		=> xtc_href_link(FILENAME_CONFIGURATION, 'gID=5', 'NONSSL'),
											"access"	=> "configuration",
											"check"		=> true);
											
	$menu_items['configuration'][] = array(	"name" 		=> BOX_CONFIGURATION_2,
											"is_main"	=> false,
											"link" 		=> xtc_href_link(FILENAME_CONFIGURATION, 'gID=2', 'NONSSL'),
											"access"	=> "configuration",
											"check"		=> true);
	
	$menu_items['configuration'][] = array(	"name" 		=> BOX_CONFIGURATION_4,
											"is_main"	=> false,
											"link" 		=> xtc_href_link(FILENAME_CONFIGURATION, 'gID=4', 'NONSSL'),
											"access"	=> "configuration",
											"check"		=> true);
																																		
	$menu_items['configuration'][] = array(	"name" 		=> BOX_CONFIGURATION_40,
											"is_main"	=> false,
											"link" 		=> xtc_href_link(FILENAME_CONFIGURATION, 'gID=40', 'NONSSL'),
											"access"	=> "configuration",
											"check"		=> true);
	
	$menu_items['configuration'][] = array(	"name" 		=> BOX_CONFIGURATION_8,
											"is_main"	=> false,
											"link" 		=> xtc_href_link(FILENAME_CONFIGURATION, 'gID=8', 'NONSSL'),
											"access"	=> "configuration",
											"check"		=> true);				
											
	$menu_items['configuration'][] = array(	"name" 		=> BOX_CONFIGURATION_3,
											"is_main"	=> false,
											"link" 		=> xtc_href_link(FILENAME_CONFIGURATION, 'gID=3', 'NONSSL'),
											"access"	=> "configuration",
											"check"		=> true);			
											
	$menu_items['configuration'][] = array(	"name" 		=> BOX_CONFIGURATION_22,
											"is_main"	=> false,
											"link" 		=> xtc_href_link(FILENAME_CONFIGURATION, 'gID=22', 'NONSSL'),
											"access"	=> "configuration",
											"check"		=> true);
    
  $menu_items['configuration'][] = array(	"name" 		=> BOX_CONFIGURATION_25,
											"is_main"	=> false,
											"link" 		=> xtc_href_link(FILENAME_CONFIGURATION, 'gID=25', 'NONSSL'),
											"access"	=> "configuration",
											"check"		=> true);  
    
  $menu_items['configuration'][] = array(	"name" 		=> BOX_CONFIGURATION_1000,
											"is_main"	=> true,
											"link" 		=> xtc_href_link(FILENAME_CONFIGURATION, 'gID=1000', 'NONSSL'),
											"access"	=> "configuration",
											"check"		=> true);
											
	$menu_items['configuration'][] = array(	"name" 		=> BOX_CONFIGURATION_19,
											"is_main"	=> true,
											"link" 		=> xtc_href_link(FILENAME_CONFIGURATION, 'gID=19', 'NONSSL'),
											"access"	=> "configuration",
											"check"		=> true);
																					
	$menu_items['configuration'][] = array(	"name" 		=> false, "is_main"	=> true);
	
	$menu_items['configuration'][] = array(	"name" 		=> BOX_MAINTAINANCE,
											"is_main"	=> true,
											"link" 		=> false,
											"access"	=> false,
											"check"		=> true);																
														
	$menu_items['configuration'][] = array(	"name" 		=> BOX_SHOP_ON_OFF,
											"is_main"	=> false,
											"link" 		=> xtc_href_link('shop_offline.php', '', 'NONSSL'),
											"access"	=> "shop_offline",
											"check"		=> true);																																							
											
	$menu_items['configuration'][] = array(	"name" 		=> BOX_BACKUP,
											"is_main"	=> false,
											"link" 		=> xtc_href_link(FILENAME_BACKUP, '', 'NONSSL'),
											"access"	=> "backup",
											"check"		=> true);																																															

//echo '<nav class="navbar navbar-default navbar-fixed-top"><div class="container-fluid"><div class="navbar-header"><a class="navbar-brand" href="' . xtc_href_link('start.php', '', 'NONSSL') . '"><img class="img-responsive" style="height: 40px;" src="images/shophelferlogo.png" /></a></div>';

echo '<div class="collapse navbar-collapse" id="navbar"><ul class="nav navbar-nav">';
//---------------------------STARTSEITE

foreach ($menues as $menu) {
	
	echo ('<li class="dropdown">');
	  echo ('<a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">'.$menu["name"].' <span class="caret"></span></a>');
	echo ('<ul class="dropdown-menu" role="menu">');
		$last_is_main = true;
		foreach ($menu_items[$menu["array"]] as $menue_item) {
			
			if ($last_is_main == false && $menue_item['is_main'] == true) {
				echo "</ul></li>";
				$last_is_main = true;
			}
			
			if ($menue_item['name'] != false) {
				
				if ($menue_item['link'] != false && $admin_access[$menue_item['access']] == '1' && $menue_item['check'] == 'true') {
					echo '<li><a href="' . $menue_item['link'] . '">' . $menue_item['name'] . '</a></li>';
					$last_is_main = $menue_item['is_main'];
				} else if ($menue_item['link'] == false && $menue_item['check'] == 'true') {
					echo '<li class="dropdown-submenu"><a tabindex="0" data-toggle="dropdown">' . $menue_item['name'] . '</a>';
					echo '<ul class="dropdown-menu">';
					$last_is_main = $menue_item['is_main'];
				}
			} else {
			
				echo '<li class="divider"></li>';
				$last_is_main = $menue_item['is_main'];
				
			}
		}
		if ($last_is_main == false) {
			echo "</ul></li>";
		}
	echo ('</ul>');
	echo ('</li>'); 
	
}

echo '</ul>';
?>
		<ul class="hidden-lg nav navbar-nav navbar-right hidden-xs">
			<li class="topicon"><a href="<?php echo xtc_href_link('../index.php', '', 'NONSSL') ; ?>" data-toggle="tooltip" data-placement="bottom" title="zum Shop"><span class="glyphicon glyphicon-globe"></span></a></li>			
			<li class="topicon"><a href="<?php echo xtc_href_link('credits.php', '', 'NONSSL') ; ?>" data-toggle="tooltip" data-placement="bottom" title=" <?php echo (BOX_CREDITS) ; ?>"><span class="glyphicon glyphicon-info-sign"></span></a></li>
			<li class="topicon"><a href="http://www.shophelfer.com/wiki/index.php" target="_blank" data-toggle="tooltip" data-placement="bottom" title="Wiki"><span class="glyphicon glyphicon-book"></span></a></li>
			<li class="topicon"><a href="<?php echo xtc_href_link('../logoff.php', '', 'NONSSL') ; ?>" data-toggle="tooltip" data-placement="bottom" title=" <?php echo (BOX_LOGOUT) ; ?>"><span class="glyphicon glyphicon-log-out"></span></a></li>
		</ul>
<?php					
echo '</div>'; 
}
