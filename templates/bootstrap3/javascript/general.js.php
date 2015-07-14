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
<script src="<?php echo 'templates/'.CURRENT_TEMPLATE; ?>/javascript/bootstrap.min.js" type="text/javascript"></script>
<script src="<?php echo 'templates/'.CURRENT_TEMPLATE; ?>/javascript/bootstrap-add.js" type="text/javascript"></script>
<script src="<?php echo 'templates/'.CURRENT_TEMPLATE; ?>/javascript/ekko-lightbox.min.js" type="text/javascript"></script>

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
