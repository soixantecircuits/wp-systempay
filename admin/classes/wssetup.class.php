<?php
/**
 * db version 
 * 
 */
global $wp_systempay_db_version;
$wp_systempay_db_version = "1.1.3";

/**
 * WSSetup allow to setup the install
 * 
 * @return void
 */

class WSSetup
{
    private $_systempay;

    public function __construct($systempay) 
    {
        $this->_systempay = $systempay;
    }

    public function getSystempay()
    {
        return $this->_systempay;
    }

    public function setSystempay($systempay)
    {
        $this->_systempay = $systempay;
    }

    /**
     * Install the plugin
     * 
     * @return void
     * 
     * */
    public function install()
    {
        //ob_start();
        $this->_createDB();
        $content = __("If you want that Payfom works, please don't change the subpages", "ws");
        $this->_createPage($this->getSystempay()->get_mainPage_slug(), $this->getSystempay()->get_mainPage_title(), $content);
        $content = "[wp-systempay-confirmation]";
        $this->_createPage($this->getSystempay()->get_confirmationpage_slug(), $this->getSystempay()->get_confirmationpage_title(), $content);
        $content = "[wp-systempay-result]";
        $this->_createPage($this->getSystempay()->get_resultPage_slug(), $this->getSystempay()->get_resultPage_title(), $content);
        $content = "[wp-systempay-server-result]"; 
        $this->_createPage($this->getSystempay()->get_resultServerPage_slug(), $this->getSystempay()->get_resultServerPage_title(), $content);
        $this->_createConfigs();
        add_action('admin_notices', array( $this, '_adminInstallnotice'));
        //trigger_error(ob_get_contents(),E_USER_ERROR);
    }

    /**
     * Created the DB
     * 
     * @return void
     * 
     * */
    private function _createDB() 
    {
        global $wpdb;
        global $wp_systempay_db_version;

        //we create the first table;
        $table_name = $this->getSystempay()->get_form_table_name();
        $form_table_name = "CREATE TABLE IF NOT EXISTS $table_name (
          form_id int(255) NOT NULL AUTO_INCREMENT,
          form_name VARCHAR(55) NOT NULL,
          form_css_class VARCHAR(55) DEFAULT 'ws_css_class' NOT NULL,
          form_plateforme VARCHAR(55) NOT NULL,
          PRIMARY KEY the_form_id (form_id),
          KEY the_form_name (form_name)
        );";

        //we create the second table;
        $table_name = $this->getSystempay()->get_inputs_table_name();
        $inputs_table_name = "CREATE TABLE IF NOT EXISTS $table_name (
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
          PRIMARY KEY id (input_id),
          KEY the_form_id (input_form_id)
        );";

        //we create the third table;
        $table_name = $this->getSystempay()->get_configurations_table_name();
        $configurations_table_name = "CREATE TABLE IF NOT EXISTS $table_name (
          configuration_id int(255) NOT NULL AUTO_INCREMENT,
          configuration_form_id int(255),
          configuration_label VARCHAR(255) DEFAULT '',
          configuration_name VARCHAR(255) DEFAULT '',
          configuration_value VARCHAR(255) DEFAULT '',
          configuration_function BOOLEAN,
          configuration_hide BOOLEAN,
          configuration_required BOOLEAN,
          configuration_class VARCHAR(255) DEFAULT '',
          PRIMARY KEY id (configuration_id),
          KEY the_form_id (configuration_form_id)
        );";

        $table_name = $this->getSystempay()->get_transactions_table_name();
        $transactions_table_name = "CREATE TABLE IF NOT EXISTS $table_name (
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
          transaction_customer_zip VARCHAR(255),
          transaction_customer_city VARCHAR(255),
          transaction_customer_shipping_address VARCHAR(255),
          transaction_customer_phone VARCHAR(255),
          transaction_customer_cellphone VARCHAR(255),
          transaction_customer_email VARCHAR(255),
          transaction_customer_country VARCHAR(255),
          PRIMARY KEY id (transaction_id),
          KEY the_form_id (transaction_form_id),
          KEY the_form_name (transaction_form_name)
        );";


        $table_name = $this->getSystempay()->get_generalconfig_table_name();
        $generalconfig_table_name = "CREATE TABLE IF NOT EXISTS $table_name (
          generalconfig_id int(255) NOT NULL AUTO_INCREMENT,
          generalconfig_json Text,
          PRIMARY KEY id (generalconfig_id)
        );";

        $table_name = $this->getSystempay()->get_WSconfig_table_name();
        $ws_config_table_name = "CREATE TABLE IF NOT EXISTS $table_name (
          WSconfig_id int(255) NOT NULL AUTO_INCREMENT,
          WSconfig_form_id int(255),
          WSconfig_json Text,
          PRIMARY KEY id (WSconfig_id),
          KEY the_form_id (WSconfig_form_id)
        );";

        include_once ABSPATH . 'wp-admin/includes/upgrade.php';

        //create process
        dbDelta($form_table_name);
        dbDelta($inputs_table_name);
        dbDelta($configurations_table_name);
        dbDelta($transactions_table_name);
        dbDelta($generalconfig_table_name);
        dbDelta($ws_config_table_name);

        update_option("wp_systempay_db_version", $wp_systempay_db_version);
 
        $installed_ver = get_option("wp_systempay_db_version");

        if ( $installed_ver != $wp_systempay_db_version ) {
            update_option("wp_systempay_db_version", $wp_systempay_db_version);
        }
    }

    /**
     * Created a page 
     * 
     * @param string $the_page_slug  The slug of the page
     * @param string $the_page_title The title of the page
     * @param string $content        The content
     * 
     * @return void
     */
    private function _createPage($the_page_slug, $the_page_title, $content) 
    {
        global $wpdb;
        $the_page = get_page_by_title($the_page_title);
        if (!$the_page) {
            $the_page = get_page_by_path($the_page_slug);
        }

        if ($the_page_title != $this->getSystempay()->get_mainPage_title()) {
            $mainPage = get_option('WS_main_page');
        } else {
            $mainPage = null;
        }
        if ( ! $the_page ) {
            // Create post object
            $_p = array();
            $_p['post_title']     = $the_page_title;
            $_p['post_content']   = $content;
            $_p['post_status']    = 'publish';
            $_p['post_type']      = 'page';
            $_p['comment_status'] = 'closed';
            $_p['ping_status']    = 'closed';
            $_p['post_parent']    = $mainPage;
            $_p['post_category']  = array(1); // the default 'Uncategorised'

            if ($the_page_title == $this->getSystempay()->get_mainPage_title()) {
                update_option('WS_main_page', $the_page, '', 'yes');
            }
            // Insert the post into the database
            $the_page_id = wp_insert_post($_p);

            switch ($the_page_slug) {
            case 'transaction_serve_page':
                $this->getSystempay()->setResultServerPage_id($the_page_id);
                break;
            case 'transaction_page':
                $this->getSystempay()->setResultPage_id($the_page_id);
                break;
            case 'confirmation_page':
                $this->getSystempay()->setConfirmationpage_id($the_page_id);
                break; 
            case 'ws_systempay':
                $this->getSystempay()->setMainPage_id($the_page_id);
                break;              
            default:
                break;
            }
        } else {
            // the plugin may have been previously active and the page may just be trashed...
            $the_page_id = $the_page->ID;
            if ($the_page_title == $this->getSystempay()->get_mainPage_title()) {
                update_option("WS_main_page", $the_page_id);
            }
            //make sure the page is not trashed...
            $the_page->post_status  = 'publish';
            $the_page->post_content = $content;
            $the_page->post_parent  = $mainPage;
            $the_page_id            = wp_update_post($the_page);
        }
    }

    /**
     * Created the configuration option for the wp-systempay
     * 
     * @return void
     */
    private function _createConfigs()
    {
        global $wpdb;
        if ($this->_configExist()) return false;
        $generalconfig = array(
            "email"=>array(
                  "transport" =>"smtp"
                  ,"smtp" => array(
                        "smtp"=>""
                        ,"port"=>25
                        ,"username"=>""
                        ,"password"=>""
                        ,"tls"=>""
                    )
                  ,"send_mail"=>array(
                      "path"=>"/usr/sbin/sendmail"
                    ) 
            )
        );
        $generalconfig       = json_encode($generalconfig);
        $generalConfigs_data = array(
          "generalconfig_json" => $generalconfig
        );
        //insert input
        $wpdb->insert(
            $this->getSystempay()->get_generalconfig_table_name(), 
            $generalConfigs_data
        );
    }

    /**
     * Check for configs
     * 
     * @return void
     * 
     */
    private function _configExist() 
    {
        global $wpdb;
        $config = $wpdb->get_results("SELECT * FROM $this->get_generalconfig_table_name()");
        if (sizeof($config)>0) return true;
        return false;
    }

    /**
     * Notice after installation success but not fully setuped
     * 
     * @return void
     * 
     */
    private function _adminInstallnotice()
    {
        ?>
        <div id="message" class="install systempay-message">
          <div class="wrapped">
            <h4><?php _e('<strong>Welcome to WP-Systempay</strong> &#8211; You\'ll soon be able to gain some bucks thru forms :)', 'ws'); ?></h4>
          </div>
        </div>
        <?php
    }

    /**
     * Notice after installation success
     * 
     * @return void
     * 
     */
    private function _adminInstallednotice() 
    {
        ?>
        <div id="message" class="installed systempay-message">
          <div class="wrapped">
            <h4><?php _e('<strong>WP-Systempay has been installed</strong> &#8211; Now go make some forms :)', 'ws'); ?></h4>
            <p class="submit"><a href="<?php echo admin_url('admin.php?page=WS_newForm'); ?>" class="button-primary"><?php _e('Settings', 'ws'); ?></a> <a class="docs button-primary" href="#"><?php _e('Documentation', 'ws'); ?></a></p>
          </div>
        </div>
        <?php
        
        // Set installed option
        update_option('wp_systempay_installed', 0);
    }
}
?>