<?php
/**
 * Class WSSystempayResults
 * 
 * @
 * 
 */

class WSSystempayResults {

    private $_results;

    public function __construct()
    {
        $this->create_results();
    }

    public function get_results()
    {
        return $this->results;
    }

    private function create_results()
    {
        $this->results = array(
            'no_code' => ''
            ,'no_translation' => ''
            ,'results' => array(
                '00' => __('The payment went well', 'ws'),
                '02' => __('The bank of the owner should be contacted', 'ws'),
                '05' => __('The payment has been refused', 'ws'),
                '17' => __('The client cancel the payment', 'ws'),
                '30' => __('Error in the query', 'ws'), 
                '96' => __('An error occured in the process', 'ws')
            )
            //if vads_result is 05 or 00
            ,'extra_results_default' => array(
                'empty' => __('No checking has been made', 'ws'),
                '00' => __('Every checks have been done with success', 'ws'),
                '02' => __('The card has reach the maximum amount', 'ws'),
                '03' => __('The card is one of the shop owner', 'ws'),
                '04' => __('The country from where the card come is in the grey list', 'ws'),
                '05' => __('The IP address is in the grey list ', 'ws'),
                '06' => __('The BIN code is in the grey list', 'ws'),
                '07' => __('A blue card has been detected', 'ws'),
                '08' => __('A national business card has been detected', 'ws'),
                '09' => __('An international business card has been detected', 'ws'),
                '14' => __('The card is always accepted', 'ws'),
                '20' => __('No country are corresponding (IP, card, client)', 'ws'),
                '99' => __('Technical issue while validating the local control', 'ws')
            )
            //if vads_result is 30
            ,'extra_results_30' => array(
                '00' => __('signature', 'ws'),
                '01' => __('version', 'ws'),
                '02' => __('merchant_site_id', 'ws'),
                '03' => __('transaction_id', 'ws'),
                '04' => __('date', 'ws'),
                '05' => __('validation_mode', 'ws'),
                '06' => __('capture_delay', 'ws'),
                '07' => __('config', 'ws'),
                '08' => __('payment_cards', 'ws'),
                '09' => __('amount', 'ws'),
                '10' => __('currency', 'ws'),
                '11' => __('ctx_mode', 'ws'),
                '12' => __('language', 'ws'),
                '13' => __('order_id', 'ws'),
                '14' => __('order_info', 'ws'),
                '15' => __('cust_email', 'ws'),
                '16' => __('cust_id', 'ws'),
                '17' => __('cust_title', 'ws'),
                '18' => __('cust_name', 'ws'),
                '19' => __('cust_address', 'ws'),
                '20' => __('cust_zip', 'ws'),
                '21' => __('cust_city', 'ws'),
                '22' => __('cust_country', 'ws'),
                '23' => __('cust_phone', 'ws'),
                '24' => __('url_success', 'ws'),
                '25' => __('url_refused', 'ws'),
                '26' => __('url_referral', 'ws'),
                '27' => __('url_cancel', 'ws'),
                '28' => __('url_return', 'ws'),
                '29' => __('url_error', 'ws'),
                '30' => __('identifier', 'ws'),
                '31' => __('contrib', 'ws'),
                '32' => __('theme_config', 'ws'),
                '34' => __('redirect_success_timeout', 'ws'),
                '35' => __('redirect_success_message', 'ws'),
                '36' => __('redirect_error_timeout', 'ws'),
                '37' => __('redirect_error_message', 'ws'),
                '38' => __('return_post_params', 'ws'),
                '39' => __('return_get_params', 'ws'),
                '40' => __('card_number', 'ws'),
                '41' => __('expiry_month', 'ws'),
                '42' => __('expiry_year', 'ws'),
                '43' => __('card_cvv', 'ws'),
                '44' => __('card_info', 'ws'),
                '45' => __('card_options', 'ws'),
                '46' => __('page_action', 'ws'),
                '47' => __('action_mode', 'ws'),
                '48' => __('return_mode', 'ws'),
                '50' => __('secure_mpi', 'ws'),
                '51' => __('secure_enrolled', 'ws'),
                '52' => __('secure_cavv', 'ws'),
                '53' => __('secure_eci', 'ws'),
                '54' => __('secure_xid', 'ws'),
                '55' => __('secure_cavv_alg', 'ws'),
                '56' => __('secure_status', 'ws'),
                '60' => __('payment_src', 'ws'),
                '61' => __('user_info', 'ws'),
                '62' => __('contracts', 'ws'),
                '70' => __('empty_params', 'ws'),
                '99' => __('other', 'ws')
            )
            ,'auth_results' => array(
                '00' => __('Successful transaction', 'ws'),
                '02' => __('Please contact the banq of the owner card', 'ws'),
                '03' => __('Invalid accept', 'ws'), 
                '04' => __('Keep the card', 'ws'),
                '05' => __('Do not honour', 'ws'),
                '07' => __('Keep the card, special conditions', 'ws'),
                '08' => __('Approved after identification', 'ws'),
                '12' => __('Invalid transaction', 'ws'),
                '13' => __('Invalid amount', 'ws'),
                '14' => __('Invalid Holder number', 'ws'),
                '30' => __('Format error', 'ws'),
                '31' => __('Receiver id unknown', 'ws'),
                '33' => __('Validity date of the card has expired', 'ws'),
                '34' => __('Suspicious transaction', 'ws'),
                '41' => __('Lost card', 'ws'),
                '43' => __('Stolen card', 'ws'),
                '51' => __('Not enough money', 'ws'),
                '54' => __('Validity date of the card has expired', 'ws'),
                '56' => __('Card not found', 'ws'),
                '57' => __('Transaction is not available for this owner', 'ws'),
                '58' => __('Transaction can not be done with terminal', 'ws'),
                '59' => __('Suspicious transaction', 'ws'),
                '60' => __('The beneficiary should contact', 'ws'),
                '61' => __('Amount is out of range', 'ws'),
                '63' => __('Security has not been respected', 'ws'),
                '68' => __('Reply never arrived or too late', 'ws'),
                '90' => __('Server is out for a few times', 'ws'),
                '91' => __('The card sender can not be reach', 'ws'),
                '96' => __('System doensn\'t work', 'ws'),
                '94' => __('Duplicated transaction', 'ws'),
                '97' => __('Global watchout will soon be suspend', 'ws'),
                '98' => __('Server can not be reached', 'ws'),
                '99' => __('An error occured on the domain', 'ws')
            )
            ,'warranty_results' => array(
                'YES' => __('The payment is guaranteed', 'ws'),
                'NO' => __('The payment is not guaranteed', 'ws'),
                'UNKNOWN' => __('Due to an error, the payment could not be guaranteed', 'ws')
            )
        ); //end array results
    } //end function create_results
}
?>