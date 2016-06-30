<?php

/*
 * Smarty-plugIn in template path
 * for rating stars
 * 
 * Funktionen werden von TEMPLATE/smarty/function.ratings.php verwendet
 * 
 * Sie liefern entweder die Bewertungssterne oder die Anzahl der Bewertungen
 * zurück.
 */

  function getReviewRatingAVG($pID) {
	  
        $rating_query = xtDBquery("SELECT AVG(r.reviews_rating) as avgrating
                                  FROM " . TABLE_REVIEWS . " r
                                  WHERE r.products_id = '" . $pID . "'");
        $rating = xtc_db_fetch_array($rating_query, true);
        //Sterne-Symbol passend wählen	  
	  
	  if($rating['avgrating'] == "") {
		return 0;
	  } else {
		return $rating['avgrating'];
	  }
  }

  function getReviewRatingStars($pID) {
        //Bewertungswert auslesen und Schnitt berechnen
        $rating_query = xtDBquery("SELECT AVG(r.reviews_rating) as avgrating
                                  FROM " . TABLE_REVIEWS . " r
                                  WHERE r.products_id = '" . $pID . "'");
        $rating = xtc_db_fetch_array($rating_query, true);
        //Sterne-Symbol passend wählen
        if($rating['avgrating'] == "") {
        $bewertung = xtc_image('templates/'.CURRENT_TEMPLATE.'/img/stars_0.gif', '0', '', '','class="rating"');
        } else {
        $bewertung = xtc_image('templates/'.CURRENT_TEMPLATE.'/img/stars_'.round($rating['avgrating']).'.gif', round($rating['avgrating']),'', '','class="rating"');
        }
        //Sternbild zurück liefern
        return $bewertung;
  }

  function getReviewRating($pID) {
        //Auslesen und Bewertung von Bewertungsanzahl
        $reviews_query = xtDBquery("SELECT round(sum(r.products_id) / (r.products_id)) as rating
                                    FROM ".TABLE_REVIEWS." r
                                    WHERE r.products_id = '" . $pID . "'");
        $reviews = xtc_db_fetch_array($reviews_query);
        
        if($reviews['rating'] == "") {
            $bewertung_anzahl = ('0');
        } else {
            $bewertung_anzahl = ($reviews['rating']);
        }
        return $bewertung_anzahl;
  }
?>
