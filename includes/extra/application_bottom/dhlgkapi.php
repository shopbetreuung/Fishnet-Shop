<?php     
if (defined('MODULE_SHIPPING_DHLGKAPI_STATUS') && MODULE_SHIPPING_DHLGKAPI_STATUS == 'True') {
    include (DIR_WS_LANGUAGES. $_SESSION['language'].'/admin/dhlgkapi_print_label.php');
    if (defined('MODULE_SHIPPING_DHLGKAPI_PSF_ENABLED') && MODULE_SHIPPING_DHLGKAPI_PSF_ENABLED == 'True') {
        //Parcelshopfinder  einblenden
        if (strstr($_SERVER["PHP_SELF"],'checkout_shipping_address')) {
            $smarty = new Smarty();
            $smarty->assign('language', $_SESSION['language']);

            if (isset($_POST['country']) && $_POST['country']) {
                $selected = $_POST['country'];
            } else {
                $selected = STORE_COUNTRY;
            }

            $countries_list=xtc_get_countriesList(null);
            $country_with_iso=array();
            foreach ($countries_list as $country) {
                $country_iso=xtc_get_countriesList($country['countries_id'], true); 
                $countries_with_iso[$country_iso['countries_iso_code_2']]=$country['countries_id'];
            }
            $countries_with_iso_js = json_encode($countries_with_iso);

            $smarty->assign('JS_COUNTRIES_ARRAY', $countries_with_iso_js);

            $smarty->assign('PSF_HEADING', MODULE_SHIPPING_DHLGKAPI_PSF_HEADING);
            $smarty->assign('PSF_TEXT', MODULE_SHIPPING_DHLGKAPI_PSF_TEXT);
            $smarty->assign('PSF_BUTTON', MODULE_SHIPPING_DHLGKAPI_PSF_BUTTON2);

            $dhlgkapi_psf_content = $smarty->fetch(CURRENT_TEMPLATE . '/module/dhlgkapi_psf.html');

            echo $dhlgkapi_psf_content;
        }  
    }

    //Klartext Wunschpaket in Checkout Confirmation
    if (strstr($_SERVER["PHP_SELF"],'checkout_confirmation')) {

        $smarty = new Smarty();
        $smarty->assign('language', $_SESSION['language']);

        $smarty->assign('REPLACE_SEARCH', MODULE_SHIPPING_DHLGKAPI_REPLACE_SEARCH);
        $smarty->assign('REPLACE_REPLACE', MODULE_SHIPPING_DHLGKAPI_REPLACE_REPLACE);

        $dhlgkapi_content = $smarty->fetch(CURRENT_TEMPLATE . '/module/dhlgkapi_replace_text.html');

        echo $dhlgkapi_content;

    }
?>

    <script type="text/javascript">
        $(document).ready(function() {
            $("head").append('<meta name="5654fadirD585DDB8TD" content="Yes" />');
        });
    </script>

    <!-- DHLGKAPI2 -->

<?php
}
?>
