<?php
/* -----------------------------------------------------------------------------------------
   $Id: xtc_image_button.inc.php 899 2005-04-29 02:40:57Z hhgag $   

   XT-Commerce - community made shopping
   http://www.xt-commerce.com

   Copyright (c) 2003 XT-Commerce
   -----------------------------------------------------------------------------------------
   based on: 
   (c) 2000-2001 The Exchange Project  (earlier name of osCommerce)
   (c) 2002-2003 osCommerce(html_output.php,v 1.52 2003/03/19); www.oscommerce.com 
   (c) 2003	 nextcommerce (xtc_image_button.inc.php,v 1.3 2003/08/13); www.nextcommerce.org

   Released under the GNU General Public License 
   ---------------------------------------------------------------------------------------*/
   
// Output a function button in the selected language
function xtc_image_button($image, $alt = '', $parameters = '', $submit = false) {

    if (USE_BOOTSTRAP == "true") {

    $name           = $image;
    $html           = '';
    $title          = xtc_parse_input_field_data($alt, array('"' => '&quot;'));
    
    // Erklärung: es wird geprüft, welches Buttonbild von Modified aufgerufen wird. Dementsprechend werden neue Attribute zugewiesen.
    // z.B. dem Buttonbild 'button_buy_now.gif' wird zugewiesen:
    //      'Image' => '' (kein Bild - vergleiche cart_del.gif, dort wird das Bild cart_del.gif zugewiesen, damit bleibt der Button ein Bildbutton).
    //      'Text' => IMAGE_BUTTON_IN_CART (der Text der auf dem neuen Button angezeigt wird, in der Regel der Text der Modifiedvariablen '$alt', in unserem Beispiel der Text der in der Languagedatei 'IMAGE_BUTTON_IN_CART' zugewiesen wurde).
    //      'icon' => 'glyphicon glyphicon-shopping-cart' (das Icon das im Button angezeigt wird - in der Bootstrapdokumentation unter 'Icons by Glyphicons' kann man diese aussuchen).
    //      'iconposition' => 'iconleft' (die Position des Icons im Button - 'iconleft' = links vom Text, 'iconright' = rechts vom Text).
    //      'Class' => '' (hier kann dem Button noch eine zusätzliche CSS-Klasse zugewiesen werden).
    /* Buttons array */
    if (CURRENT_TEMPLATE == 'bootstrap4-hor' || CURRENT_TEMPLATE == 'bootstrap4') { 
    $buttons = array(
    'default'                       => array('Image' => '',                       'Text' => $alt,                           'icon' => '',                     'iconposition' => '',             'Class' => 'btn-secondary'),
    'button_add_address.gif'        => array('Image' => '',                       'Text' => $alt,                           'icon' => 'fas fa-edit',            'iconposition' => 'iconleft',     'Class' => 'btn-secondary'),
    'button_add_quick.gif'          => array('Image' => '',                       'Text' => IMAGE_BUTTON_IN_CART,           'icon' => 'fas fa-shopping-cart',   'iconposition' => 'iconleft',     'Class' => 'btn-primary'),
    'button_admin.gif'              => array('Image' => '',                       'Text' => $alt,                           'icon' => 'fas fa-wrench',          'iconposition' => 'iconleft',     'Class' => 'btn-secondary'),
    'button_back.gif'               => array('Image' => '',                       'Text' => $alt,                           'icon' => 'fas fa-arrow-left',      'iconposition' => 'iconleft',     'Class' => 'btn-secondary'),
    'button_buy_now.gif'            => array('Image' => '',                       'Text' => IMAGE_BUTTON_IN_CART,           'icon' => 'fas fa-shopping-cart',   'iconposition' => 'iconleft',     'Class' => 'btn-primary'),
    'button_change_address.gif'     => array('Image' => '',                       'Text' => $alt,                           'icon' => 'fas fa-edit',            'iconposition' => 'iconleft',     'Class' => 'btn-secondary'),
    'button_checkout.gif'           => array('Image' => '',                       'Text' => $alt,                           'icon' => 'fas fa-check',           'iconposition' => 'iconright',    'Class' => 'btn-primary'),
    'button_confirm.gif'            => array('Image' => '',                       'Text' => $alt,                           'icon' => 'fas fa-check',           'iconposition' => 'iconright',    'Class' => 'btn-secondary'),
    'button_confirm_order.gif'      => array('Image' => '',                       'Text' => $alt,                           'icon' => 'fas fa-check',           'iconposition' => 'iconright',    'Class' => 'btn-success'),
    'button_continue.gif'           => array('Image' => '',                       'Text' => $alt,                           'icon' => 'fas fa-arrow-right',     'iconposition' => 'iconright',    'Class' => 'btn-primary'),
    'button_continue_shopping.gif'  => array('Image' => '',                       'Text' => $alt,                           'icon' => 'fas fa-arrow-left',      'iconposition' => 'iconleft',     'Class' => 'btn-secondary'),
    'button_delete.gif'             => array('Image' => '',                       'Text' => $alt,                           'icon' => 'fas fa-remove',          'iconposition' => 'iconleft',     'Class' => 'btn-secondary'),
    'button_download.gif'           => array('Image' => '',                       'Text' => $alt,                           'icon' => 'fas fa-download',        'iconposition' => 'iconleft',     'Class' => 'btn-secondary'),
    'button_login.gif'              => array('Image' => '',                       'Text' => $alt,                           'icon' => 'fas fa fa-user',         'iconposition' => 'iconleft',     'Class' => 'btn-primary'),
    'button_logoff.gif'             => array('Image' => '',                       'Text' => $alt,                           'icon' => '',                       'iconposition' => '',             'Class' => 'btn-secondary'),
    'button_in_cart.gif'            => array('Image' => '',                       'Text' => $alt,                           'icon' => 'fas fa-shopping-cart',   'iconposition' => 'iconleft',     'Class' => 'btn-primary'),
    'button_login_newsletter.gif'   => array('Image' => '',                       'Text' => $alt,                           'icon' => 'fas fa-check',           'iconposition' => 'iconleft',     'Class' => 'btn-secondary'),
    'button_print.gif'              => array('Image' => '',                       'Text' => $alt,                           'icon' => 'fas fa-print',           'iconposition' => 'iconleft',     'Class' => 'btn-secondary'),
    'button_product_more.gif'       => array('Image' => '',                       'Text' => IMAGE_BUTTON_PRODUCT_MORE,      'icon' => 'fas fa-info',          'iconposition' => 'iconleft',     'Class' => 'btn-secondary'),
    'button_quick_find.gif'         => array('Image' => '',                       'Text' => $alt,                           'icon' => 'fas fa-search',          'iconposition' => 'iconleft',     'Class' => 'btn-secondary'),
    'button_redeem.gif'             => array('Image' => '',                       'Text' => $alt,                           'icon' => 'fas fa-asterisk',        'iconposition' => 'iconleft',     'Class' => 'btn-secondary'),
    'button_search.gif'             => array('Image' => '',                       'Text' => $alt,                           'icon' => 'fas fa-search',          'iconposition' => 'iconleft',     'Class' => 'btn-secondary'),
    'button_send.gif'               => array('Image' => '',                       'Text' => $alt,                           'icon' => 'fas fa-check',           'iconposition' => 'iconleft',     'Class' => 'btn-secondary'),
    'button_login_small.gif'        => array('Image' => '',                       'Text' => $alt,                           'icon' => 'fas fa-user',            'iconposition' => 'iconleft',     'Class' => 'btn-primary'),
    'button_update.gif'             => array('Image' => '',                       'Text' => $alt,                           'icon' => 'fas fa-sync-alt',        'iconposition' => 'iconleft',     'Class' => 'btn-secondary'),
    'button_update_cart.gif'        => array('Image' => '',                       'Text' => $alt,                           'icon' => 'fas fa-sync-alt',        'iconposition' => 'iconleft',     'Class' => 'btn-secondary'),
    'button_view.gif'               => array('Image' => '',                       'Text' => $alt,                           'icon' => 'fas fa-eye-open',        'iconposition' => 'iconleft',     'Class' => 'btn-secondary'),
    'button_write_review.gif'       => array('Image' => '',                       'Text' => $alt,                           'icon' => 'fas fa-edit',            'iconposition' => 'iconleft',     'Class' => 'btn-secondary'),
    'small_edit.gif'                => array('Image' => '',                       'Text' => $alt,                           'icon' => 'fas fa-edit',            'iconposition' => 'iconleft',     'Class' => 'btn-secondary'),
    'small_delete.gif'              => array('Image' => '',                       'Text' => $alt,                           'icon' => 'fas fa-remove',          'iconposition' => 'iconright',    'Class' => 'btn-secondary'),
    'small_view.gif'                => array('Image' => '',                       'Text' => $alt,                           'icon' => 'fas fa-eye-open',        'iconposition' => 'iconright',    'Class' => 'btn-secondary'),
    'cart_del.gif'                  => array('Image' => 'cart_del.gif',           'Text' => $alt,                           'icon' => '',                       'iconposition' => '',             'Class' => 'btn-secondary'),
    'edit_product.gif'              => array('Image' => '',                       'Text' => $alt,                           'icon' => 'fas fa-edit',            'iconposition' => 'iconleft',     'Class' => 'btn-secondary'),
    'print.gif'                     => array('Image' => '',                       'Text' => TEXT_PRINT,                     'icon' => 'fas fa-print',           'iconposition' => 'iconleft',     'Class' => 'btn-secondary'),
    'button_goto_cart_gif'          => array('Image' => '',                       'Text' => $alt,                           'icon' => 'fas fa-shopping-cart',   'iconposition' => 'iconleft',     'Class' => 'btn-secondary'),
    'button_manufactors_info.gif'   => array('Image' => '',                       'Text' => $alt,                           'icon' => 'fas fa-list-alt',        'iconposition' => 'iconleft',     'Class' => 'btn-secondary'),
    );
  } else {
    $buttons = array(
    'default'                       => array('Image' => '',                       'Text' => $alt,                           'icon' => '',                     'iconposition' => '',             'Class' => 'btn-default'),
    'button_add_address.gif'        => array('Image' => '',                       'Text' => $alt,                           'icon' => 'glyphicon glyphicon-edit',            'iconposition' => 'iconleft',     'Class' => 'btn-default'),
    'button_add_quick.gif'          => array('Image' => '',                       'Text' => IMAGE_BUTTON_IN_CART,           'icon' => 'glyphicon glyphicon-shopping-cart',   'iconposition' => 'iconleft',     'Class' => 'btn-primary'),
    'button_admin.gif'              => array('Image' => '',                       'Text' => $alt,                           'icon' => 'glyphicon glyphicon-wrench',          'iconposition' => 'iconleft',     'Class' => 'btn-default'),
    'button_back.gif'               => array('Image' => '',                       'Text' => $alt,                           'icon' => 'glyphicon glyphicon-arrow-left',      'iconposition' => 'iconleft',     'Class' => 'btn-default'),
    'button_buy_now.gif'            => array('Image' => '',                       'Text' => IMAGE_BUTTON_IN_CART,           'icon' => 'glyphicon glyphicon-shopping-cart',   'iconposition' => 'iconleft',     'Class' => 'btn-primary'),
    'button_change_address.gif'     => array('Image' => '',                       'Text' => $alt,                           'icon' => 'glyphicon glyphicon-edit',            'iconposition' => 'iconleft',     'Class' => 'btn-default'),
    'button_checkout.gif'           => array('Image' => '',                       'Text' => $alt,                           'icon' => 'glyphicon glyphicon-ok',              'iconposition' => 'iconright',    'Class' => 'btn-primary'),
    'button_confirm.gif'            => array('Image' => '',                       'Text' => $alt,                           'icon' => 'glyphicon glyphicon-ok',              'iconposition' => 'iconright',    'Class' => 'btn-default'),
    'button_confirm_order.gif'      => array('Image' => '',                       'Text' => $alt,                           'icon' => 'glyphicon glyphicon-ok',              'iconposition' => 'iconright',    'Class' => 'btn-success'),
    'button_continue.gif'           => array('Image' => '',                       'Text' => $alt,                           'icon' => 'glyphicon glyphicon-arrow-right',     'iconposition' => 'iconright',    'Class' => 'btn-primary'),
    'button_continue_shopping.gif'  => array('Image' => '',                       'Text' => $alt,                           'icon' => 'glyphicon glyphicon-arrow-left',      'iconposition' => 'iconleft',     'Class' => 'btn-default'),
    'button_delete.gif'             => array('Image' => '',                       'Text' => $alt,                           'icon' => 'glyphicon glyphicon-remove',          'iconposition' => 'iconleft',     'Class' => 'btn-default'),
    'button_download.gif'           => array('Image' => '',                       'Text' => $alt,                           'icon' => 'glyphicon glyphicon-download',        'iconposition' => 'iconleft',     'Class' => 'btn-default'),
    'button_login.gif'              => array('Image' => '',                       'Text' => $alt,                           'icon' => 'glyphicon glyphicon glyphicon-user',            'iconposition' => 'iconleft',     'Class' => 'btn-primary'),
    'button_logoff.gif'             => array('Image' => '',                       'Text' => $alt,                           'icon' => '',                     'iconposition' => '',             'Class' => 'btn-default'),
    'button_in_cart.gif'            => array('Image' => '',                       'Text' => $alt,                           'icon' => 'glyphicon glyphicon-shopping-cart',   'iconposition' => 'iconleft',     'Class' => 'btn-primary'),
    'button_login_newsletter.gif'   => array('Image' => '',                       'Text' => $alt,                           'icon' => 'glyphicon glyphicon-ok',              'iconposition' => 'iconleft',     'Class' => 'btn-default'),
    'button_print.gif'              => array('Image' => '',                       'Text' => $alt,                           'icon' => 'glyphicon glyphicon-print',           'iconposition' => 'iconleft',     'Class' => 'btn-default'),
    'button_product_more.gif'       => array('Image' => '',                       'Text' => IMAGE_BUTTON_PRODUCT_MORE,                           'icon' => 'glyphicon glyphicon-info-sign',       'iconposition' => 'iconleft',     'Class' => 'btn-default'),
    'button_quick_find.gif'         => array('Image' => '',                       'Text' => $alt,                           'icon' => 'glyphicon glyphicon-search',          'iconposition' => 'iconleft',     'Class' => 'btn-default'),
    'button_redeem.gif'             => array('Image' => '',                       'Text' => $alt,                           'icon' => 'glyphicon glyphicon-asterisk',        'iconposition' => 'iconleft',     'Class' => 'btn-default'),
    'button_search.gif'             => array('Image' => '',                       'Text' => $alt,                           'icon' => 'glyphicon glyphicon-search',          'iconposition' => 'iconleft',     'Class' => 'btn-default'),
    'button_send.gif'               => array('Image' => '',                       'Text' => $alt,                           'icon' => 'glyphicon glyphicon-ok',              'iconposition' => 'iconleft',     'Class' => 'btn-default'),
    'button_login_small.gif'        => array('Image' => '',                       'Text' => $alt,                           'icon' => 'glyphicon glyphicon-user',            'iconposition' => 'iconleft',     'Class' => 'btn-primary'),
    'button_update.gif'             => array('Image' => '',                       'Text' => $alt,                           'icon' => 'glyphicon glyphicon-refresh',         'iconposition' => 'iconleft',     'Class' => 'btn-default'),
    'button_update_cart.gif'        => array('Image' => '',                       'Text' => $alt,                           'icon' => 'glyphicon glyphicon-refresh',         'iconposition' => 'iconleft',     'Class' => 'btn-default'),
    'button_view.gif'               => array('Image' => '',                       'Text' => $alt,                           'icon' => 'glyphicon glyphicon-eye-open',        'iconposition' => 'iconleft',     'Class' => 'btn-default'),
    'button_write_review.gif'       => array('Image' => '',                       'Text' => $alt,                           'icon' => 'glyphicon glyphicon-edit',            'iconposition' => 'iconleft',     'Class' => 'btn-default'),
    'small_edit.gif'                => array('Image' => '',                       'Text' => $alt,                           'icon' => 'glyphicon glyphicon-edit',            'iconposition' => 'iconleft',     'Class' => 'btn-default'),
    'small_delete.gif'              => array('Image' => '',                       'Text' => $alt,                           'icon' => 'glyphicon glyphicon-remove',          'iconposition' => 'iconright',    'Class' => 'btn-default'),
    'small_view.gif'                => array('Image' => '',                       'Text' => $alt,                           'icon' => 'glyphicon glyphicon-eye-open',        'iconposition' => 'iconright',    'Class' => 'btn-default'),
    'cart_del.gif'                  => array('Image' => 'cart_del.gif',           'Text' => $alt,                           'icon' => '',                     'iconposition' => '',             'Class' => 'btn-default'),
    'edit_product.gif'              => array('Image' => '',                       'Text' => $alt,                           'icon' => 'glyphicon glyphicon-edit',            'iconposition' => 'iconleft',     'Class' => 'btn-default'),
    'print.gif'                     => array('Image' => '',                       'Text' => TEXT_PRINT,                     'icon' => 'glyphicon glyphicon-print',           'iconposition' => 'iconleft',     'Class' => 'btn-default'),
    'button_goto_cart_gif'          => array('Image' => '',                       'Text' => $alt,                           'icon' => 'glyphicon glyphicon-shopping-cart',   'iconposition' => 'iconleft',     'Class' => 'btn-default'),
    'button_manufactors_info.gif'   => array('Image' => '',                       'Text' => $alt,                           'icon' => 'glyphicon glyphicon-list-alt',        'iconposition' => 'iconleft',     'Class' => 'btn-default'),
    );
  }

    if (!array_key_exists($name, $buttons)) {$name = 'default';}
    // kein Submitbutton
    if (!$submit)
    {
      if ($buttons[$name]['Image']) {
        $html .= xtc_image('templates/'.CURRENT_TEMPLATE.'/buttons/' . $_SESSION['language'] . '/'. $buttons[$name]['Image'], $buttons[$name]['Text'], '', '', $parameters);
      } else {
        $html .= '<span class="btn';
        if ($buttons[$name]['Class']) {
          $html .= ' '.$buttons[$name]['Class'];
        }
        if (xtc_not_null($parameters)) {
          $html .= '" '.$parameters.'>';
        } else {
          $html .= '">';
        }
        if  ($buttons[$name]['iconposition'] == 'iconleft') {
          $html .= '<i class="'.$buttons[$name]['icon'].'"></i>&nbsp;'.$buttons[$name]['Text'];
        }
        elseif ($buttons[$name]['iconposition'] == 'iconright') {
          $html .= $buttons[$name]['Text'].'&nbsp;<i class="'.$buttons[$name]['icon'].'"></i>';
        } 
        else {
          $html .= $buttons[$name]['Text'];
        }
        $html .= '</span>';
      } 
    }

    // wenn Submitbutton
    if ($submit) 
    {
      $html .= '<button class="btn';
      if ($buttons[$name]['Class']) {
        $html .= ' '.$buttons[$name]['Class'].'"';
      } else {
        $html .= '"';
      }
      if ($submit <> true) {
        $html .= ' name="'.$submit.'"';
      }
      if ($submit == true || $submit == "submit"){
        $html .= ' type="submit"';
      }
      $html .= ' title="'.$title.'"'.$parameters.'>';
      if  ($buttons[$name]['iconposition'] == 'iconleft') {
        $html .= '<i class="'.$buttons[$name]['icon'].'"></i>&nbsp;'.$buttons[$name]['Text'];
      }
      elseif ($buttons[$name]['iconposition'] == 'iconright') {
        $html .= $buttons[$name]['Text'].'&nbsp;<i class="'.$buttons[$name]['icon'].'"></i>';
      }
      else {
        $html .= $buttons[$name]['Text'];
      }
      $html .= '</button>';
    }

    return $html;

    } else {    
    return xtc_image('templates/'.CURRENT_TEMPLATE.'/buttons/' . $_SESSION['language'] . '/'. $image, $alt, '', '', $parameters);
    }
  }
 ?>
