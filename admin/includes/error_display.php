<?php
/* --------------------------------------------------------------
   $Id: error_display.php xxx 2015-11-03 Milan Niksic   
### Template to display errors on form
   --------------------------------------------------------------*/

if(isset($_GET['errors'])){
$error = array();
if(isset($_SESSION['errors'])){
    $error = $_SESSION['errors'];
    unset($_SESSION['errors']);
}
if(!empty($error)){
    ?>
    <div class="col-xs-12 error_display_box">
        <?php echo ERROR_TEXT_HEADING;
        echo '<ul>';
                foreach($error as $message){
                    echo '<li>'.$message.'</li>';
                }
        echo '</ul>';
        ?>
    </div>
    <?php
}
}
?>