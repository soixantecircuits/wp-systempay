<?php class WSSetup extends WSTools{

    public function install() {
      $this->createDB();
      $content=__("If you want that Payfom works, please don't change the subpages", "ws");
      $this->createPage($this->mainPage_slug,$this->mainPage_title,$content);
      $content="[wp-systempay-confirmation]";
      $this->createPage($this->confirmationpage_slug,$this->confirmationpage_title,$content);
      $content="[wp-systempay-result]";
      $this->createPage($this->resultPage_slug,$this->resultPage_title,$content);
	    $content="[wp-systempay-server-result]"; 
      $this->createPage($this->resultServerPage_slug,$this->resultServerPage_title,$content);
      $this->createConfigs();
    }

    private function createDB() 
    {
      global $wpdb;
    //we create the first table;
       $WS_table_name = $this->form_table_name;
       $firstSql = "CREATE TABLE $WS_table_name (
          form_id int(255) NOT NULL AUTO_INCREMENT,
          form_name VARCHAR(55) DEFAULT '' NOT NULL,
          form_css_class VARCHAR(55) DEFAULT '' NOT NULL,
          form_plateforme VARCHAR(55) DEFAULT '' NOT NULL,
          UNIQUE KEY the_form_id (form_id)
          INDEX the_form_name (form_name));
        );";

    //we create the second table;
       $WS_table_name = $this->inputs_table_name;
       $secondSql = "CREATE TABLE $WS_table_name (
        input_id int(255) NOT NULL AUTO_INCREMENT,
        input_form_id int(255),
        input_label Text,
        input_name VARCHAR(255) DEFAULT '',
        input_value VARCHAR(255) DEFAULT '',
        input_order mediumint(9),
        input_hide BOOLEAN ,
		    input_type VARCHAR(55) DEFAULT '',
        input_fieldset int(255) ,
        input_options Text,
		    input_required BOOLEAN,
		    input_class VARCHAR(255) DEFAULT '',
        UNIQUE KEY id (input_id)
        INDEX the_form_id (input_form_id));
        );";
		
    //we create the third table;
       $WS_table_name = $this->configurations_table_name;
       $thirdSql = "CREATE TABLE $WS_table_name (
        configuration_id int(255) NOT NULL AUTO_INCREMENT,
        configuration_form_id int(255),
        configuration_label VARCHAR(255) DEFAULT '',
        configuration_name VARCHAR(255) DEFAULT '',
        configuration_value VARCHAR(255) DEFAULT '',
        configuration_function BOOLEAN,
        configuration_hide BOOLEAN,
		    configuration_required BOOLEAN,
		    configuration_class VARCHAR(255) DEFAULT '',
        UNIQUE KEY id (configuration_id)
        INDEX the_form_id (configuration_form_id));
        );";
      
      $WS_table_name = $this->transactions_table_name;
       $fourthSql = "CREATE TABLE $WS_table_name (
        transaction_id int(255) NOT NULL AUTO_INCREMENT,
        transaction_order_id VARCHAR(255),
        transaction_form_id int(255),
        transaction_form_name VARCHAR(255),
        transaction_plateforme VARCHAR(255),
        transaction_trans_id int(255),
        transaction_command_statut VARCHAR(255),
        transaction_command_extrastatut VARCHAR(255),
        transaction_command_auth VARCHAR(255),
        transaction_command_3dsecure VARCHAR(255),
        transaction_command_cardnumber VARCHAR(255),
        transaction_command_certificat VARCHAR(255),
        transaction_command_info VARCHAR(255),
        transaction_otherinfos_json Text,
        transaction_command_date TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
        transaction_command_currency VARCHAR(255),
        transaction_command_amount int(255),
        transaction_customer_name VARCHAR(255),
        transaction_customer_address VARCHAR(255),
        transaction_customer_phone VARCHAR(255),
        transaction_customer_cellphone VARCHAR(255),
        transaction_customer_email VARCHAR(255),
        transaction_customer_country VARCHAR(255),
        UNIQUE KEY id (transaction_id)
        INDEX the_form_id (transaction_form_id));
        INDEX the_form_name (transaction_form_name));
        );";
      

      $WS_table_name = $this->generalconfig_table_name;
       $fifthSql = "CREATE TABLE $WS_table_name (
        generalconfig_id int(255) NOT NULL AUTO_INCREMENT,
        generalconfig_json Text,
        UNIQUE KEY id (generalconfig_id)
        
        );";

        $WS_table_name = $this->WSconfig_table_name;
       $sixthSql = "CREATE TABLE $WS_table_name (
        WSconfig_id int(255) NOT NULL AUTO_INCREMENT,
        WSconfig_form_id int(255),
        WSconfig_json Text,
        UNIQUE KEY id (WSconfig_id)
        INDEX the_form_id (WSconfig_form_id));
        );";

       require_once(ABSPATH . 'wp-admin/includes/upgrade.php');
       dbDelta($firstSql);
       dbDelta($secondSql);
       dbDelta($thirdSql);
       dbDelta($fourthSql);
       dbDelta($fifthSql);
       dbDelta($sixthSql);
    }


    private function createPage($the_page_slug,$the_page_title,$content) 
    {
        global $wpdb;
        $the_page = get_page_by_title( $the_page_title );
        if ($the_page_title!=$this->mainPage_title){
          $mainPage= get_option('WS_main_page');
        }
        else {
          $mainPage=null;
        }
        if ( ! $the_page ) {
            // Create post object
            $_p = array();
            $_p['post_title'] = $the_page_title;
            $_p['post_content'] = $content;
            $_p['post_status'] = 'publish';
            $_p['post_type'] = 'page';
            $_p['comment_status'] = 'closed';
            $_p['ping_status'] = 'closed';
            $_p['post_parent']=$mainPage;
            $_p['post_category'] = array(1); // the default 'Uncatrgorised'
            if ($the_page_title==$this->mainPage_title){
              add_option( 'WS_main_page', $the_page, '', 'yes' );
            }
            // Insert the post into the database
            $the_page_id = wp_insert_post( $_p );
        }
        else 
        {
            // the plugin may have been previously active and the page may just be trashed...
            $the_page_id = $the_page->ID;
            if ($the_page_title==$this->mainPage_title){
              update_option("WS_main_page",$the_page_id);
            }
            //make sure the page is not trashed...
            $the_page->post_status = 'publish';
            $the_page->post_content = $content;
            $the_page->post_parent =$mainPage;
            $the_page_id = wp_update_post( $the_page );
        }
    }

    private function createConfigs() {
      global $wpdb;
      if ($this->configExist()) {return false;}
      $generalconfig = array(
          "email"=>array(
                "transport" =>"smtp"
                ,"smtp" => array(
                      "smtp"=>""
                      ,"port"=>25
                      ,"username"=>""
                      ,"password"=>""
                      ,"ssl"=>""
                  )
                ,"send_mail"=>array(
                    "path"=>"/usr/sbin/sendmail"
                  ) 
          )
      );
      $generalconfig=json_encode($generalconfig);
      $generalConfigs_data = array(
        "generalconfig_json" => $generalconfig
      );
      //insert input
      $wpdb->insert(
        $this->generalconfig_table_name, 
        $generalConfigs_data
      );
    }

    private function configExist() {
        global $wpdb;
        $config = $wpdb->get_results("SELECT * FROM $this->generalconfig_table_name");
        if (sizeof($config)>0) {return true;}
        return false;
    }
}



?>