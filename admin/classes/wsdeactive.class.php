<?php
class WSDeactive extends WSTools
{

    public function __construct($systempay)
    {
        parent::__construct($systempay);
    }

    public function deactive()
    {
        $this->deletePage($this->getSystempay()->get_confirmationpage_slug(), $this->getSystempay()->get_confirmationpage_title());
        $this->deletePage($this->getSystempay()->get_resultPage_slug(),       $this->getSystempay()->get_resultPage_title());
        $this->deletePage($this->getSystempay()->get_resultServerPage_slug(), $this->getSystempay()->get_resultServerPage_title());
        $this->deletePage($this->getSystempay()->get_mainPage_slug(),         $this->getSystempay()->get_mainPage_title());
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