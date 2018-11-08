<?php
/* -----------------------------------------------------------------------------------------
   $Id: general.js.php 1262 2005-09-30 10:00:32Z mz $

   XT-Commerce - community made shopping
   http://www.xt-commerce.com

   Copyright (c) 2003 XT-Commerce
   -----------------------------------------------------------------------------------------
   Released under the GNU General Public License
   ---------------------------------------------------------------------------------------*/


   // this javascriptfile get includes at the BOTTOM of every template page in shop
   // you can add your template specific js scripts here
?>
<script src="<?php echo 'templates/'.CURRENT_TEMPLATE; ?>/javascript/jquery.js" type="text/javascript"></script>
<script src="<?php echo 'templates/'.CURRENT_TEMPLATE; ?>/javascript/popper.min.js" type="text/javascript"></script>
<script src="<?php echo 'templates/'.CURRENT_TEMPLATE; ?>/javascript/bootstrap.min.js" type="text/javascript"></script>
<script src="<?php echo 'templates/'.CURRENT_TEMPLATE; ?>/javascript/bootstrap-add.js" type="text/javascript"></script>
<script src="<?php echo 'templates/'.CURRENT_TEMPLATE; ?>/javascript/fontawesome-solid.js" type="text/javascript"></script>
<script src="<?php echo 'templates/'.CURRENT_TEMPLATE; ?>/javascript/fontawesome.js" type="text/javascript"></script>
<script src="<?php echo 'templates/'.CURRENT_TEMPLATE; ?>/javascript/ekko-lightbox.min.js" type="text/javascript"></script>

<?php	
	if (!empty(INSERT_RECAPTCHA_KEY) && !empty(RECAPTCHA_SECRET_KEY)) {
?>
	<script src="https://www.google.com/recaptcha/api.js" type="text/javascript"></script>
<?php
	}
?>

<?php if (SHOW_COOKIE_NOTE == 'true') {
	if (is_numeric(COOKIE_NOTE_CONTENT_ID) && COOKIE_NOTE_CONTENT_ID != 0) {
		$cookie_content_link = xtc_href_link(FILENAME_CONTENT, 'coID='.COOKIE_NOTE_CONTENT_ID);
	} else {
		$cookie_content_link = NULL;
	}
?>
<script src="<?php echo 'templates/'.CURRENT_TEMPLATE; ?>/javascript/cookieconsent.min.js"></script>
<script type="text/javascript">
    window.cookieconsent_options = {"message":"<?php echo COOKIE_NOTE_TEXT; ?>","dismiss":"<?php echo COOKIE_NOTE_DISMISS_TEXT; ?>","learnMore":"<?php echo COOKIE_NOTE_MORE_TEXT; ?>","link":"<?php echo $cookie_content_link; ?>","theme":"light-top"};
</script>
<?php
   }
?>

<?php
if (strstr($PHP_SELF, FILENAME_PRODUCT_INFO ) && 1==2) {
?>
<script type="text/javascript">
/* <![CDATA[ */
	$('#myTabs a').click(function (e) {
	  e.preventDefault()
	  $(this).tab('show')
	})
/*]]>*/
</script>
<?php
}
?>

<script type="text/javascript">
	$(document).ready(function ($) {
		// delegate calls to data-toggle="lightbox"
		$(document).delegate('*[data-toggle="lightbox"]:not([data-gallery="navigateTo"])', 'click', function(event) {
			event.preventDefault();
			return $(this).ekkoLightbox({
				onShown: function() {
					if (window.console) {
						return console.log('Checking our the events huh?');
					}
				},
				onNavigate: function(direction, itemIndex) {
					if (window.console) {
						return console.log('Navigating '+direction+'. Current item: '+itemIndex);
					}
				}
			});
		});
	});
</script>

<script type="text/javascript">
	$(document).ready(function() {
		$(".click_arrow").click(function() {
			if ($(this).children('.arrow').hasClass("arrow-down")) {
				$(this).siblings(".subcategories").show("normal");
				$(this).siblings("ul").show("normal");
				$(this).children('.arrow').removeClass("arrow-down");
				$(this).children('.arrow').addClass("arrow-up");	
			} else {
				$(this).siblings(".subcategories").hide("normal");
				$(this).siblings("ul").hide("normal");
				$(this).children('.arrow').removeClass("arrow-up");
				$(this).children('.arrow').addClass("arrow-down");
			}
		});
	});
</script>