<?php

require ('includes/application_top.php');

require (DIR_WS_INCLUDES.'head.php');
?>


    <style type="text/css">

      .gridster li header {
        background: #999;
        display: block;
        font-size: 20px;
        line-height: normal;
        padding: 4px 0 6px ;
        margin-bottom: 20px;
        cursor: move;
      }
      
.gridster * {
  margin:0;
  padding:0;
}

ul {
  list-style-type: none;
}



/*/
/* gridster
/*/

.gridster ul {
    background-color: #EFEFEF;
}

.gridster li {
    font-size: 1em;
    font-weight: bold;
    text-align: center;
    line-height: 100%;
}


.gridster {
    margin: 0 auto;

    opacity: .8;

    -webkit-transition: opacity .6s;
    -moz-transition: opacity .6s;
    -o-transition: opacity .6s;
    -ms-transition: opacity .6s;
    transition: opacity .6s;
}

.gridster .gs-w {
    background: #DDD;
    cursor: pointer;
}

.gridster .player {
    background: #BBB;
}


.gridster .preview-holder {
    border: none!important;
    background: red!important;
}



    </style>
    
</head>
<body>

<?php require(DIR_WS_INCLUDES . 'header.php'); ?>

<?php include(DIR_WS_MODULES.FILENAME_SECURITY_CHECK); ?>


<h1><?php echo HEADING_TITLE; ?></h1>


<div class="grid-stack">
<?php

	// Load all widgets
	foreach (glob(DIR_WS_INCLUDES."widgets/*/*.xml") as $widget) {
    
		$widget_conf = simplexml_load_file($widget);

		echo '<div class="grid-stack-item" data-gs-x="'.$widget_conf->defaultPosition->x.'" data-gs-y="'.$widget_conf->defaultPosition->y.'" data-gs-width="'.$widget_conf->dimensions->width.'" data-gs-height="'.$widget_conf->dimensions->height.'"'.(($widget_conf->dimensions->resizable == 'false')?' data-gs-no-resize="1"':'').'>';
			echo '<div class="grid-stack-item-content">';
				include DIR_WS_INCLUDES."widgets/".$widget_conf->runwidget;
			echo '</div>';
		
		echo '</div>';
    
    
	}


?>
</div>

<script type="text/javascript">
	$(function () {
		var options = {
			cell_height: 20,
			vertical_margin: 10
		};
		$('.grid-stack').gridstack(options);

		var grid = $('.grid-stack').data('gridstack');
		grid.cell_height(grid.cell_width() * 0.9);
		
	});
</script>

<?php require(DIR_WS_INCLUDES . 'footer.php'); ?>
</body>
</html>
<?php require(DIR_WS_INCLUDES . 'application_bottom.php'); ?>
