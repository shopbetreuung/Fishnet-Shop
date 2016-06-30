<?php

/*
 * This is a smarty function to generate the rating stars 
 * and the number of ratings.
 * 
 * Funktion liefert Rating-Stars und Anzahl der Gesamtbewertungen pro Produkt.
 * Aufruf: 
 * {ratings pID=$PRODUCTS_ID result=stars} -> liefert Sterne
 * {ratings pID=$PRODUCTS_ID result=count} -> liefert Gesamtanzahl der Bewertungen
 * 
 * Bei Aufruf ohne result-Parameter werden nur die folgenden Smarty-Variablen gesetzt:
 *   - RATINGS -> Anzahl der Bewertungen
 *   - RATING  -> Passendes Bild mit den Sternen
 */
  require_once (DIR_FS_CATALOG . 'templates/' . CURRENT_TEMPLATE . '/source/inc/ratingStars.inc.php');
  
  function smarty_function_ratings ($params=array(), &$info_smarty) {
        $res = trim($params['result']);

	if($res == 'count') {
	return getReviewRating($params['pID']);
	} elseif ($res == 'stars') {
        return getReviewRatingStars($params['pID']);
	} else {
		$info_smarty->assign('RATING',getReviewRatingStars($params['pID']));
        $info_smarty->assign('RATINGS', getReviewRating($params['pID']));
        $info_smarty->assign('RATINGSAVG', getReviewRatingAVG($params['pID']));
    }
}
?>
