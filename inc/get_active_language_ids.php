<?php

function get_active_language_ids() {
    $languages_query = xtc_db_query("select languages_id from ".TABLE_LANGUAGES." where status = '1' order by sort_order");
    while ($languages = xtc_db_fetch_array($languages_query)) {
        $languages_array[] = array ('id' => $languages['languages_id']);
    }
        return $languages_array;
}

?>