<?php

require ('includes/application_top.php');

#MN: Check if $_POST form is submited on this page
if($_POST){
    switch ($_POST['action']) {
    case 'widget_active':
        xtc_db_query("update ".TABLE_WIDGETS." set widgets_active = !widgets_active where widgets_id = '".xtc_db_input($_POST['widgets'])."'");
        break;
    case 'widget_save_position':
        foreach($_POST['widgets_id'] as $key => $widget){
            $w_x = xtc_db_prepare_input($_POST['widgets_x'][$key]);
            $w_y = xtc_db_prepare_input($_POST['widgets_y'][$key]);
            xtc_db_query("update ".TABLE_WIDGETS." set widgets_x = '".$w_x."', widgets_y = '".$w_y."' where widgets_id = '".$widget."'");
        }
        break;
    }
    if(isset($_POST['stock_range_number'])){
        $_SESSION['stock_range_days'] = $_POST['stock_range_number'];
    }
    if(isset($_POST['cust_on_maps'])){
        $data = $_POST['cust_on_maps'];
        $_SESSION['cust_on_maps']['kg'] = $data['kg'];
        $_SESSION['cust_on_maps']['von'] = $data['von'];
        $_SESSION['cust_on_maps']['bis'] = $data['bis'];
    }
    xtc_redirect(xtc_href_link(FILENAME_START));
}
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

<?php

#MN: Check for new widgets/customers
$customer_id = $_SESSION['customer_id'];
foreach (glob(DIR_WS_INCLUDES."widgets/*/*.xml") as $widget) {
    $widgets_query = xtc_db_query("SELECT widgets_id
                            FROM ".TABLE_WIDGETS."
                            WHERE customer_id = '".$customer_id."'
                            AND widgets_path = '".$widget."'");

    $widget_result = xtc_db_fetch_array($widgets_query);
    if($widget_result == false){
        $widget_conf = simplexml_load_file($widget);
        xtc_db_query("INSERT INTO ".TABLE_WIDGETS."
                      SET customer_id   = '".$customer_id."',
                          widgets_path   = '".$widget."',
                          widgets_x   = '".$widget_conf->defaultPosition->x."',
                          widgets_y = '".$widget_conf->defaultPosition->y."'");
    }
}

#MN: Create dropdown and get data for customer
$widgets_dropdown = array();
$widgets_dropdown[] = array('id' => '', 'text' => WIDGET_DROPDOW_TEXT);
$widgets_array = array();
$widgets_id = array();
foreach (glob(DIR_WS_INCLUDES."widgets/*/*.xml") as $widget) {
    $widget_conf = simplexml_load_file($widget);
    $widgets_query = xtc_db_query("SELECT *
                            FROM ".TABLE_WIDGETS."
                            WHERE customer_id = '".$customer_id."'
                            AND widgets_path = '".$widget."'");

    $widget_result = xtc_db_fetch_array($widgets_query);
    $widgets_array[] =  $widget_result;
    $status = WIDGET_STATUS_NOT_ACTIVE_TEXT;
    if($widget_result['widgets_active']){
        $status = WIDGET_STATUS_ACTIVE_TEXT;
    }
    $widgets_dropdown[] = array('id' => $widget_result['widgets_id'], 'text' => $widget_conf->name."(".$status.")");
    $widgets_id[] = $widget_result['widgets_id'];
}
    
$parameters = 'onchange="this.form.submit()"';
echo xtc_draw_form('widget_status', FILENAME_START, '');
echo xtc_draw_hidden_field('action', 'widget_active');
echo '<div class="pull-right">'.xtc_draw_pull_down_menu('widgets', $widgets_dropdown, $selected, $parameters).'</div>';
echo '</form>';

echo xtc_draw_form('save_widgets_positions', FILENAME_START, '');
echo xtc_draw_hidden_field('action', 'widget_save_position');
echo '<div class="pull-right"><button class="btn btn-default" type="submit" id="submit_position">&nbsp;<span class="glyphicon glyphicon-th"></span>&nbsp;</button></div>';

?>
    
<h1 id="1"><?php echo HEADING_TITLE; ?></h1>

<div class="grid-stack">
<?php

        #MN: Load all widgets
        foreach ($widgets_array as $widget) {
            if($widget['widgets_active']){
                echo '<input id = "h_wid'.$widget['widgets_id'].'" type="hidden" value="'.$widget['widgets_id'].'" name="widgets_id[]">';
                echo '<input id = "h_wx'.$widget['widgets_id'].'" type="hidden" value="'.$widget['widgets_x'].'" name="widgets_x[]">';
                echo '<input id = "hw_y'.$widget['widgets_id'].'" type="hidden" value="'.$widget['widgets_y'].'" name="widgets_y[]">';
                $widget_conf = simplexml_load_file($widget['widgets_path']);
		echo '<div id="'.$widget['widgets_id'].'" class="grid-stack-item" data-gs-x="'.$widget['widgets_x'].'" data-gs-y="'.$widget['widgets_y'].'" data-gs-width="'.$widget_conf->dimensions->width.'" data-gs-height="'.$widget_conf->dimensions->height.'"'.(($widget_conf->dimensions->resizable == 'false')?' data-gs-no-resize="1"':'').'>';
			echo '<div class="grid-stack-item-content">';
				include DIR_WS_INCLUDES."widgets/".$widget_conf->runwidget;
			echo '</div>';
		
		echo '</div>';
            }
	}
echo '</form>';
?>
</div>
<script type="text/javascript">
    
    var w_id;
    var w_x;
    var w_y;
    $( ".grid-stack-item" ).click(function() {
        $( ".grid-stack-item" ).each(function(i) {
            w_id = $(this).attr('id');
            w_x = $(this).attr('data-gs-x');
            w_y = $(this).attr('data-gs-y');
            if(typeof w_id != 'undefined'){
                $("#h_wx"+w_id).val( w_x );
                $("#hw_y"+w_id).val( w_y );
                console.log(w_id);
            }
        });
    });
	   
    $( "#submit_position" ).click(function() {
		if ($(this).hasClass("enabled")) {
			$( ".grid-stack-item" ).each(function(i) {
				w_id = $(this).attr('id');
				w_x = $(this).attr('data-gs-x');
				w_y = $(this).attr('data-gs-y');
				if(typeof w_id != 'undefined'){
					$("#h_wx"+w_id).val( w_x );
					$("#hw_y"+w_id).val( w_y );
					console.log(w_id);
				}
			});
			$(this).removeClass("enabled");
		} else {
	        var grid = $('.grid-stack').data('gridstack');
			grid.enable();

			$(this).addClass("enabled");
			$(this).children("span").removeClass("glyphicon-th");
			$(this).children("span").addClass("glyphicon-ok");
			$(this).children("span").css("color", "green");
			
			$('select[name=widgets]').show();
			
			return false;		
			
		};
    });



	$(function () {
		var options = {
			cell_height: 20,
			vertical_margin: 10
		};
		$('.grid-stack').gridstack(options);

		var grid = $('.grid-stack').data('gridstack');
		grid.cell_height(grid.cell_width() * 0.9);
		
		grid.disable();
		$('select[name=widgets]').hide();
	});
	
	
</script>

<?php require(DIR_WS_INCLUDES . 'footer.php'); ?>
</body>
</html>
<?php require(DIR_WS_INCLUDES . 'application_bottom.php'); ?>
