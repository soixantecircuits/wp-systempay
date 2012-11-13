<?php
class WSDeactive extends WSTools
{

    public function deactive()
    {
        $this->deletePage($this->getSystempay()->confirmationpage_slug, $this->getSystempay()->confirmationpage_title);
        $this->deletePage($this->getSystempay()->resultPage_slug,       $this->getSystempay()->resultPage_title);
        $this->deletePage($this->getSystempay()->resultServerPage_slug, $this->getSystempay()->resultServerPage_title);
        $this->deletePage($this->getSystempay()->mainPage_slug,         $this->getSystempay()->mainPage_title);
    }

    public function deletePage($the_page_name, $the_page_title)
    {
        global $wpdb;
        //  the id of our page...
        $the_page    = get_page_by_title($the_page_title);
        $the_page_id = $the_page->ID;
        if ($the_page_id) {
            wp_delete_post($the_page_id); // this will trash, not delete
        }
    }
}
?>