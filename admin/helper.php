<?php
/**
 * get_ID_by_slug get the ID from the slug 
 * 
 * @param string $page_slug the page slug name
 * 
 * @return integer value of the id
 * 
 */ 
function get_ID_by_slug($page_slug)
{
    $page = get_page_by_path($page_slug);
    if ($page) {
        return $page->ID;
    } else {
        return null;
    }
}
?>