<?php
/* -------------------------------------------------------------------------
   $Id: category_images.php

   Copyright (c) 2003 XT-Commerce
   --------------------------------------------------------------------------

   Released under the GNU General Public License 
   
   Modified by commerce:SEO - ein Projekt von Webdesign Erfurt
   
   ------------------------------------------------------------------------*/

$category_image_width = CATEGORY_IMAGE_WIDTH;
$category_image_height = CATEGORY_IMAGE_HEIGHT;

if ($category_image_width == '0' || !isset($category_image_width) || $category_image_width == '' || !is_numeric($category_image_width) || $category_image_width <= 0) {
	$category_image_width = '150';
}

if ($category_image_height == '0' || !isset($category_image_height) || $category_image_height == '' || !is_numeric($category_image_height  || $category_image_height <= 0)) {
	$category_image_height = '150';
}

$a = new image_manipulation(DIR_FS_CATALOG_IMAGES. 'categories_org/' . $categories_image_name,$category_image_width,$category_image_height,DIR_FS_CATALOG_IMAGES. 'categories/' . $categories_image_name,IMAGE_QUALITY,'');

$array=clear_string(CATEGORY_IMAGE_BEVEL);
if (CATEGORY_IMAGE_BEVEL != ''){
$a->bevel($array[0],$array[1],$array[2]);}

$array=clear_string(CATEGORY_IMAGE_GREYSCALE);
if (CATEGORY_IMAGE_GREYSCALE != ''){
$a->greyscale($array[0],$array[1],$array[2]);}

$array=clear_string(CATEGORY_IMAGE_ELLIPSE);
if (CATEGORY_IMAGE_ELLIPSE != ''){
$a->ellipse($array[0]);}

$array=clear_string(CATEGORY_IMAGE_ROUND_EDGES);
if (CATEGORY_IMAGE_ROUND_EDGES != ''){
$a->round_edges($array[0],$array[1],$array[2]);}

$string=str_replace("'",'',CATEGORY_IMAGE_MERGE);
$string=str_replace(')','',$string);
$string=str_replace('(',DIR_FS_CATALOG_IMAGES,$string);
$array=explode(',',$string);
//$array=clear_string();
if (CATEGORY_IMAGE_MERGE != ''){
$a->merge($array[0],$array[1],$array[2],$array[3],$array[4]);}

$array=clear_string(CATEGORY_IMAGE_FRAME);
if (CATEGORY_IMAGE_FRAME != ''){
$a->frame($array[0],$array[1],$array[2],$array[3]);}

$array=clear_string(CATEGORY_IMAGE_DROP_SHADOW);
if (CATEGORY_IMAGE_DROP_SHADOW != ''){
$a->drop_shadow($array[0],$array[1],$array[2]);}

$array=clear_string(CATEGORY_IMAGE_MOTION_BLUR);
if (CATEGORY_IMAGE_MOTION_BLUR != ''){
$a->motion_blur($array[0],$array[1]);}
	  $a->create();
?>