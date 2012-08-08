
jQuery(document).ready(function() {
	if(jQuery( "#tabs" ).length>=1) {
		jQuery( "#tabs" ).tabs();
	}
});

WS_inputs_index=1000; //we put a large int , cause we don't know how many inputs would be loaded
function WS_deleteRow(id) 
{
	jQuery("#row_"+id).remove();
	
};

function WS_addRow() 
{
		WS_inputs_index +=1;
		var newRow= '<tr id="row_'+WS_inputs_index+'" >';
			newRow+='<td class="delete_row"><input type="button" value="-" class="button" onClick="WS_deleteRow('+WS_inputs_index+');"/></td>';
			newRow+='<td class="large label"><input type="text" name="inputs['+WS_inputs_index+'][label]"  value="new input"/></td>';
			newRow+='<td><input type="text" name="inputs['+WS_inputs_index+'][name]"  value=""/></td>';
			newRow+='<td><input type="text" name="inputs['+WS_inputs_index+'][value]" value="0"/></td>';
			newRow+='<td><input type="text" name="inputs['+WS_inputs_index+'][order]" value="0"/></td>';
			newRow+='<td><input type="text" name="inputs['+WS_inputs_index+'][fieldset]" value="1"/></td>';
			newRow+='<td><input type="checkbox" name="inputs['+WS_inputs_index+'][hide]" value="1"/></td>';
			newRow+='<td><input type="checkbox" name="inputs['+WS_inputs_index+'][required]" value="1"/></td>';
			newRow+='<td><input type="text" name="inputs['+WS_inputs_index+'][class]" value=""/></td>';
			newRow+='<td><SELECT name="inputs['+WS_inputs_index+'][type]" size="1"><OPTION>text</OPTION><OPTION>select</OPTION><OPTION>radio</OPTION><OPTION>checkbox</OPTION><OPTION>textarea</OPTION><OPTION>countrieslist</OPTION><OPTION>email</OPTION><OPTION>numeric</OPTION><OPTION>amountentry</OPTION></SELECT></td>';
			newRow+='<td><input type="text" name="inputs['+WS_inputs_index+'][options]" value=""/></td>';
			newRow+='</tr>';
    	jQuery("#ws_customizable_inputs_table").append(newRow);
};


function WS_ajax_fillTables(data){
	jQuery.post(ajaxurl, data, function(response) {
		console.debug(response);
		var configurations= createFormalsConfigurations(response,0)
		jQuery("#ws_formals_inputs_table").html(configurations.html);
		var additionalsConf = createAdditionalsConfigurations(response,configurations.last_index);
		jQuery("#ws_inputs_table").html(additionalsConf.html);
		var customerInputs=createCustomerInputs(response,0);
		jQuery("#ws_customer_inputs_table").html(customerInputs.html);
	});
}

function WS_admin_ajax_load_inputs(datas){
	WS_ajax_fillTables(datas);
	jQuery('#ws_plateforme').change(function(){
		datas.WS_plateforme = jQuery('#ws_plateforme').val();
		WS_ajax_fillTables(datas);
	});
	jQuery('#resetAdditionalsInputs').click(function(){
		datas.WS_plateforme = jQuery('#ws_plateforme').val();
		WS_ajax_fillTables(datas);
	});
}

function createFormalsConfigurations(inputsGetted,firstIndex) {
	inputsGetted = JSON.parse(inputsGetted, false);
	var configurations_data=inputsGetted.formals_infos;
	return createConfigurationsCorps(configurations_data,firstIndex);
}

function createAdditionalsConfigurations(inputsGetted,firstIndex) {
	inputsGetted = JSON.parse(inputsGetted, false);
	var configurations_data=inputsGetted.additionals_infos;
	return createConfigurationsCorps(configurations_data,firstIndex);
}

function createConfigurationsCorps(configurations_data,firstIndex) {
	var configurations_html='';
	var inputIndex=firstIndex;
	for (var i=0; i<configurations_data.length;i++){ 	
		var new_class = (i%2==0)?"even":"odd"; 	
		configurations_html+='<tr class='+new_class+'>';
		formalInput=configurations_data[i];
		var isFunction="no";
		if (formalInput.function=="1"){
			isFunction="yes";
		}
		configurations_html+='<td class="large label"><input type="text" name="configurations['+inputIndex+'][label]" value="'+formalInput.label+'"/></td>';
		configurations_html+='<td class="large"><p>'+formalInput.name+'</p></td>';		
		configurations_html+='<td>';
		if (formalInput.function=="1") {
			formalInput.admin_type="immutable";
		}

		switch(formalInput.admin_type){
			case "select" :
				var options = JSON.parse(formalInput.admin_options,false);
				configurations_html+="<select name=configurations["+inputIndex+"][value] >";
				for (var key in options){
					var value = options[key];
					selected = (value==formalInput.value)?"selected":"";
					configurations_html+="<option value='"+value+"' "+selected+">"+key+"</option>";
				}
				configurations_html+="</select>"
			break;
			case "radio":
				configurations_html+="<ul class='radio_admin'>"
				var options = JSON.parse(formalInput.admin_options,false);
				for (var key in options){
					var value = options[key];
					selected = (value==formalInput.value)?"checked":"";
					configurations_html+="<li>";
					configurations_html+="<input type='radio' name=configurations["+inputIndex+"][value] value='"+value+"' "+selected+"/>"+key;
					configurations_html+="</li>";
				}
				configurations_html+="</ul>";
				configurations_html+="<div class='cb'></div>";
			break;
			case "immutable":
				configurations_html+='<input type="hidden" name="configurations['+inputIndex+'][value]" value="'+formalInput.value+'"/>';
				configurations_html+='<p>'+formalInput.value+'</p>';
			break;
			default : 
				configurations_html+='<input type="text" name="configurations['+inputIndex+'][value]" value="'+formalInput.value+'"/>';
			break;
		}
		configurations_html+='</td>';
		configurations_html+='<td class="short"><p>'+isFunction+'</p></td>';
		if (formalInput.hide=="1"){
			configurations_html+='<td class="short"><input type="checkbox" name="configurations['+inputIndex+'][hide]" value="1" checked></td>';
		}
		else {
			configurations_html+='<td class="short"><input type="checkbox" name="configurations['+inputIndex+'][hide]" value="1" ></td>';
		}
		
		configurations_html+='<td class="large description"><p>'+formalInput.description+'</p</td>';			
		configurations_html+='<input type="hidden" name="configurations['+inputIndex+'][name]" value="'+formalInput.name+'"/>';			
		configurations_html+='<input type="hidden" name="configurations['+inputIndex+'][function]" value="'+formalInput.function+'"/>';			
		configurations_html+='</tr>';
		inputIndex++;
	}
	var infos = {
		"html" : configurations_html
		,"last_index" : inputIndex
	}
	return infos;
}
function createCustomerInputs(inputsGetted,firstIndex){
	inputsGetted = JSON.parse(inputsGetted, false);
	var additionalsInputs= inputsGetted.customer_infos;
	var inputIndex=firstIndex;
	var customerInputs_html='';
	for (var i=0;i<additionalsInputs.length;i++){
		additionalInput = additionalsInputs[i];
		var new_class = (i%2==0)?"even":"odd"; 
		customerInputs_html+='<tr id="row_'+inputIndex+'" class='+new_class+'>';
				customerInputs_html+='<td class="large label"><input type="text" name="inputs['+inputIndex+'][label]"  value="'+additionalInput.label+'"/></td>';
				customerInputs_html+='<td class="large">';
				customerInputs_html+='<p>'+additionalInput.name+'</p>';
				customerInputs_html+='<input type="hidden" name="inputs['+inputIndex+'][name]" value='+additionalInput.name+'>';
				customerInputs_html+='</td>';		
				customerInputs_html+='<td class="short"><input type="text" name="inputs['+inputIndex+'][value]" value="'+additionalInput.value+'"/></td>';	
				customerInputs_html+='<td class="short"><input type="text" name="inputs['+inputIndex+'][order]" value="'+additionalInput.order+'"/></td>';
				customerInputs_html+='<td class="short">';
				customerInputs_html+='<p>'+additionalInput.fieldset+'</p>';
				customerInputs_html+='<input type="hidden" name="inputs['+inputIndex+'][fieldset]" value='+additionalInput.fieldset+'>';
				customerInputs_html+='</td>';	
	if (additionalInput.hide=="1") {			
		customerInputs_html+='<td class="short"><input type="checkbox" name="inputs['+inputIndex+'][hide]" value="1" checked></td>';
	}
	else {
		customerInputs_html+='<td class="short"><input type="checkbox" name="inputs['+inputIndex+'][hide]" value="1"></td>';

	}
	
	if (additionalInput.required=="1") { // colin			
		customerInputs_html+='<td class="short"><input type="checkbox" name="inputs['+inputIndex+'][required]" value="1" checked></td>';
	}
	else {
		customerInputs_html+='<td class="short"><input type="checkbox" name="inputs['+inputIndex+'][required]" value="1"></td>';

	}
	customerInputs_html+='<td class="short"><input type="text" name="inputs['+inputIndex+'][class]" value="'+additionalInput.class+'"/></td>';
	customerInputs_html+='<td class="short">';
	customerInputs_html+='<p>'+additionalInput.type+'</p>';
	customerInputs_html+='<input type="hidden" name="inputs['+inputIndex+'][type]" value='+additionalInput.type+'>';
	customerInputs_html+='</td>';
	customerInputs_html+='<td class="short"><input type="text" name="inputs['+inputIndex+'][options]" value="'+additionalInput.options+'"/></td>'		
	customerInputs_html+='<td class="large description"><p>'+additionalInput.description+'</p></td>';
	customerInputs_html+='</tr>';
	inputIndex++;
	}
	
	var infos = {
		"html" : customerInputs_html
		,"last_index" : inputIndex
	}
	return infos;
}


