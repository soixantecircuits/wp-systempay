# WP-Systempay

## Description

Version 1.0

WP-Systempay allow you to create totally modular forms, and then use the shortcode in the wanted page or post to
show the fom.

Then he create and manage the confirmation page, redirection to the platform of payment, save and update the 
transactions, and finaly send a confirmation mail to the customer.

Finally , you'll be able to see the saved transactions, and their details.

## Dependencies

None

## Usage 

First, activate the plugin. Then go to configuration page. There, configure your mail sender (SMTP or SendMail).
If you don't have personal SMTP , you can use the gmail one's (smtp.gmail.com and check tls).

Then create your form and don't forget to complete all the mandatories configurations.If you want, you can create your own inputs into 
the "customisable inputs" tab.

Finally, copy and paste the shortcode wich is showed in the Main Page.

__How to use the shortcode :__

  [wp-systempay id='form id' template='template name'] 
  *or* 
  [wp-systempay name='form name' template='template file name']
  Samples : 
  [wp-systempay id='1' template='form_subscribe.php']
  *or*
  [wp-systempay id='online give']
  
  If template attribute is empty or isn't given, WS will use the default template "default_form.php"
  
__How modify forms templates__
  
  You can create your own template into the templates/forms_templates repository, please use default-form as sample.
  
__How modify emails templates__
  You can modify the emails template into the templates/emails_templates repository, success email when 
  the transaction is successful and error_email if the there was an error during the transaction.

## Credits

This plugin have been developped by Soixante Circuits team members that are :

- https://github.com/schobbent
- https://github.com/gabrielstuff

