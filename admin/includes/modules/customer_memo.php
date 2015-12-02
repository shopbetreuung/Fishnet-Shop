<?php
/* --------------------------------------------------------------
   $Id: customer_memo.php 955 2005-05-19 09:58:02Z novalis $

   XT-Commerce - community made shopping
   http://www.xt-commerce.com

   Copyright (c) 2003 XT-Commerce


   Released under the GNU General Public License 
   --------------------------------------------------------------
   based on:
   (c) 2003	 nextcommerce (customer_memo.php,v 1.6 2003/08/18); www.nextcommerce.org
   
   --------------------------------------------------------------*/
defined( '_VALID_XTC' ) or die( 'Direct Access to this location is not allowed.' );

?>
<div class="main col-xs-12 col-sm-2"><?php echo ENTRY_MEMO; ?></div>
    <div class="main col-xs-12 col-sm-10"><?php
  $memo_query = xtc_db_query("SELECT
                                  *
                              FROM
                                  " . TABLE_CUSTOMERS_MEMO . "
                              WHERE
                                  customers_id = '" . $_GET['cID'] . "'
                              ORDER BY
                                  memo_date DESC");
  while ($memo_values = xtc_db_fetch_array($memo_query)) {
    $poster_query = xtc_db_query("SELECT customers_firstname, customers_lastname FROM " . TABLE_CUSTOMERS . " WHERE customers_id = '" . $memo_values['poster_id'] . "'");
    $poster_values = xtc_db_fetch_array($poster_query);
?><div class="col-xs-12">
      <div class="col-xs-12">
        <div class="main col-xs-12 col-sm-2"><strong><?php echo TEXT_DATE; ?></strong>:<i><?php echo $memo_values['memo_date']; ?></i><strong><?php echo TEXT_TITLE; ?></strong>:<?php echo $memo_values['memo_title']; ?><strong>  <?php echo TEXT_POSTER; ?></strong>:<?php echo $poster_values['customers_lastname']; ?> <?php echo $poster_values['customers_firstname']; ?></div>
      </div>
      <div class="col-xs-12">
        <div width="142" class="main col-xs-12 col-sm-10" style="border: 1px solid; border-color: #cccccc;"><?php echo $memo_values['memo_text']; ?></div>
      </div>
      <div class="col-xs-12">        
        <a href="<?php echo xtc_href_link(FILENAME_CUSTOMERS, 'cID=' . $_GET['cID'] . '&action=edit&special=remove_memo&mID=' . $memo_values['memo_id']); ?>" class="btn btn-default" onclick="return confirm('<?php echo DELETE_ENTRY; ?>')"><?php echo BUTTON_DELETE; //DokuMan - 2011-07-18 - fixed delete memo button ?></a>
      </div>
    </div>
<?php
  }
?>
<div class="col-xs-10">
  <div class="main col-xs-12 col-sm-10" style="border-top: 1px solid; border-color: #cccccc;"><strong><?php echo TEXT_TITLE ?></strong>:<?php echo xtc_draw_input_field('memo_title'); ?><br /><?php echo xtc_draw_textarea_field('memo_text', 'soft', '80', '5'); ?><br /><input type="submit" class="btn btn-default" value="<?php echo BUTTON_INSERT; ?>"></div>
</div>