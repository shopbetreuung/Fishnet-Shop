<?php

function xtc_get_id_path($id = '') {
        $cPath_array = array();
        if (xtc_not_null($id)) {
          $cp_size = sizeof($cPath_array);
          if ($cp_size == 0) {
            $cPath_new = $id;
          } else {
            $cPath_new = '';
              for ($i=0; $i<($cp_size-1); $i++) {
                $cPath_new .= '_' . $cPath_array[$i];
              }
              for ($i=0; $i<$cp_size; $i++) {
                $cPath_new .= '_' . $cPath_array[$i];
              }
            $cPath_new .= '_' . $id;

            if (substr($cPath_new, 0, 1) == '_') {
              $cPath_new = substr($cPath_new, 1);
            }
          }
        } else {
           $cPath_new = (xtc_not_null($cPath_array)) ? implode('_', $cPath_array) : '';
        }

        return $cPath_new;
  }
  
?>

