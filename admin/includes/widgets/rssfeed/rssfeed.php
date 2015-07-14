<?php

	require_once (DIR_FS_INC.'get_external_content.inc.php');
	define('RSS_FEED_TITLE', 'Shophelfer Ankündigungen');
	define('RSS_FEED_DESCRIPTION', 'Shophelfer - Forum - Ankündigungen');
	define('RSS_FEED_LINK', 'http://www.shophelfer.com/index.php?action=forum');
	define('RSS_FEED_ALTERNATIVE', 'Leider k&ouml;nnen die aktuellen Neuigkeiten nicht im RSS Feed dargestellt werden. Bitte besuchen sie unsere Community unter <a href="'.RSS_FEED_LINK.'">www.shophelfer.com</a> um wichtige Informationen f&uuml;r Shopbetreiber zu diesen Themen zu erfahren: <ul><li>Wichtige Updates und Fixes</li><li>Funktionserweiterungen</li><li>Rechtssprechungen</li><li>Neuigkeiten</li><li>Klatsch und Tratsch</li></ul>');


?>

	    <table border="0" width="98%" cellspacing="0" cellpadding="0">
        <?php        
        $feed = get_external_content('http://www.shophelfer.com/index.php?action=.xml;type=rss&board=23.0', 2);    
        if ($feed && class_exists('SimpleXmlElement')) {
          $rss = new SimpleXmlElement($feed, LIBXML_NOCDATA);
          $rss->addAttribute('encoding', 'UTF-8');
          ?>
          <div style="background:#F0F1F1;font-size:11px; border:1px solid #999; padding:5px; font-weight: 700" align="left">
            <a target="_blank" href="<?php echo $rss->channel->link; ?>"><?php echo utf8_decode($rss->channel->title); ?></a>
            <br/>
            <?php echo utf8_decode($rss->channel->description); ?>
          </div>
          <br/>
          <?php        
          for ($i=0; $i<=3; $i++) {
          ?>
            <div class="feedtitle" align="left" style="padding:5px;font-size:11px;">
              <a target="_blank" href="<?php echo $rss->channel->item[$i]->link; ?>"><?php echo utf8_decode($rss->channel->item[$i]->title); ?></a>
              <br/>
              <?php echo utf8_decode($rss->channel->item[$i]->description); ?>
            </div>
            <hr noshade="noshade">
          <?php
          }
        } else {
        ?>
          <div style="background:#F0F1F1;font-size:11px; border:1px solid #999; padding:5px; font-weight: 700" align="left">
            <a target="_blank" href="<?php echo RSS_FEED_LINK; ?>"><?php echo RSS_FEED_TITLE; ?></a>
            <br/>
            <?php echo RSS_FEED_DESCRIPTION; ?>
          </div>
          <br/>
          <div class="feedtitle" align="left" style="padding:5px;font-size:11px;">
            <?php echo RSS_FEED_ALTERNATIVE; ?>
          </div>
        <?php  
        }
        ?>
      </table>
