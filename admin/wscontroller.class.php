<?php
/**
 * Class WSController
 * 
 * @return
 * @category
 * 
 * 
*/
class WSController 
{
    public $WS;

    private $_mainPageName;
    private $_editPageName;
    private $_newFormPageName;
    private $_transactionsPageName;
    private $_transactionsPageNameMenu;
    private $_transactionDetailsPageName;
    private $_configPageName;
    private $_confirmation_shortcode;
    private $_result_shortcode;
    private $_WS_shortcode;
    private $_select_types;
    
    private $_WSTools;
    private $_method_saveTransaction;
    private $_rowIndexCustomInput;

    private $_confirmation_form_id;

    private $_plateformes;
    private $_Manager;
    private $_AjaxManager;

    public function __construct()
    {
        $this->setupAdminAttributes();
        $this->userControllPages();
        if (is_admin()) {
            $this->adminControllPages();
            add_action('admin_menu', array($this,'ConfigureMenu'));
        }
    }

    public function get_mainPageName()
    {
        return $this->_mainPageName;
    }

    public function get_editPageName()
    {
        return $this->_editPageName;
    }

    public function get_newFormPageName()
    {
        return $this->_newFormPageName;
    }

    public function get_transactionsPageName()
    {
        return $this->_transactionsPageName;
    }

    public function get_transactionsPageNameMenu()
    {
        return $this->_transactionsPageNameMenu;
    }

    public function get_transactionDetailsPageName()
    {
        return $this->_transactionDetailsPageName;
    }

    public function get_configPageName()
    {
        return $this->_configPageName;
    }

    public function get_confirmation_shortcode()
    {
        return $this->_confirmation_shortcode;
    }

    public function get_result_shortcode()
    {
        return $this->_result_shortcode;
    }

    public function get_WS_shortcode()
    {
        return $this->_WS_shortcode;
    }

    public function get_select_types()
    {
        return $this->_select_types;
    }
    
    public function get_WSTools()
    {
        return $this->_WSTools;
    }

    public function get_method_saveTransaction()
    {
        return $this->_method_saveTransaction;
    }

    public function get_rowIndexCustomInput()
    {
        return $this->_rowIndexCustomInput;
    }

    public function get_confirmation_form_id()
    {
        return $this->_confirmation_form_id;
    }

    public function get_plateformes()
    {
        return $this->_plateformes;
    }

    public function get_Manager()
    {
        return $this->_Manager;
    }

    public function get_AjaxManager()
    {
        return $this->_AjaxManager;
    }

    //setup the attributes
    private function setupAdminAttributes() {
        $this->_mainPageName               = "WS_main";
        $this->_editPageName               = "WS_edit";
        $this->_newFormPageName            = "WS_newForm";
        $this->_transactionsPageName       = "WS_transactions";
        $this->_transactionsPageNameMenu   = "WS_transactions_menu";
        $this->_transactionDetailsPageName = "WS_transaction";
        $this->_configPageName             = "WS_config";
        $this->_confirmation_shortcode     = "WS_confirmation";
        $this->_result_shortcode           = "WS_result";
        $this->_WS_shortcode               = "WS";
        $this->_select_types               = array("text", "select", "radio", "checkbox", "textarea", "countrieslist", "email", "numeric", "amountentry");
        $this->WS                          = new WS();
        $this->_WSTools                    = new WSTools($this->WS);
        $this->_method_saveTransaction     = $this->WS->get_method_saveTransaction();
        $this->_rowIndexCustomInput        = 500;
        if (is_admin()) {
            $this->_Manager = new WSManager($this->WS);
        } 
    }

    private function adminControllPages() 
    {
        if (isset($_GET["page"]) && ($page = $_GET["page"])) {
            switch($page) {
            case $this->_mainPageName :
                $this->mainControll();
                break;
            case $this->_editPageName :
                $this->editControll();
                break;
            case $this->_newFormPageName :
                $this->newFormControll();
                break;
            case $this->_configPageName :
                $this->configControll();
                break;  
            }
        }
    }

    private function userControllPages() 
    {

    }

    public function printTable($group)
    {
        
        $input = $group[0];
        /**
         * TODO : Need to change the model / create one 
         * 
         * THIS REALLY SUCKS
         * 
         * input_fieldset > -1 = mandatory input
         */

        if($input->input_fieldset > -1) :
            ?>  
            <div class="group">
            <div class="fieldset_name ">
                <input class="" type="text" placeholder="<?php _e("Choose a nice fieldset name", "ws"); ?>" name="inputs[<?php echo $this->_rowIndexCustomInput; ?>][label]" value="<?php echo $input->input_label; ?>">
                <input class="hidden" type="text" name="inputs[<?php echo $this->_rowIndexCustomInput; ?>][name]"  value="<?php echo $input->input_name; ?>">     
                <input class="hidden" type="text" name="inputs[<?php echo  $this->_rowIndexCustomInput; ?>][value]" value="<?php echo $input->input_value; ?>">
                <input class="hidden order" type="text" name="inputs[<?php echo $this->_rowIndexCustomInput; ?>][order]" value="0">
                <input class="fieldset" type="text" name="inputs[<?php echo $this->_rowIndexCustomInput; ?>][fieldset]" value="<?php echo $input->input_fieldset; ?>">
                <input class="hidden" type="checkbox" name="inputs[<?php echo $this->_rowIndexCustomInput; ?>][hide]" value="1" <?php echo $checked; ?>>
                <input class="hidden" type="checkbox" name="inputs[<?php echo $this->_rowIndexCustomInput; ?>][required]" value="1" <?php echo $checked; ?>>
                <input class="hidden" type="text" name="inputs[<?php echo $this->_rowIndexCustomInput; ?>][class]" value="<?php echo $input->input_class; ?>">
                <select class="hidden" name="inputs[<?php echo $this->_rowIndexCustomInput; ?>][type]" size="1">
                <?php 
                foreach ($this->_select_types as $value) {
                        $selected = ($input->input_type == $value)?"selected":"" ;
                        echo "<OPTION ".$selected.">".$value."</OPTION>";
                }
                ?>
                </select>
                <input class="hidden" type="text" name="inputs[<?php echo $this->_rowIndexCustomInput; ?>][options]" value="<?php echo $input->input_options; ?>">
                <?php $this->_rowIndexCustomInput++; ?>
                <?php //end title?>
            </div>
            <table class="table wp-list-table widefat fixed pages">
            <thead>
              <tr>
                <th class="delete"> </th>
                <th class="large"><?php _e("Label", "ws"); ?></th>
                <th class="large"><?php _e("Name", "ws")?></th>
                <th class="short"><?php _e("Value", "ws")?></th>
                <th class="short"><?php _e("Order", "ws")?></th>
                <th class="short"><?php _e("Fieldset", "ws")?></th>
                <th class="short check"><?php _e("Hide", "ws")?></th>
                <th class="short check"><?php _e("Required", "ws")?></th>
                <th class="short"><?php _e("Class", "ws")?></th>
                <th class="large"><?php _e("Type", "ws")?></th>
                <th class="large"><?php _e("Options", "ws")?></th>
              </tr>
              </thead>
              <tbody id="ws_customizable_inputs_table-<?php echo $input->input_fieldset;?>">
                  <?php 
                  foreach ($group as $input) :
                      (int)($input->input_fieldset);
                      if ($input->input_order > 0) : ?>
                      <tr id="row_<?php echo $this->_rowIndexCustomInput; ?>" class="<?php echo ($this->_rowIndexCustomInput%2==0) ? 'even' : 'odd';?>">                    
                        <td class="delete_row short"><button class="btn btn-warning delete_row"><i class="icon-minus icon-white"></i></button></td>
                        <td class="large"><input type="text" name="inputs[<?php echo $this->_rowIndexCustomInput; ?>][label]"  value="<?php echo $input->input_label; ?>"></td>
                        <td class="large"><input type="text" name="inputs[<?php echo $this->_rowIndexCustomInput; ?>][name]"  value="<?php echo $input->input_name; ?>"></td>     
                        <td class="short"><input type="text" name="inputs[<?php echo  $this->_rowIndexCustomInput; ?>][value]" value="<?php echo $input->input_value; ?>"></td> 
                        <td class="short"><input type="text" class="order" name="inputs[<?php echo $this->_rowIndexCustomInput; ?>][order]" value="<?php echo $input->input_order; ?>"></td>
                        <td class="short"><input type="text" class="fieldset" name="inputs[<?php echo $this->_rowIndexCustomInput; ?>][fieldset]" value="<?php echo $input->input_fieldset; ?>"></td>
                        <?php $hidden  = (bool)($input->input_hide); ?>
                        <?php $checked = ($hidden)?"checked":""; ?>
                        <td class="short check"><input type="checkbox" name="inputs[<?php echo $this->_rowIndexCustomInput; ?>][hide]" value="1" <?php echo $checked; ?>></td>
                        <?php $required = (bool)($input->input_required); ?>
                        <?php $checked = ($required)?"checked":""; ?>
                        <td class="short check"><input type="checkbox" name="inputs[<?php echo $this->_rowIndexCustomInput; ?>][required]" value="1" <?php echo $checked; ?>></td>
                        <td class="short"><input type="text" name="inputs[<?php echo $this->_rowIndexCustomInput; ?>][class]" value="<?php echo $input->input_class; ?>"></td>
                        <td class="large">
                          <select name="inputs[<?php echo $this->_rowIndexCustomInput; ?>][type]" size="1">
                            <?php 
                            foreach ($this->_select_types as $value) {
                                $selected=($input->input_type==$value)?"selected":"" ;
                                echo "<OPTION ".$selected.">".$value."</OPTION>";
                            }
                            ?>
                          </select>
                        </td>
                        <td class="large"><input type="text" name="inputs[<?php echo $this->_rowIndexCustomInput; ?>][options]" value="<?php echo $input->input_options; ?>"></td>
                      </tr>
                      <?php $this->_rowIndexCustomInput++; ?>
                      <?php endif; ?> 
                  <?php endforeach; ?>
                </tr>
              </tbody>
            </table>
            <button class="addRow btn btn-primary"><?php _e("Add a field", "ws"); ?> <i class="icon-plus icon-white"></i></button>
            <button class="removeTable btn btn-danger"><?php _e("Remove the whole fieldset !", "ws");?><i class="icon-trash icon-white"></i></button>
            </div>
        <?php
        endif;
    }

    private function mainControll() 
    {
        //When we are on the main page
        if ($WS_action = $_GET["WS_action"]) {
            switch($WS_action) {
            case "delete":
                if (empty($_GET["WS_id"])) {
                    return false;
                }
                $this->_Manager->deleteForm($_GET["WS_id"]);
                break;
            case "updatedb":
                $this->_Manager->updatedb();
            }
        }
    }

    private function editControll() 
    {
        //When we edit a new Form
        add_action('admin_head', array('WSAjax', 'loadinputs_editform_ajax'));
        if ($WS_action = $_GET["WS_action"]) {
            switch($WS_action) {
            case "update":
                if (empty($_GET["WS_id"]) || !isset($_POST["form"])) {
                    return false;
                }
                $this->_Manager->updateForm($_GET["WS_id"], $_POST["form"], $_POST["inputs"], $_POST["configurations"], $_POST["generalconfig"]);
                break;
            }
        }
    }

    private function newFormControll() 
    {
        //When we create a new Form
        add_action('admin_head', array('WSAjax', 'loadinputs_newform_ajax'));
        if ($WS_action = $_GET["WS_action"]) {
            switch($WS_action) {
            case "insert" :
                if (isset($_POST["inputs"])) {
                    $id = $this->_Manager->newForm($_POST["form"], $_POST["inputs"], $_POST["configurations"], $_POST["generalconfig"]);
                    $this->redirect($this->_editPageName."&WS_action=edit&WS_id=".$id);
                }
                break;
            }
        }
    }

    private function configControll()
    {
        if ($WS_action = $_GET["WS_action"]) {
            switch($WS_action) {
            case "update" :
                if (isset($_POST["inputs"])) {
                    $this->_Manager->updateGeneralConfig();
                }
                break;
            }
        }
    }
    
    private function redirect($location) {
        header("HTTP/1.1 301 Moved Permanently");
        header("Status: 301 Moved Permanently");
        header("Location: ?page=".$location);
        header("Connection: close");
        exit;
    }

    //configure the Menu
    public function configureMenu()
    {
        add_menu_page(__("WS-Sytempay", "ws"),
                      __("WS-Sytempay", "ws"), 
                      'edit_pages',
                       $this->_mainPageName,
                       array($this, 'mainPage'),
                       plugins_url( '../images/ws.png', __FILE__ ));
        $all_the_forms      = add_submenu_page($this->_mainPageName, __("All the payment forms", "ws"), __("List all", "ws"), 'edit_pages', $this->_mainPageName, array($this, 'mainPage'));
        $newForm            = add_submenu_page($this->_mainPageName, __("New form", "ws"), __("Add new", "ws"), 'edit_pages', $this->_newFormPageName, array($this, 'newForm'));
        $transactionsMenu   = add_submenu_page($this->_mainPageName, __("Transactions menu", "ws"), __("transactions", "ws"), 'edit_pages', $this->_transactionsPageNameMenu, array($this, 'transactionsPageMenu'));
        $config             = add_submenu_page($this->_mainPageName, __("general Configuration", "ws"), __("Config", "ws"), 'edit_pages', $this->_configPageName, array($this, 'configPage'));
        $editPage           = add_submenu_page(null, __("Edit page", "ws"), null, 'edit_pages', $this->_editPageName, array($this,'editPage'));
        $transactions       = add_submenu_page(null, __("transactions", "ws"), null, 'edit_pages', $this->_transactionsPageName, array($this, 'transactionsPage'));
        $transction_details = add_submenu_page(null, __("transaction", "ws"), null, 'edit_pages', $this->_transactionDetailsPageName, array($this, 'transactionDetailsPage'));
        
        /* Using registered $page handle to hook script load */
          add_action('admin_print_styles-'.$editPage, 'WS_load_admin_scripts');
          add_action('admin_print_styles-'.$newForm, 'WS_load_admin_scripts');
          add_action('admin_print_styles-'.$transactions, 'WS_load_datatables');
    }

    //if we are on the mainPage
    public function mainPage() 
    { 
        include dirname(__FILE__) . '/view/ws_management.php';
    }

    //if we create a new form
    public function newForm() 
    { 
        include dirname(__FILE__) . '/view/ws_newform.php';
    }

    //if we edit a form
    public function editPage() 
    { 
        $form_to_update = $this->_WSTools->getFormObjectById($_GET["WS_id"]);

        if (!empty($form_to_update["form_data"]->form_id)) :
            include dirname(__FILE__) . '/view/ws_edit.php';
        else:
            echo "<p> can't found the wanted form </p>";
        endif;
    }

    public function transactionsPageMenu()
    {
        $groupeList = $this->_Manager->getTransactionGroupes();
        include dirname(__FILE__) . '/view/ws_transactions_menu.php';
    }
    
    public function transactionsPage()
    {
        $WS_id = $_GET["WS_id"];
        $this->WS->add_admin_js();
        $transactions = $this->_Manager->getTransactionsByIdForm($WS_id);
        include dirname(__FILE__) . '/view/ws_transactions.php';
    }
    
    public function transactionDetailsPage()
    {
        $transaction_id = $_GET["transaction_id"];
        $transaction_data=$this->_Manager->getTransactionByIdTransaction($transaction_id);
        include dirname(__FILE__) . '/view/ws_transaction_details.php' ;
    }

    public function configPage()
    {
        include dirname(__FILE__) . '/view/ws_config.php';
    }
}
?>