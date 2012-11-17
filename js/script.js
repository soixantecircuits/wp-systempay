var forms = {
  'inputIndex': 0
};

var WS_inputs_index = 1000; //we put a large int , cause we don't know how many inputs would be loaded
jQuery(document).ready(function() {
  if(jQuery("#tabs").length >= 1) {
    jQuery("#tabs").tabs({
      show: function(event, ui) {
        //should be replace by bootstrap plugin
        jQuery("#tabs .active").removeClass('active');
        jQuery(ui.tab).parent().addClass('active');
      }
    });
  }
  //find max input
  index = [];
  jQuery(".order").each(function() {
    index.push(jQuery(this).attr('name').match(/\d+/g)[0]);
  });

  WS_inputs_index = Math.max.apply(null, index);
  forms.inputIndex = WS_inputs_index + 1;
});


// Return a helper with preserved width of cells
var fixHelper = function(e, ui) {
    ui.children().each(function() {
      jQuery(this).width(jQuery(this).width());
    });
    return ui;
  };

var SortByOrder = function(a, b) {
    return a.order - b.order;
  }


function WS_ajax_fillTables(data) {
  jQuery.post(ajaxurl, data, function(response) {
    //console.debug(response);
    var configurations = createFormalsConfigurations(response, 0)
    jQuery("#ws_formals_inputs_table").html(configurations.html);
    var additionalsConf = createAdditionalsConfigurations(response, configurations.last_index);
    jQuery("#ws_inputs_table").html(additionalsConf.html);
    var customerInputs = createCustomerInputs(response, 0);
    jQuery("#ws_customer_inputs_table").html(customerInputs.html);

    jQuery("#ws_formals_inputs_table.loading").removeClass("loading");

    jQuery("#ws_customer_inputs tbody").sortable({
      helper: fixHelper,
      stop: function(event, ui) {
        jQuery("#ws_customer_inputs .order").each(function(i, el) {
          jQuery(el).val(i);
        });
      }
    }).disableSelection();

    jQuery("#ws_customizable_inputs").sortable({
      stop: function(event, ui) {
        var lastfirstParent = [{}];
        var fieldset = 0;

        jQuery("#ws_customizable_inputs .fieldset").each(function(i, el) {
          if(lastfirstParent !== jQuery(el).closest(".group")[0]) {
            fieldset++;
            jQuery(el).val(fieldset);
          } else {
            jQuery(el).val(fieldset);
          }
          lastfirstParent = jQuery(el).closest(".group")[0];

        });
      }
    }).disableSelection();

    jQuery(".group tbody").sortable({
      helper: fixHelper,
      stop: function(event, ui) {
        ui.item.parent().find('.order').each(function(i, el) {
          jQuery(el).val(i);
        });
      }
    }).disableSelection();

    assign_button();

    jQuery("button#addTable").click(function(e) {
      e.preventDefault();
      var tab = jQuery(".group:last").clone();
      //remove all row except the first one
      tab.find('tr').not(':last').not(':first').remove();
      //update fieldset value
      tab.find(".fieldset").each(function(el, index) {
        jQuery(this).val(Number(jQuery(this).val()) + 1);
      });

      tab.find('input').not(".fieldset").each(function(el, index) {
        jQuery(this).val('');
      });

      //update name value
      tab.find('.fieldset_name').children().each(function(el, index) {
        jQuery(this).attr('name', jQuery(this).attr('name').replace(/\d+/g, function(match, $1) {
          return forms.inputIndex;
        }));
      });
      forms.inputIndex++;
      //update the last row
      tab.find("td:gt(0)").each(function(el, index) {
        jQuery(this).children().attr('name', jQuery(this).children().attr('name').replace(/\d+/g, function(match, $1) {
          return forms.inputIndex;
        }));
      });
      forms.inputIndex++;
      tab.find("tbody").sortable({
        helper: fixHelper,
        stop: function(event, ui) {
          ui.item.parent().find('.order').each(function(i, el) {
            jQuery(el).val(i);
          });
        }
      }).disableSelection();
      jQuery(".group:last").parent().append(tab);

      assign_button();

      return false;
    });


  });
}

function assign_button() {
  button_Add_Row();
  button_Delete_Row();
  button_Remove_Table();
}


function button_Delete_Row() {
  jQuery("button.delete_row").click(function(e) {
    e.preventDefault();
    var numCurrentRow = jQuery(this).closest('table').find('tr').length;
    var numOfMiniumRow = 2;
    if(numCurrentRow > numOfMiniumRow) {
      jQuery(this).closest('tr').remove();
    } else {
      alert("You fool what are you trying to do");
    }
    e.stopImmediatePropagation();
    return false;
  });
}

function button_Remove_Table() {
  jQuery("button.removeTable").click(function(e) {
    e.preventDefault();
    var totalTable = jQuery("#ws_customizable_inputs .group").length;
    var numOfMiniumTable = 1;
    if(totalTable > numOfMiniumTable) {
      jQuery(this).parent().remove();
    } else {
      alert("You fool what are you trying to do");
    }
    e.stopImmediatePropagation();
    return false;
  });
}

function button_Add_Row() {
  jQuery("button.addRow").click(function(e) {
    e.preventDefault();
    row = jQuery(this).parent().find('table tr:last');
    fieldset = row.find(".fieldset").val();
    order = Number(row.find(".order").val()) + 1;

    var newRow = '<tr>';
    newRow += '<td class="delete_row"><button class="delete_row btn btn-warning"><i class="icon-minus icon-white"></i></button></td>';
    newRow += '<td class="large"><input type="text" name="inputs[' + forms.inputIndex + '][label]"  value="new input"/></td>';
    newRow += '<td class="large"><input type="text" name="inputs[' + forms.inputIndex + '][name]"  value=""/></td>';
    newRow += '<td class="short"><input type="text" name="inputs[' + forms.inputIndex + '][value]" value="0"/></td>';
    newRow += '<td class="short"><input type="text" name="inputs[' + forms.inputIndex + '][order]" class="order" value="' + order + '"/></td>';
    newRow += '<td class="short"><input type="text" name="inputs[' + forms.inputIndex + '][fieldset]" class="fieldset" value="' + fieldset + '"/></td>';
    newRow += '<td class="short check"><input type="checkbox" name="inputs[' + forms.inputIndex + '][hide]" value="1"/></td>';
    newRow += '<td class="short check"><input type="checkbox" name="inputs[' + forms.inputIndex + '][required]" value="1"/></td>';
    newRow += '<td class="short"><input type="text" name="inputs[' + forms.inputIndex + '][class]" value=""/></td>';
    newRow += '<td class="large"><SELECT name="inputs[' + forms.inputIndex + '][type]" size="1"><OPTION>text</OPTION><OPTION>select</OPTION><OPTION>radio</OPTION><OPTION>checkbox</OPTION><OPTION>textarea</OPTION><OPTION>countrieslist</OPTION><OPTION>email</OPTION><OPTION>numeric</OPTION><OPTION>amountentry</OPTION></SELECT></td>';
    newRow += '<td class="large"><input type="text" name="inputs[' + forms.inputIndex + '][options]" value=""/></td>';
    newRow += '</tr>';

    forms.inputIndex += 1;

    jQuery(this).parent().find('table').append(newRow);
    button_Delete_Row();
    e.stopImmediatePropagation();
    return false;
  });
}

function WS_admin_ajax_load_inputs(datas) {
  WS_ajax_fillTables(datas);
  jQuery('#ws_plateforme').change(function() {
    datas.WS_plateforme = jQuery('#ws_plateforme').val();
    WS_ajax_fillTables(datas);
  });
  jQuery('#resetAdditionalsInputs').click(function() {
    datas.WS_plateforme = jQuery('#ws_plateforme').val();
    WS_ajax_fillTables(datas);
  });
}

function createFormalsConfigurations(inputsGetted, firstIndex) {
  inputsGetted = JSON.parse(inputsGetted, false);
  var configurations_data = inputsGetted.formals_infos;
  return createConfigurationsCorps(configurations_data, firstIndex);
}

function createAdditionalsConfigurations(inputsGetted, firstIndex) {
  inputsGetted = JSON.parse(inputsGetted, false);
  var configurations_data = inputsGetted.additionals_infos;
  return createConfigurationsCorps(configurations_data, firstIndex);
}

function createConfigurationsCorps(configurations_data, firstIndex) {
  var configurations_html = '';
  var inputIndex = firstIndex;
  for(var i = 0; i < configurations_data.length; i++) {
    var new_class = (i % 2 == 0) ? "even" : "odd";
    configurations_html += '<tr class=' + new_class + '>';
    formalInput = configurations_data[i];
    var isFunction = "no";
    if(formalInput.

    function =="1") {
      isFunction = "yes";
    }
    configurations_html += '<td class="large"><input type="text" name="configurations[' + inputIndex + '][label]" value="' + formalInput.label + '"/></td>';
    configurations_html += '<td class="large"><p>' + formalInput.name + '</p></td>';
    configurations_html += '<td class="large">';
    if(formalInput.

    function =="1") {
      formalInput.admin_type = "immutable";
    }

    switch(formalInput.admin_type) {
    case "select":
      var options = JSON.parse(formalInput.admin_options, false);
      configurations_html += "<select name=configurations[" + inputIndex + "][value] >";
      for(var key in options) {
        var value = options[key];
        selected = (value == formalInput.value) ? "selected" : "";
        configurations_html += "<option value='" + value + "' " + selected + ">" + key + "</option>";
      }
      configurations_html += "</select>"
      break;
    case "radio":
      var options = JSON.parse(formalInput.admin_options, false);
      for(var key in options) {
        var value = options[key];
        selected = (value == formalInput.value) ? "checked" : "";
        configurations_html += "<label class='radio'>";
        configurations_html += "<input type='radio' name=configurations[" + inputIndex + "][value] value='" + value + "' " + selected + "/>" + key;
        configurations_html += "</label>";
      }
      configurations_html += "<div class='cb'></div>";
      break;
    case "immutable":
      configurations_html += '<input type="hidden" name="configurations[' + inputIndex + '][value]" value="' + formalInput.value + '"/>';
      configurations_html += '<p>' + formalInput.value + '</p>';
      break;
    default:
      configurations_html += '<input type="text" name="configurations[' + inputIndex + '][value]" value="' + formalInput.value + '"/>';
      break;
    }
    configurations_html += '</td>';
    configurations_html += '<td class="short"><p>' + isFunction + '</p></td>';
    if(formalInput.hide == "1") {
      configurations_html += '<td class="short"><input type="checkbox" name="configurations[' + inputIndex + '][hide]" value="1" checked></td>';
    } else {
      configurations_html += '<td class="short"><input type="checkbox" name="configurations[' + inputIndex + '][hide]" value="1" ></td>';
    }

    configurations_html += '<td class="large description"><p>' + formalInput.description + '</p</td>';
    configurations_html += '<input type="hidden" name="configurations[' + inputIndex + '][name]" value="' + formalInput.name + '"/>';
    configurations_html += '<input type="hidden" name="configurations[' + inputIndex + '][function]" value="' + formalInput.

    function +'"/>';
    configurations_html += '</tr>';
    inputIndex++;
  }
  var infos = {
    "html": configurations_html,
    "last_index": inputIndex
  }
  return infos;
}

function createCustomerInputs(inputsGetted, firstIndex) {
  inputsGetted = JSON.parse(inputsGetted, false);
  var additionalsInputs = inputsGetted.customer_infos;
  var inputIndex = firstIndex;
  var customerInputs_html = '';
  additionalsInputs.sort(SortByOrder);

  for(var i = 0; i < additionalsInputs.length; i++) {
    additionalInput = additionalsInputs[i];
    var new_class = (i % 2 == 0) ? "even" : "odd";
    customerInputs_html += '<tr id="row_' + inputIndex + '" class=' + new_class + '>';
    customerInputs_html += '<td class="large"><input type="text" name="inputs[' + inputIndex + '][label]"  value="' + additionalInput.label + '"/></td>';
    customerInputs_html += '<td class="large">';
    customerInputs_html += '<p>' + additionalInput.name + '</p>';
    customerInputs_html += '<input type="hidden" name="inputs[' + inputIndex + '][name]" value=' + additionalInput.name + '>';
    customerInputs_html += '</td>';
    customerInputs_html += '<td class="short"><input type="text" name="inputs[' + inputIndex + '][value]" value="' + additionalInput.value + '"/></td>';
    customerInputs_html += '<td class="short"><input type="text" name="inputs[' + inputIndex + '][order]" class="order" value="' + additionalInput.order + '"/></td>';
    customerInputs_html += '<td class="short">';
    customerInputs_html += '<p>' + additionalInput.fieldset + '</p>';
    customerInputs_html += '<input type="hidden" name="inputs[' + inputIndex + '][fieldset]" value=' + additionalInput.fieldset + '>';
    customerInputs_html += '</td>';
    if(additionalInput.hide == "1") {
      customerInputs_html += '<td class="short"><input type="checkbox" name="inputs[' + inputIndex + '][hide]" value="1" checked></td>';
    } else {
      customerInputs_html += '<td class="short"><input type="checkbox" name="inputs[' + inputIndex + '][hide]" value="1"></td>';

    }

    if(additionalInput.required == "1") { // colin      
      customerInputs_html += '<td class="short"><input type="checkbox" name="inputs[' + inputIndex + '][required]" value="1" checked></td>';
    } else {
      customerInputs_html += '<td class="short"><input type="checkbox" name="inputs[' + inputIndex + '][required]" value="1"></td>';

    }
    customerInputs_html += '<td class="short"><input type="text" name="inputs[' + inputIndex + '][class]" value="' + additionalInput.class + '"/></td>';
    customerInputs_html += '<td class="short">';
    customerInputs_html += '<p>' + additionalInput.type + '</p>';
    customerInputs_html += '<input type="hidden" name="inputs[' + inputIndex + '][type]" value=' + additionalInput.type + '>';
    customerInputs_html += '</td>';
    customerInputs_html += '<td class="short"><input type="text" name="inputs[' + inputIndex + '][options]" value="' + additionalInput.options + '"/></td>'
    customerInputs_html += '<td class="large description"><p>' + additionalInput.description + '</p></td>';
    customerInputs_html += '</tr>';
    inputIndex++;
  }

  var infos = {
    "html": customerInputs_html,
    "last_index": inputIndex
  }
  return infos;
}