<?php
/* -----------------------------------------------------------------------------------------
   $Id: xtc_db_find_by_multiple.inc.php xxx 2015-11-03 Milan Niksic
   ---------------------------------------------------------------------------------------*/
 // Fetch fields by multiple fields - find if it already entry exist

/**
 * 
 * @param string $table -Selected table 
 * @param array $values -Array of column-value pairs to be selected from table
 * @param string $select -What columns do we want to select, default all(*)
 * @return mixed -False if record not found; array if found;
 */

function xtc_db_find_by_multiple($table, $values, $select = '*') {
    if(is_array($values)){
        #Build query by column and search value in column
        $search_values = "";
        foreach ($values as $key => $value){
            if($key != 0){
                $search_values .= " AND ";
            }
            $search_values .= "`".$value['column']."` = '".$value['value']."'";
        }
        $query = xtc_db_query("SELECT ".$select." FROM ".$table." WHERE ".$search_values);
    } else {
        #Get all if only table name is provided
        $query = xtc_db_query("SELECT ".$select." FROM ".$table);
    }  
    
    return xtc_db_fetch_array($query);
}
?>
