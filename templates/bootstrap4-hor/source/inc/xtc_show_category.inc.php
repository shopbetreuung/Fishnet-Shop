<?php

   function xtc_show_category($counter, $oldlevel=1) {
    global $foo, $categoryArray, $categories_string, $id, $cPath;  


    function generate_subcategories($children = array(), $level = 1) {

		$level_init = $level;
                $info = '';
                if($level == 2)
                {
                  $info = 'noParent';
                }

		foreach($children as $child) {

			$subcategory_product_count = '';

			if (SHOW_COUNTS == 'true') {
				$products_in_subcategory = xtc_count_products_in_category($child['id']);
				if ($products_in_subcategory > 0) {
					$subcategory_product_count = '('.$products_in_subcategory.')';
				}
			}

			if (is_array($child) && isset($child['id'])) {
				$subcategory_path = xtc_category_link($child['id'], $child['text']);

            	$categories_string .= '<ul class="no-padding col-sm-12"><li class="nav-item level'.$level.' '.$info.'">';
            
	            if(isset($child['children'])) {
	                $categories_string .= '<span class="click_arrow"><div class="arrow arrow-down"></div></span>';
				}
				
				$categories_string .= '<a class="nav-link" href="'.xtc_href_link(FILENAME_DEFAULT, $subcategory_path).'" title="'. $child['text'] . '">'.$child['text'].$subcategory_product_count.'</a>';
			}
			if(isset($child['children'])) {
				$level += 1;
				$categories_string .= generate_subcategories($child['children'], $level);
			}
			$level = $level_init;
			if (is_array($child) && isset($child['id'])) {
				$categories_string .= '</li></ul>';
			}
		}

		return $categories_string;
	}

    $categories_string = '';
    if ($categoryArray) {
      foreach($categoryArray as $category) {
		$level = 1;
      	$product_count = '';
	if (SHOW_COUNTS == 'true') {
		$products_in_category = xtc_count_products_in_category($category['id']);
		if ($products_in_category > 0) {
			$product_count = ' ('.$products_in_category.')';
		}
	}

	
		$category_path = xtc_category_link($category['id'], $category['text']);
		$categories_string .= '<li class="nav-item">';
		if(isset($category['children'])) {
			$categories_string .= '<span class="click_arrow"><div class="arrow arrow-down"></div></span>';
		}
		$categories_string .= '<a class="nav-link level'.$level.'" href="'.xtc_href_link(FILENAME_DEFAULT, $category_path).'" title="'. $category['text'] . '">'.$category['text'].$product_count.'</a>';

		if(isset($category['children'])) {

		      if(!empty($category['image'])) {
		              $category_image = '<img class="img-fluid main_category_img" src="'.DIR_WS_CATALOG.DIR_WS_IMAGES.'categories_org/'.$category['image'].'" alt="'.$category['text'].'" />'; ;
		      } else {
		              $category_image = '';
		      }

		      $level += 1;
		      $categories_string .= 
		              '<div class="subcategories">
		                      <div class="container">
		                              <div class="row d-block d-sm-flex">
		                                      <div class="col-sm-12 category_top">
	                                              <a class="nav-link col-sm-12" href="'.xtc_href_link(FILENAME_DEFAULT,'cPath='. $category['id']).'" title="'. $category['text'] . '"> '.TEXT_TO_CATEGORY.' '.$category['text'].' ></a>
	                                              </div>
		                                      </span><div class="col-sm-4 col-xs-4 list-style"></span>'.generate_subcategories($category['children'], $level).'</div>
	                                              <div class="col-sm-8 col-xs-8 horizontal-nav-picture-style">'.$category_image.'</div>
		                              </div>
		                      </div>
		              </div>';
		}
                
        $categories_string .= '</li>';

      }
    }

  }

?>
