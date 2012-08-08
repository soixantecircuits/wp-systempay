<?php class WSDeactive extends WSTools{

   	public function deactive() {
   	  $this->deletePage($this->confirmationpage_slug,$this->confirmationpage_title);
      $this->deletePage($this->resultPage_slug,$this->resultPage_title);
	  $this->deletePage($this->resultServerPage_slug,$this->resultServerPage_title);
	  $this->deletePage($this->mainPage_slug,$this->mainPage_title);
   	}

	public function deletePage($the_page_name,$the_page_title) {
		global $wpdb;
		//  the id of our page...
		$the_page = get_page_by_title( $the_page_title );
		$the_page_id=$the_page->ID;
		if( $the_page_id ) {
		    wp_delete_post($the_page_id); // this will trash, not delete
		}
	}
}?>