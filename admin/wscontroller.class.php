<?php
/**
 ** Class WSController
*/
class WSController 
{
	private $_mainPageName;
	private $_editPageName;
	private $_newFormPageName;
	private $_transactionsPageName;
	private $_transactionsPageNameMenu;
	private $_transactionDetailsPageName;
	private $_configPageName;
	private $_AjaxManager;
	private $_Manager;
	private $_WS;
	private $_WSTools;
	private $_plateformes;
	private $_method_saveTransaction;
	private $_confirmation_form_id;
	private $_select_types;
	private $confirmation_shortcode;
  private $result_shortcode;
  private $WS_shortcode;
  private $rowIndexCustomInput;

	public function __construct()
	{
			$this->setupAdminAttributes();
			$this->userControllPages();
			if (is_admin()) {
				$this->adminControllPages();
		    	add_action('admin_menu', array($this,'ConfigureMenu'));
			}
	}

	//setup the attributes
	private function setupAdminAttributes() {
		$this->mainPageName="WS_main";
		$this->editPageName = "WS_edit";
		$this->newFormPageName = "WS_newForm";
		$this->transactionsPageName = "WS_transactions";
		$this->transactionsPageNameMenu = "WS_transactions_menu";
		$this->transactionDetailsPageName = "WS_transaction";
		$this->configPageName="WS_config";
		$this->confirmation_shortcode="WS_confirmation";
    $this->result_shortcode="WS_result";
    $this->WS_shortcode = "WS";
    $this->select_types =array("text","select","radio","checkbox","textarea","countrieslist","email","numeric","amountentry");
		$this->WS = new WSTools();
		$this->WSTools= new WSTools();
		$this->method_saveTransaction = $this->WS->get_method_saveTransaction();
		$this->rowIndexCustomInput = 500;
		if (is_admin()){
			$this->Manager = new WSManager();
		}	
	}

	public function get_WS_shortcode(){
		return $this->WS_shortcode;
	}

	public function get_confirmation_shortcode(){
		return $this->confirmation_shortcode;
	}

	public function get_result_shortcode(){
		return $this->result_shortcode;
	}

	private function adminControllPages() 
	{
		if ($page = $_GET["page"]) 
		{
			switch($page) 
			{
				case $this->mainPageName :
					$this->mainControll();
				break;
				case $this->editPageName :
					$this->editControll();
				break;
				case $this->newFormPageName :
					$this->newFormControll();
				break;
				case $this->configPageName :
					$this->configControll();
				break;	
			}
		}
	}

	private function userControllPages() 
	{

	}

	public function printTable($group){?>
		<?php //title ?>
		<pre><?php //print_r($group);?></pre>
		<?php /*TODO : Need to change the model / create one */
		
		$input = $group[0];

		// input_fieldset > -1 = mandatory input
		if($input->input_fieldset > -1) :
		?>	
		<div class="group">
		<input class="" type="text" name="inputs[<?php echo $this->rowIndexCustomInput; ?>][label]" value="<?php echo $input->input_label; ?>"/>
		<input class="hidden" type="text" name="inputs[<?php echo $this->rowIndexCustomInput; ?>][name]"  value="<?php echo $input->input_name; ?>"/>			
		<input class="hidden" type="text" name="inputs[<?php echo  $this->rowIndexCustomInput; ?>][value]" value="<?php echo $input->input_value; ?>"/>
		<input class="hidden" type="text" class="order" name="inputs[<?php echo $this->rowIndexCustomInput; ?>][order]" value="0"/>
		<input class="hidden" type="text" class="fieldset" name="inputs[<?php echo $this->rowIndexCustomInput; ?>][fieldset]" value="<?php echo $input->input_fieldset; ?>"/>
		<input class="hidden" type="checkbox" name="inputs[<?php echo $this->rowIndexCustomInput; ?>][hide]" value="1" <?php echo $checked; ?>/>
		<input class="hidden" type="checkbox" name="inputs[<?php echo $this->rowIndexCustomInput; ?>][required]" value="1" <?php echo $checked; ?>/>
		<input class="hidden" type="text" name="inputs[<?php echo $this->rowIndexCustomInput; ?>][class]" value="<?php echo $input->input_class; ?>"/>
		<SELECT class="hidden" name="inputs[<?php echo $this->rowIndexCustomInput; ?>][type]" size="1">
				<?php foreach ($this->select_types as $value) {
					$selected=($input->input_type==$value)?"selected":"" ;
					echo "<OPTION ".$selected.">".$value."</OPTION>";
				}?>
		</SELECT>
		<input class="hidden" type="text" name="inputs[<?php echo $this->rowIndexCustomInput; ?>][options]" value="<?php echo $input->input_options; ?>"/>
		<?php $this->rowIndexCustomInput++; ?>
		<?php //end title?>

		<table class="wp-list-table widefat fixed pages">
		<thead>
			<tr>
				<th class="delete"> </th>
				<th class="large"><?php _e("Label","ws"); ?></th>
				<th class="large"><?php _e("Name","ws")?></th>
				<th class="short"><?php _e("Value","ws")?></th>
				<th class="short"><?php _e("Order","ws")?></th>
				<th class="short"><?php _e("Fieldset","ws")?></th>
				<th class="short check"><?php _e("Hide","ws")?></th>
				<th class="short check"><?php _e("Required","ws")?></th>
				<th class="short"><?php _e("Class","ws")?></th>
				<th class="large"><?php _e("Type","ws")?></th>
				<th class="large"><?php _e("Options","ws")?></th>
			</tr>
		</thead>
		<tbody id="ws_customizable_inputs_table-<?php echo $group->input_fieldset;?>">
				<?php foreach ($group as $input) :
						(int)($input->input_fieldset);
						if ($input->input_order > 0): ?>
						<tr id="row_<?php echo $this->rowIndexCustomInput; ?>" class="<?php echo ($this->rowIndexCustomInput%2==0) ? 'even' : 'odd';?>">										
							<td class="delete_row short"><input type="button" class="button" value="-"/></td>
							<td class="post-title page-title column-title"><strong><input type="text" name="inputs[<?php echo $this->rowIndexCustomInput; ?>][label]"  value="<?php echo $input->input_label; ?>"/></strong></td>
							<td class="large"><input type="text" name="inputs[<?php echo $this->rowIndexCustomInput; ?>][name]"  value="<?php echo $input->input_name; ?>"/></td>			
							<td class="short"><input type="text" name="inputs[<?php echo  $this->rowIndexCustomInput; ?>][value]" value="<?php echo $input->input_value; ?>"/></td>	
							<td class="short"><input type="text" class="order" name="inputs[<?php echo $this->rowIndexCustomInput; ?>][order]" value="<?php echo $input->input_order; ?>"/></td>
							<td class="short"><input type="text" class="fieldset" name="inputs[<?php echo $this->rowIndexCustomInput; ?>][fieldset]" value="<?php echo $input->input_fieldset; ?>"/></td>
							<?php $hidden=(bool)($input->input_hide); ?>
							<?php $checked=($hidden)?"checked":""; ?>
							<td class="short check"><input type="checkbox" name="inputs[<?php echo $this->rowIndexCustomInput; ?>][hide]" value="1" <?php echo $checked; ?>/></td>
							<?php $required=(bool)($input->input_required); ?>
							<?php $checked=($required)?"checked":""; ?>
							<td class="short check"><input type="checkbox" name="inputs[<?php echo $this->rowIndexCustomInput; ?>][required]" value="1" <?php echo $checked; ?>/></td>
							<td class="short"><input type="text" name="inputs[<?php echo $this->rowIndexCustomInput; ?>][class]" value="<?php echo $input->input_class; ?>"/></td>
							<td class="large">
								<SELECT name="inputs[<?php echo $this->rowIndexCustomInput; ?>][type]" size="1">
									<?php foreach ($this->select_types as $value) {
										$selected=($input->input_type==$value)?"selected":"" ;
										echo "<OPTION ".$selected.">".$value."</OPTION>";
									}?>
								</SELECT>
							</td>
							<td class="large"><input type="text" name="inputs[<?php echo $this->rowIndexCustomInput; ?>][options]" value="<?php echo $input->input_options; ?>"/></td>
						</tr>
						<?php $this->rowIndexCustomInput++; ?>
				<?php endif; ?> 
			  <?php endforeach; ?>
			</tr>
		</tbody>
	</table>
	<input type="button" class="addRow" class="button" value="+">
	<input type="button" class="removeTable" class="button" value="<?php _e("- Remove the whole table !","ws");?>">
	</div>
	<?php
	endif;
	}

	private function mainControll() 
	{
	//When we are on the main page
		if ($WS_action = $_GET["WS_action"])
		{
			switch($WS_action) 
			{
				case "delete":
					if(empty($_GET["WS_id"])){return false;}
					$this->Manager->deleteForm($_GET["WS_id"]);
				break;
			}
		}
	}

	private function editControll() 
	{
		//When we edit a new Form
		add_action('admin_head', array('WSAjax', 'loadinputs_editform_ajax'));
		if ($WS_action = $_GET["WS_action"])
		{
			switch($WS_action) 
			{
				case "update":
				if(empty($_GET["WS_id"])){return false;}
					$this->Manager->updateForm($_GET["WS_id"],$_POST["form"],$_POST["inputs"],$_POST["configurations"],$_POST["generalconfig"]);
				break;
			}
		}
	}

	private function newFormControll() 
	{
		//When we create a new Form
		add_action('admin_head', array('WSAjax', 'loadinputs_newform_ajax'));
		if ($WS_action = $_GET["WS_action"])
		{
			switch($WS_action) 
			{
				case "insert" :
					$this->Manager->newForm($_POST["form"],$_POST["inputs"],$_POST["configurations"],$_POST["generalconfig"]);
					//$this->redirect($this->mainPageName);
				break;
			}
		}
	}

	private function configControll(){
		if ($WS_action = $_GET["WS_action"])
		{
			switch($WS_action) 
			{
				case "update" :
					$this->Manager->updateGeneralConfig();
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
	  add_menu_page(__("WS-Sytempay","WS"), __("WS-Sytempay","WS"), 'edit_pages', $this->mainPageName, array($this,'mainPage'), WP_PLUGIN_URL .'/wp-systempay/images/WS.png');
	  $newForm=add_submenu_page( $this->mainPageName, __("new Form","WS"), __("add New","WS"), 'edit_pages', $this->newFormPageName , array($this,'newForm') );
	  $transactionsMenu=add_submenu_page( $this->mainPageName, __("transactions menu","WS"), __("transactions","WS"), 'edit_pages', $this->transactionsPageNameMenu , array($this,'transactionsPageMenu') );
	  $config=add_submenu_page( $this->mainPageName, __("general Configuration","WS"), __("Config","WS"), 'edit_pages', $this->configPageName , array($this,'configPage') );
	  $editPage=add_submenu_page(null, __("edit Page","WS"),null, 'edit_pages', $this->editPageName , array($this,'editPage') );
	  $transactions= add_submenu_page(null, __("transactions","WS"),null, 'edit_pages', $this->transactionsPageName , array($this,'transactionsPage'));
	  $transction_details=add_submenu_page( null, __("transaction","WS"),null, 'edit_pages', $this->transactionDetailsPageName , array($this,'transactionDetailsPage'));
	  
	  /* Using registered $page handle to hook script load */
      add_action('admin_print_styles-'.$editPage, 'WS_load_admin_scripts');
      add_action('admin_print_styles-'.$newForm, 'WS_load_admin_scripts');
      add_action('admin_print_styles-'.$transactions, 'WS_load_datatables');
	}

	//if we are on the mainPage
	public function mainPage() 
	{	
	    require( dirname(__FILE__) . '/view/ws_management.php' );
	}

	//if we create a new form
	public function newForm() 
	{	
		require( dirname(__FILE__) . '/view/ws_newform.php' );
	}

	//if we edit a form
	public function editPage() 
	{	
		$form_to_update =$this->WSTools->getFormObjectById($_GET["WS_id"]);
		if (!empty($form_to_update["form_data"]->form_id)) :
			require( dirname(__FILE__) . '/view/ws_edit.php' );
		else:
		?>
				<p> can't found the wanted form </p>
		<?php
		endif;
	}

	public function transactionsPageMenu(){
		$groupeList = $this->Manager->getTransactionGroupes();
		require( dirname(__FILE__) . '/view/ws_transactions_menu.php' );
	}
	
	public function transactionsPage(){
		$WS_id = $_GET["WS_id"];
		$WS=new WS();
		$WS->add_admin_js();
		$transactions=$this->Manager->getTransactionsByIdForm($WS_id);
		require( dirname(__FILE__) . '/view/ws_transactions.php' );
	}
	
	public function transactionDetailsPage(){
		$transaction_id = $_GET["transaction_id"];
		$transaction_data=$this->Manager->getTransactionByIdTransaction($transaction_id);
		require( dirname(__FILE__) . '/view/ws_transaction_details.php' );
	}

	public function configPage(){
		require( dirname(__FILE__) . '/view/ws_config.php' );
	}
}

?>