<?php
/******************************************************
                      [ Funчѕes ]
 ******************************************************/
include "_inc/barra/inc/db.php";

//Imagem para fundo da barra
$gd = imagecreatefromjpeg("_inc/barra/barra/v2/$grade.jpg");

//Cores da fonte..
$branco = imagecolorallocate($gd, 255, 255, 255); 
$preto = imagecolorallocate($gd, 0, 0, 0);
$rosa = imagecolorallocate($gd, 200, 50, 200);
$vermelho = imagecolorallocate($gd, 255, 100, 0);
$verde = imagecolorallocate($gd, 0, 255, 100);

if ($status == 1){
$cor_status = $vermelho;
}
else {
$cor_status = $verde;
}

//Fonte a ser utilizada na imagem
$fnt = "_inc/barra/fonts/visitor2.ttf";
$fnt2 = "_inc/barra/fonts/tahomabd.ttf";

//Funчуo que faz aparecer o nome dos paэses na imagem
function getcountry($c) {

     $country = array(1 => 'Afghanistan',2 => 'Albania',3 => 'Algeria',4 => 'Andorra',5 => 'Angola',6 => 'Anguilla',7 => 'Antarctica',8 => 'Antigua and Barbuda',9 => 'Argentina',10 => 'Armenia',11 => 'Aruba',12 => 'Australia',13 => 'Austria',14 => 'Azerbaijan',15 => 'Bahamas',16 => 'Bahrain',17 => 'Bangladesh',18 => 'Barbados',19 => 'Belgium',20 => 'Belize',21 => 'Belarus',22 => 'Benin',23 => 'Bermuda',24 => 'Bhutan',25 => 'Bolivia',26 => 'Bosnia and Herzegovina',27 => 'Botswana',28 => 'Brasil',29 => 'Brunei',30 => 'Bulgaria',31 => 'Burkina Faso',32 => 'Burundi',33 => 'Cambodia',34 => 'Cameroon',35 => 'Canada',36 => 'Cape Verde',37 => 'Cayman Islands',38 => 'Central African Republic',39 => 'Chile',40 => "People's Rep. of China",41 => 'Christmas Island',42 => 'Colombia',43 => 'Comoros',44 => 'Congo',45 => 'Democratic Republic of the Congo',46 => 'Cook Islands',47 => 'Costa Rica',48 => "Cote D'Ivoire",49 => 'Croatia',50 => 'Cuba',51 => 'Cyprus',52 => 'Czech Republic',53 => 'Denmark',54 => 'Djibouti',55 => 'Dominica',56 => 'Dominican Republic',57 => 'Equador',58 => 'Egypt',59 => 'El Salvador',60 => 'Equatorial Guinea',61 => 'Eritrea',62 => 'Estonia',63 => 'Ethiopia',64 => 'Falkland Islands',65 => 'Fiji',66 => 'Finland',67 => 'France',68 => 'French Guiana',69 => 'French Polynesia',70 => 'Gabon',71 => 'Gambia',72 => 'Germany',73 => 'Georgia',74 => 'S. Georgia and the S. Sandwich Is.',75 => 'Ghana',76 => 'Greece',77 => 'Greenland',78 => 'Grenada',79 => 'Guadeloupe',80 => 'Guam',81 => 'Guatemala',82 => 'Guinea',83 => 'Guinea-Bissau',84 => 'Guyana',85 => 'Haiti',86 => 'Honduras',87 => 'Hong Kong',88 => 'Hungary',89 => 'Iceland',90 => 'India',91 => 'Indonesia',92 => 'Iran',93 => 'Iraq',94 => 'Ireland',95 => 'Israel',96 => 'Italy',97 => 'Jamaica',98 => 'Japan',99 => 'Jordan',100 => 'Kazakhstan',101 => 'Kenya',102 => 'Kiribati',103 => 'Kitts and Nevis',104 => 'North Korea',105 => 'South Korea',106 => 'Kyrgyzstan',107 => 'Kuwait',108 => 'Laos',109 => 'Latvia',110 => 'Lebanon',111 => 'Lesotho',112 => 'Liberia',113 => 'Libya',114 => 'Liechtenstein',115 => 'Lithuania',116 => 'Luxembourg',117 => 'Macau',118 => 'Macedonia',119 => 'Madagascar',120 => 'Malaysia',121 => 'Maldives',122 => 'Mali',123 => 'Marshall Islands',124 => 'Malta',125 => 'Northern Mariana Islands',126 => 'Malawi',127 => 'Martinique',128 => 'Mauritania',129 => 'Mauritius',130 => 'Mayotte',131 => 'Mexico',132 => 'Micronesia',133 => 'Moldova',134 => 'Mongolia',135 => 'Montserrat',136 => 'Morocco',137 => 'Mozambique',138 => 'Myanmar',139 => 'Namibia',140 => 'Nauru',141 => 'Nepal',142 => 'Netherlands',143 => 'Netherlands Antilles',144 => 'New Caledonia',145 => 'New Zealand',146 => 'Nicaragua',147 => 'Niger',148 => 'Nigeria',149 => 'Niue',150 => 'Norway',151 => 'Oman',152 => 'Pakistan',153 => 'Palau',154 => 'Panama',155 => 'Papua New Guinea',156 => 'Paraguay',157 => 'Peru',158 => 'Philippines',159 => 'Pitcairn Island',160 => 'Poland',161 => 'Portugal',162 => 'Puerto Rico',163 => 'Qatar',164 => 'Reunion',165 => 'Romania',166 => 'Russia',167 => 'Rwanda',168 => 'Saint Lucia',169 => 'Saint Vincent and the Grenadines',170 => 'Samoa-American',171 => 'Samoa-Western',172 => 'San Marino',173 => 'Sao Tome and Principe',174 => 'Saudi Arabia',175 => 'Senegal',176 => 'Seychelles',177 => 'Sierra Leone',178 => 'Singapore',179 => 'Slovakia',180 => 'Slovenia',181 => 'Solomon Islands',182 => 'Somalia',183 => 'South Africa',184 => 'Spain',185 => 'Sri Lanka',186 => 'Sudan',187 => 'Suriname',188 => 'Swaziland',189 => 'Sweden',190 => 'Switzerland',191 => 'Syria',192 => 'Taiwan',193 => 'Tajikistan',194 => 'Tanzania',195 => 'Thailand',196 => 'Togo',197 => 'Tonga',198 => 'Trinidad and Tobago',199 => 'Tunisia',200 => 'Turkey',201 => 'Turkmenistan',202 => 'Tuvalu',203 => 'Uganda',204 => 'Ukraine',205 => 'United Arab Emirates',206 => 'United Kingdom',207 => 'USA',208 => 'Uruguay',209 => 'Uzbekistan',210 => 'Vanuatu',211 => 'Vatican City',212 => 'Venezuela',213 => 'Virgin Islands',214 => 'Vietnam',215 => 'Western Sahara',216 => 'Yemen',217 => 'Yugoslavia',218 => 'Zambia',219 => 'Zimbabwe',220 => 'APO',221 => 'FPO',222 => 'Other',223 => 'Bouvet Island',224 => 'British Indian Ocean Territory',225 => 'Chad',226 => 'Cocos(Keeling) Islands',227 => 'East Timor',228 => 'Faroe Islands',229 => 'French Southern Territories',230 => 'Gibraltar',231 => 'Heard and McDonald Islands',232 => 'Monaco',233 => 'Norfolk Island',234 => 'Saint Helena',235 => 'Saint Pierre and Miquelon',236 => 'Svalbard and Jan Mayen Islands',237 => 'Tokelau',238 => 'Turks and Caicos Islands',239 => 'United States Minor Outlying Islands',240 => 'Wallis and Futuna',
	241 => 'British Virgin Islands');
    if ($c == 'get') {
		return $country; 
	} else {
		return isset($country[$c]) ? $country[$c] : "nenhum" ;
	} 
}
?>