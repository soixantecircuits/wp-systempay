=== Plugin Name ===
Contributors: soixantecircuits, gabrielstuff
Donate link: http://soixantecircuits.fr/
Tags: form, donation, payment,
Requires at least: 3.0.1
Tested up to: 3.9.2
Stable tag: 1.0
License: GPLv2 or later
License URI: http://www.gnu.org/licenses/gpl-2.0.html

WP-Systempay allow you to create totally modular payment forms containing textareas, dropdown, whatever and then use a shortcode a page or post to show this form. It support systempay transaction plateform.

== Description ==

WP-Systempay allow you to create totally modular payment forms containing textareas, dropdown, whatever and then use a shortcode a page or post to show this form.
The plugin create and manage the payment confirmation page, redirection to the platform of payment, save and update the transactions, and finaly send a confirmation mail to the customer.
Finally , you'll be able to see the saved transactions, and their details.

== Installation ==

This section describes how to install the plugin and get it working.

e.g.

1. Upload `wp-systempay` directory to the `/wp-content/plugins/` directory
1. Activate the plugin through the 'Plugins' menu in WordPress
1. Place the shortcode form in your page or post
1. That is it !

== Frequently Asked Questions ==

= Do you support other payment plateform =

Not yet, but we are eager to know the ones you'd like

= Why this plugin ? =

Because when you want to collect money, you need a modular way to do it. So we thought you might need the same.

== Screenshots ==

== Changelog ==

= 1.0 =
* A change since the previous version.
* Another change.

= 0.5 =
* List versions from most recent at top to oldest at bottom.

== Upgrade Notice ==

= 1.0 =
Upgrade notices describe the reason a user should upgrade.  No more than 300 characters.

= 0.5 =
This version fixes a security related bug.  Upgrade immediately.

== Dependencies ==

None

== More info about usage ==

First, activate the plugin. Then go to configuration page. There, configure your mail sender (SMTP or SendMail).
If you don't have personal SMTP , you can use the gmail one's (smtp.gmail.com and check ssl).

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

## More credits

This plugin have been developped by Soixante Circuits team members that are :

- https://github.com/schobbent
- https://github.com/gabrielstuff

