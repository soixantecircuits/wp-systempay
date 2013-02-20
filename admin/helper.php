<?php
/**
 * get_ID_by_slug get the ID from the slug 
 * 
 * @param string $page_slug the page slug name
 * 
 * @return integer value of the id
 * 
 */ 

function get_id_by_post_name($post_name)
{
    global $wpdb;
    $id = $wpdb->get_var("SELECT ID FROM $wpdb->posts WHERE post_name = '".$post_name."'");
    return $id;
}

function get_page_by_post_name($post_name)
{
    $page_id = get_id_by_post_name($post_name);
    return get_page($page_id);
}

function str_split_unicode($str, $l = 0) {
    if ($l > 0) {
        $ret = array();
        $len = mb_strlen($str, "UTF-8");
        for ($i = 0; $i < $len; $i += $l) {
            $ret[] = mb_substr($str, $i, $l, "UTF-8");
        }
        return $ret;
    }
    return preg_split("//u", $str, -1, PREG_SPLIT_NO_EMPTY);
}

function print_page_list($config_name, $page_id)
{?>
  <select class="chosen" name="generalconfig[pages][<?php echo $config_name;?>][id]"> 
    <option value=""><?php  _e( __('Select page', "ws") ); ?></option> 
    <?php 
      $pages = get_pages(); 
      foreach ( $pages as $page ) {
          $option = '<option data-url="'.get_permalink($page->ID).'" value="'.$page->ID.'"';
          if ($page->ID == $page_id) {
            $option .= ' selected="selected"'; 
          } 
          $option .= '>'.$page->post_title;
          $option .= '</option>';
          echo $option;
      }
    ?>
</select>
<?php
}

?>