<?php

class WSCountries{
	private $_countriesList;

	public function get_countries() {
		return 	array(
				'AF' => __('Afghanistan', 'ws'),
				'AX' => __('&#197;land Islands', 'ws'),
				'AL' => __('Albania', 'ws'),
				'DZ' => __('Algeria', 'ws'),
				'AS' => __('American Samoa', 'ws'),
				'AD' => __('Andorra', 'ws'),
				'AO' => __('Angola', 'ws'),
				'AI' => __('Anguilla', 'ws'),
				'AQ' => __('Antarctica', 'ws'),
				'AG' => __('Antigua and Barbuda', 'ws'),
				'AR' => __('Argentina', 'ws'),
				'AM' => __('Armenia', 'ws'),
				'AW' => __('Aruba', 'ws'),
				'AU' => __('Australia', 'ws'),
				'AT' => __('Austria', 'ws'),
				'AZ' => __('Azerbaijan', 'ws'),
				'BS' => __('Bahamas', 'ws'),
				'BH' => __('Bahrain', 'ws'),
				'BD' => __('Bangladesh', 'ws'),
				'BB' => __('Barbados', 'ws'),
				'BY' => __('Belarus', 'ws'),
				'BE' => __('Belgium', 'ws'),
				'BZ' => __('Belize', 'ws'),
				'BJ' => __('Benin', 'ws'),
				'BM' => __('Bermuda', 'ws'),
				'BT' => __('Bhutan', 'ws'),
				'BO' => __('Bolivia', 'ws'),
				'BA' => __('Bosnia and Herzegovina', 'ws'),
				'BW' => __('Botswana', 'ws'),
				'BR' => __('Brazil', 'ws'),
				'IO' => __('British Indian Ocean Territory', 'ws'),
				'VG' => __('British Virgin Islands', 'ws'),
				'BN' => __('Brunei', 'ws'),
				'BG' => __('Bulgaria', 'ws'),
				'BF' => __('Burkina Faso', 'ws'),
				'BI' => __('Burundi', 'ws'),
				'KH' => __('Cambodia', 'ws'),
				'CM' => __('Cameroon', 'ws'),
				'CA' => __('Canada', 'ws'),
				'CV' => __('Cape Verde', 'ws'),
				'KY' => __('Cayman Islands', 'ws'),
				'CF' => __('Central African Republic', 'ws'),
				'TD' => __('Chad', 'ws'),
				'CL' => __('Chile', 'ws'),
				'CN' => __('China', 'ws'),
				'CX' => __('Christmas Island', 'ws'),
				'CC' => __('Cocos (Keeling) Islands', 'ws'),
				'CO' => __('Colombia', 'ws'),
				'KM' => __('Comoros', 'ws'),
				'CG' => __('Congo (Brazzaville)', 'ws'),
				'CD' => __('Congo (Kinshasa)', 'ws'),
				'CK' => __('Cook Islands', 'ws'),
				'CR' => __('Costa Rica', 'ws'),
				'HR' => __('Croatia', 'ws'),
				'CU' => __('Cuba', 'ws'),
				'CY' => __('Cyprus', 'ws'),
				'CZ' => __('Czech Republic', 'ws'),
				'DK' => __('Denmark', 'ws'),
				'DJ' => __('Djibouti', 'ws'),
				'DM' => __('Dominica', 'ws'),
				'DO' => __('Dominican Republic', 'ws'),
				'EC' => __('Ecuador', 'ws'),
				'EG' => __('Egypt', 'ws'),
				'SV' => __('El Salvador', 'ws'),
				'GQ' => __('Equatorial Guinea', 'ws'),
				'ER' => __('Eritrea', 'ws'),
				'EE' => __('Estonia', 'ws'),
				'ET' => __('Ethiopia', 'ws'),
				'FK' => __('Falkland Islands', 'ws'),
				'FO' => __('Faroe Islands', 'ws'),
				'FJ' => __('Fiji', 'ws'),
				'FI' => __('Finland', 'ws'),
				'FR' => __('France', 'ws'),
				'GF' => __('French Guiana', 'ws'),
				'PF' => __('French Polynesia', 'ws'),
				'TF' => __('French Southern Territories', 'ws'),
				'GA' => __('Gabon', 'ws'),
				'GM' => __('Gambia', 'ws'),
				'GE' => __('Georgia', 'ws'),
				'DE' => __('Germany', 'ws'),
				'GH' => __('Ghana', 'ws'),
				'GI' => __('Gibraltar', 'ws'),
				'GR' => __('Greece', 'ws'),
				'GL' => __('Greenland', 'ws'),
				'GD' => __('Grenada', 'ws'),
				'GP' => __('Guadeloupe', 'ws'),
				'GU' => __('Guam', 'ws'),
				'GT' => __('Guatemala', 'ws'),
				'GG' => __('Guernsey', 'ws'),
				'GN' => __('Guinea', 'ws'),
				'GW' => __('Guinea-Bissau', 'ws'),
				'GY' => __('Guyana', 'ws'),
				'HT' => __('Haiti', 'ws'),
				'HN' => __('Honduras', 'ws'),
				'HK' => __('Hong Kong', 'ws'),
				'HU' => __('Hungary', 'ws'),
				'IS' => __('Iceland', 'ws'),
				'IN' => __('India', 'ws'),
				'ID' => __('Indonesia', 'ws'),
				'IR' => __('Iran', 'ws'),
				'IQ' => __('Iraq', 'ws'),
				'IE' => __('Ireland', 'ws'),
				'IM' => __('Isle of Man', 'ws'),
				'IL' => __('Israel', 'ws'),
				'IT' => __('Italy', 'ws'),
				'CI' => __('Ivory Coast', 'ws'),
				'JM' => __('Jamaica', 'ws'),
				'JP' => __('Japan', 'ws'),
				'JE' => __('Jersey', 'ws'),
				'JO' => __('Jordan', 'ws'),
				'KZ' => __('Kazakhstan', 'ws'),
				'KE' => __('Kenya', 'ws'),
				'KI' => __('Kiribati', 'ws'),
				'KW' => __('Kuwait', 'ws'),
				'KG' => __('Kyrgyzstan', 'ws'),
				'LA' => __('Laos', 'ws'),
				'LV' => __('Latvia', 'ws'),
				'LB' => __('Lebanon', 'ws'),
				'LS' => __('Lesotho', 'ws'),
				'LR' => __('Liberia', 'ws'),
				'LY' => __('Libya', 'ws'),
				'LI' => __('Liechtenstein', 'ws'),
				'LT' => __('Lithuania', 'ws'),
				'LU' => __('Luxembourg', 'ws'),
				'MO' => __('Macao S.A.R., China', 'ws'),
				'MK' => __('Macedonia', 'ws'),
				'MG' => __('Madagascar', 'ws'),
				'MW' => __('Malawi', 'ws'),
				'MY' => __('Malaysia', 'ws'),
				'MV' => __('Maldives', 'ws'),
				'ML' => __('Mali', 'ws'),
				'MT' => __('Malta', 'ws'),
				'MH' => __('Marshall Islands', 'ws'),
				'MQ' => __('Martinique', 'ws'),
				'MR' => __('Mauritania', 'ws'),
				'MU' => __('Mauritius', 'ws'),
				'YT' => __('Mayotte', 'ws'),
				'MX' => __('Mexico', 'ws'),
				'FM' => __('Micronesia', 'ws'),
				'MD' => __('Moldova', 'ws'),
				'MC' => __('Monaco', 'ws'),
				'MN' => __('Mongolia', 'ws'),
				'ME' => __('Montenegro', 'ws'),
				'MS' => __('Montserrat', 'ws'),
				'MA' => __('Morocco', 'ws'),
				'MZ' => __('Mozambique', 'ws'),
				'MM' => __('Myanmar', 'ws'),
				'NA' => __('Namibia', 'ws'),
				'NR' => __('Nauru', 'ws'),
				'NP' => __('Nepal', 'ws'),
				'NL' => __('Netherlands', 'ws'),
				'AN' => __('Netherlands Antilles', 'ws'),
				'NC' => __('New Caledonia', 'ws'),
				'NZ' => __('New Zealand', 'ws'),
				'NI' => __('Nicaragua', 'ws'),
				'NE' => __('Niger', 'ws'),
				'NG' => __('Nigeria', 'ws'),
				'NU' => __('Niue', 'ws'),
				'NF' => __('Norfolk Island', 'ws'),
				'KP' => __('North Korea', 'ws'),
				'MP' => __('Northern Mariana Islands', 'ws'),
				'NO' => __('Norway', 'ws'),
				'OM' => __('Oman', 'ws'),
				'PK' => __('Pakistan', 'ws'),
				'PW' => __('Palau', 'ws'),
				'PS' => __('Palestinian Territory', 'ws'),
				'PA' => __('Panama', 'ws'),
				'PG' => __('Papua New Guinea', 'ws'),
				'PY' => __('Paraguay', 'ws'),
				'PE' => __('Peru', 'ws'),
				'PH' => __('Philippines', 'ws'),
				'PN' => __('Pitcairn', 'ws'),
				'PL' => __('Poland', 'ws'),
				'PT' => __('Portugal', 'ws'),
				'PR' => __('Puerto Rico', 'ws'),
				'QA' => __('Qatar', 'ws'),
				'RE' => __('Reunion', 'ws'),
				'RO' => __('Romania', 'ws'),
				'RU' => __('Russia', 'ws'),
				'RW' => __('Rwanda', 'ws'),
				'BL' => __('Saint Barth&eacute;lemy', 'ws'),
				'SH' => __('Saint Helena', 'ws'),
				'KN' => __('Saint Kitts and Nevis', 'ws'),
				'LC' => __('Saint Lucia', 'ws'),
				'MF' => __('Saint Martin (French part)', 'ws'),
				'PM' => __('Saint Pierre and Miquelon', 'ws'),
				'VC' => __('Saint Vincent and the Grenadines', 'ws'),
				'ws' => __('Samoa', 'ws'),
				'SM' => __('San Marino', 'ws'),
				'ST' => __('S&atilde;o Tom&eacute; and Pr&iacute;ncipe', 'ws'),
				'SA' => __('Saudi Arabia', 'ws'),
				'SN' => __('Senegal', 'ws'),
				'RS' => __('Serbia', 'ws'),
				'SC' => __('Seychelles', 'ws'),
				'SL' => __('Sierra Leone', 'ws'),
				'SG' => __('Singapore', 'ws'),
				'SK' => __('Slovakia', 'ws'),
				'SI' => __('Slovenia', 'ws'),
				'SB' => __('Solomon Islands', 'ws'),
				'SO' => __('Somalia', 'ws'),
				'ZA' => __('South Africa', 'ws'),
				'GS' => __('South Georgia/Sandwich Islands', 'ws'),
				'KR' => __('South Korea', 'ws'),
				'ES' => __('Spain', 'ws'),
				'LK' => __('Sri Lanka', 'ws'),
				'SD' => __('Sudan', 'ws'),
				'SR' => __('Suriname', 'ws'),
				'SJ' => __('Svalbard and Jan Mayen', 'ws'),
				'SZ' => __('Swaziland', 'ws'),
				'SE' => __('Sweden', 'ws'),
				'CH' => __('Switzerland', 'ws'),
				'SY' => __('Syria', 'ws'),
				'TW' => __('Taiwan', 'ws'),
				'TJ' => __('Tajikistan', 'ws'),
				'TZ' => __('Tanzania', 'ws'),
				'TH' => __('Thailand', 'ws'),
				'TL' => __('Timor-Leste', 'ws'),
				'TG' => __('Togo', 'ws'),
				'TK' => __('Tokelau', 'ws'),
				'TO' => __('Tonga', 'ws'),
				'TT' => __('Trinidad and Tobago', 'ws'),
				'TN' => __('Tunisia', 'ws'),
				'TR' => __('Turkey', 'ws'),
				'TM' => __('Turkmenistan', 'ws'),
				'TC' => __('Turks and Caicos Islands', 'ws'),
				'TV' => __('Tuvalu', 'ws'),
				'VI' => __('U.S. Virgin Islands', 'ws'),
				'USAF' => __('US Armed Forces', 'ws'),
				'UM' => __('US Minor Outlying Islands', 'ws'),
				'UG' => __('Uganda', 'ws'),
				'UA' => __('Ukraine', 'ws'),
				'AE' => __('United Arab Emirates', 'ws'),
				'GB' => __('United Kingdom', 'ws'),
				'US' => __('United States', 'ws'),
				'UY' => __('Uruguay', 'ws'),
				'UZ' => __('Uzbekistan', 'ws'),
				'VU' => __('Vanuatu', 'ws'),
				'VA' => __('Vatican', 'ws'),
				'VE' => __('Venezuela', 'ws'),
				'VN' => __('Vietnam', 'ws'),
				'WF' => __('Wallis and Futuna', 'ws'),
				'EH' => __('Western Sahara', 'ws'),
				'YE' => __('Yemen', 'ws'),
				'ZM' => __('Zambia', 'ws'),
				'ZW' => __('Zimbabwe', 'ws')
		);
	}
}

?>