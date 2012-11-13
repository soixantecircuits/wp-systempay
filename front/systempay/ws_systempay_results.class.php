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
                '00' => __('Paiement réalisé avec succès', 'ws'),
                '02' => __('Le commerçant doit contacter la banque du porteur', 'ws'),
                '05' => __('Paiement refusé', 'ws'),
                '17' => __('Annulation client', 'ws'),
                '30' => __('Erreur de format de la requête', 'ws'), 
                '96' => __('Erreur technique lors du paiement', 'ws')
            )
            //if vads_result is 05 or 00
            ,'extra_results_default' => array(
                'empty' => __('Pas de contrôle effectué', 'ws'),
                '00' => __('Tous les contrôles se sont déroulés avec succès', 'ws'),
                '02' => __('La carte a dépassé l’encours autorisé', 'ws'),
                '03' => __('La carte appartient à la liste grise du commerçant', 'ws'),
                '04' => __('Le pays d’émission de la carte appartient à la liste grise du commerçant', 'ws'),
                '05' => __('L’adresse IP appartient à la liste grise du commerçant', 'ws'),
                '06' => __('Le code BIN appartient à la liste grise du commerçant', 'ws'),
                '07' => __('Détection d\'une e-carte bleue', 'ws'),
                '08' => __('Détection d\'une carte commerciale nationale', 'ws'),
                '09' => __('Détection d\'une carte commerciale étrangère', 'ws'),
                '14' => __('La carte est une carte à autorisation systématique', 'ws'),
                '20' => __('Aucun pays ne correspond (pays IP, pays carte, pays client)', 'ws'),
                '99' => __('Problème technique rencontré par le serveur lors du traitement d’un des contrôles locaux', 'ws')
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
                '00' => __('transaction approuvée ou traitée avec succès', 'ws'),
                '02' => __('contacter l’émetteur de carte', 'ws'),
                '03' => __('accepteur invalide', 'ws'), 
                '04' => __('conserver la carte', 'ws'),
                '05' => __('ne pas honorer', 'ws'),
                '07' => __('conserver la carte, conditions spéciales', 'ws'),
                '08' => __('approuver après identification', 'ws'),
                '12' => __('transaction invalide', 'ws'),
                '13' => __('montant invalide', 'ws'),
                '14' => __('numéro de porteur invalide', 'ws'),
                '30' => __('erreur de format', 'ws'),
                '31' => __('identifiant de l’organisme acquéreur inconnu', 'ws'),
                '33' => __('date de validité de la carte dépassée', 'ws'),
                '34' => __('suspicion de fraude', 'ws'),
                '41' => __('carte perdue', 'ws'),
                '43' => __('carte volée', 'ws'),
                '51' => __('provision insuffisante ou crédit dépassé', 'ws'),
                '54' => __('date de validité de la carte dépassée', 'ws'),
                '56' => __('carte absente du fichier', 'ws'),
                '57' => __('transaction non permise à ce porteur', 'ws'),
                '58' => __('transaction interdite au terminal', 'ws'),
                '59' => __('suspicion de fraude', 'ws'),
                '60' => __('l’accepteur de carte doit contacter l’acquéreur', 'ws'),
                '61' => __('montant de retrait hors limite', 'ws'),
                '63' => __('règles de sécurité non respectées', 'ws'),
                '68' => __('réponse non parvenue ou reçue trop tard', 'ws'),
                '90' => __('arrêt momentané du système', 'ws'),
                '91' => __('émetteur de cartes inaccessible', 'ws'),
                '96' => __('mauvais fonctionnement du système', 'ws'),
                '94' => __('transaction dupliquée', 'ws'),
                '97' => __('échéance de la temporisation de surveillance globale', 'ws'),
                '98' => __('serveur indisponible routage réseau demandé à nouveau', 'ws'),
                '99' => __('incident domaine initiateur', 'ws')
            )
            ,'warranty_results' => array(
                'YES' => __('Le paiement est garanti', 'ws'),
                'NO' => __('Le paiement n\'est pas garanti', 'ws'),
                'UNKNOWN' => __('Suite à une erreur technique, le paiment ne peut pas être garanti', 'ws')
            )
        ); //end array results
    } //end function create_results
}
?>