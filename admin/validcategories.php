<?php
   /* -----------------------------------------------------------------------------------------
   $Id: validcategories.php 1316 2005-10-21 15:30:58Z mz $

   XT-Commerce - community made shopping
   http://www.xt-commerce.com

   Copyright (c) 2003 XT-Commerce
   -----------------------------------------------------------------------------------------
   based on:
   (c) 2000-2001 The Exchange Project (earlier name of osCommerce)
   (c) 2002-2003 osCommerce (validcategories.php,v 0.01 2002/08/17); www.oscommerce.com

   Released under the GNU General Public License
   -----------------------------------------------------------------------------------------
   Third Party contribution:

   Credit Class/Gift Vouchers/Discount Coupons (Version 5.10)
   http://www.oscommerce.com/community/contributions,282
   Copyright (c) Strider | Strider@oscworks.com
   Copyright (c  Nick Stanko of UkiDev.com, nick@ukidev.com
   Copyright (c) Andre ambidex@gmx.net
   Copyright (c) 2001,2002 Ian C Wilson http://www.phesis.org


   Released under the GNU General Public License
   ---------------------------------------------------------------------------------------*/


require('includes/application_top.php');

require (DIR_WS_INCLUDES.'head.php');
?>
<html>
<head>
<title>Valid Categories/Products List</title>
<link rel="stylesheet" type="text/css" href="includes/stylesheet.css">
</head>
<body style="padding-top:10px;">
<div class="row"><div class="col-xs-12">
<div class="col-xs-12">
    <p class="h2"><?php echo TEXT_VALID_CATEGORIES_LIST; ?></p>
</div>
<div class="col-xs-12">
<table class="table table-bordered table-striped">

<?php
    echo "<tr><th class=\"\">" . TEXT_VALID_CATEGORIES_ID . "</th><th class=\"\">" . TEXT_VALID_CATEGORIES_NAME . "</th></tr><tr>";
    $result = xtc_db_query("SELECT * FROM ".TABLE_CATEGORIES." c, ".TABLE_CATEGORIES_DESCRIPTION." cd WHERE c.categories_id = cd.categories_id and cd.language_id = '" . $_SESSION['languages_id'] . "' ORDER BY c.categories_id");
    if ($row = xtc_db_fetch_array($result)) {
        do {
            echo "<td class=\"\">".$row["categories_id"]."</td>\n";
            echo "<td class=\"\">".$row["categories_name"]."</td>\n";
            echo "</tr>\n";
        }
        while($row = xtc_db_fetch_array($result));
    }
    echo "</table>\n";
?>
</table>
<br />
</div>
<div class="col-xs-12 text-center"><input type="button" value="Close Window" onclick="window.close()"></div>
</div></div>
</body>
</html>
