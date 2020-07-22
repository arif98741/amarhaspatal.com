<?php
/**
 * Languages
 *
 * @package Docdirect
 */

if (!function_exists('docdirect_prepare_languages')) {

    function docdirect_prepare_languages()
    {
        $language_codes = array(
            'ab' => esc_html__('Abkhazian', 'docdirect'),
            'aa' => esc_html__('Afar', 'docdirect'),
            'zu' => esc_html__('Zulu', 'docdirect'),
            'af' => esc_html__('Afrikaans', 'docdirect'),
            'ak' => esc_html__('Akan', 'docdirect'),
            'sq' => esc_html__('Albanian', 'docdirect'),
            'am' => esc_html__('Amharic', 'docdirect'),
            'ar' => esc_html__('Arabic', 'docdirect'),
            'an' => esc_html__('Aragonese', 'docdirect'),
            'hy' => esc_html__('Armenian', 'docdirect'),
            'as' => esc_html__('Assamese', 'docdirect'),
            'av' => esc_html__('Avaric', 'docdirect'),
            'ae' => esc_html__('Avestan', 'docdirect'),
            'ay' => esc_html__('Aymara', 'docdirect'),
            'az' => esc_html__('Azerbaijani', 'docdirect'),
            'bm' => esc_html__('Bambara', 'docdirect'),
            'ba' => esc_html__('Bashkir', 'docdirect'),
            'eu' => esc_html__('Basque', 'docdirect'),
            'be' => esc_html__('Belarusian', 'docdirect'),
            'bn' => esc_html__('Bengali', 'docdirect'),
            'bh' => esc_html__('Bihari languages', 'docdirect'),
            'bi' => esc_html__('Bislama', 'docdirect'),
            'bs' => esc_html__('Bosnian', 'docdirect'),
            'br' => esc_html__('Breton', 'docdirect'),
            'bg' => esc_html__('Bulgarian', 'docdirect'),
            'my' => esc_html__('Burmese', 'docdirect'),
            'ca' => esc_html__('Catalan, Valencian', 'docdirect'),
            'ct' => esc_html__('Catalan, Catalunya', 'docdirect'),
            'km' => esc_html__('Central Khmer', 'docdirect'),
            'ch' => esc_html__('Chamorro', 'docdirect'),
            'ce' => esc_html__('Chechen', 'docdirect'),
            'ny' => esc_html__('Chichewa, Chewa, Nyanja', 'docdirect'),
            'zh' => esc_html__('Chinese', 'docdirect'),
            'cu' => esc_html__('Church Slavonic, Old Bulgarian, Old Church Slavonic', 'docdirect'),
            'cv' => esc_html__('Chuvash', 'docdirect'),
            'kw' => esc_html__('Cornish', 'docdirect'),
            'co' => esc_html__('Corsican', 'docdirect'),
            'cr' => esc_html__('Cree', 'docdirect'),
            'hr' => esc_html__('Croatian', 'docdirect'),
            'cs' => esc_html__('Czech', 'docdirect'),
            'da' => esc_html__('Danish', 'docdirect'),
            'dv' => esc_html__('Divehi, Dhivehi, Maldivian', 'docdirect'),
            'nl' => esc_html__('Dutch, Flemish', 'docdirect'),
            'dz' => esc_html__('Dzongkha', 'docdirect'),
            'en' => esc_html__('English', 'docdirect'),
            'eo' => esc_html__('Esperanto', 'docdirect'),
            'et' => esc_html__('Estonian', 'docdirect'),
            'ee' => esc_html__('Ewe', 'docdirect'),
            'fo' => esc_html__('Faroese', 'docdirect'),
            'fj' => esc_html__('Fijian', 'docdirect'),
            'fi' => esc_html__('Finnish', 'docdirect'),
            'fr' => esc_html__('French', 'docdirect'),
            'ff' => esc_html__('Fulah', 'docdirect'),
            'gd' => esc_html__('Gaelic, Scottish Gaelic', 'docdirect'),
            'gl' => esc_html__('Galician', 'docdirect'),
            'lg' => esc_html__('Ganda', 'docdirect'),
            'ka' => esc_html__('Georgian', 'docdirect'),
            'de' => esc_html__('German', 'docdirect'),
            'ki' => esc_html__('Gikuyu, Kikuyu', 'docdirect'),
            'el' => esc_html__('Greek (Modern)', 'docdirect'),
            'kl' => esc_html__('Greenlandic, Kalaallisut', 'docdirect'),
            'gn' => esc_html__('Guarani', 'docdirect'),
            'gu' => esc_html__('Gujarati', 'docdirect'),
            'ht' => esc_html__('Haitian, Haitian Creole', 'docdirect'),
            'ha' => esc_html__('Hausa', 'docdirect'),
            'he' => esc_html__('Hebrew', 'docdirect'),
            'hz' => esc_html__('Herero', 'docdirect'),
            'hi' => esc_html__('Hindi', 'docdirect'),
            'ho' => esc_html__('Hiri Motu', 'docdirect'),
            'hu' => esc_html__('Hungarian', 'docdirect'),
            'is' => esc_html__('Icelandic', 'docdirect'),
            'io' => esc_html__('Ido', 'docdirect'),
            'ig' => esc_html__('Igbo', 'docdirect'),
            'id' => esc_html__('Indonesian', 'docdirect'),
            'ia' => esc_html__('Interlingua (International Auxiliary Language Association)', 'docdirect'),
            'ie' => esc_html__('Interlingue', 'docdirect'),
            'iu' => esc_html__('Inuktitut', 'docdirect'),
            'ik' => esc_html__('Inupiaq', 'docdirect'),
            'ga' => esc_html__('Irish', 'docdirect'),
            'it' => esc_html__('Italian', 'docdirect'),
            'ja' => esc_html__('Japanese', 'docdirect'),
            'jv' => esc_html__('Javanese', 'docdirect'),
            'kn' => esc_html__('Kannada', 'docdirect'),
            'kr' => esc_html__('Kanuri', 'docdirect'),
            'ks' => esc_html__('Kashmiri', 'docdirect'),
            'kk' => esc_html__('Kazakh', 'docdirect'),
            'rw' => esc_html__('Kinyarwanda', 'docdirect'),
            'kv' => esc_html__('Komi', 'docdirect'),
            'kg' => esc_html__('Kongo', 'docdirect'),
            'ko' => esc_html__('Korean', 'docdirect'),
            'kj' => esc_html__('Kwanyama, Kuanyama', 'docdirect'),
            'ku' => esc_html__('Kurdish', 'docdirect'),
            'ky' => esc_html__('Kyrgyz', 'docdirect'),
            'lo' => esc_html__('Lao', 'docdirect'),
            'la' => esc_html__('Latin', 'docdirect'),
            'lv' => esc_html__('Latvian', 'docdirect'),
            'lb' => esc_html__('Letzeburgesch, Luxembourgish', 'docdirect'),
            'li' => esc_html__('Limburgish, Limburgan, Limburger', 'docdirect'),
            'ln' => esc_html__('Lingala', 'docdirect'),
            'lt' => esc_html__('Lithuanian', 'docdirect'),
            'lu' => esc_html__('Luba-Katanga', 'docdirect'),
            'mk' => esc_html__('Macedonian', 'docdirect'),
            'mg' => esc_html__('Malagasy', 'docdirect'),
            'ms' => esc_html__('Malay', 'docdirect'),
            'ml' => esc_html__('Malayalam', 'docdirect'),
            'mt' => esc_html__('Maltese', 'docdirect'),
            'gv' => esc_html__('Manx', 'docdirect'),
            'mi' => esc_html__('Maori', 'docdirect'),
            'mr' => esc_html__('Marathi', 'docdirect'),
            'mh' => esc_html__('Marshallese', 'docdirect'),
            'ro' => esc_html__('Moldovan, Moldavian, Romanian', 'docdirect'),
            'mn' => esc_html__('Mongolian', 'docdirect'),
            'na' => esc_html__('Nauru', 'docdirect'),
            'nv' => esc_html__('Navajo, Navaho', 'docdirect'),
            'nd' => esc_html__('Northern Ndebele', 'docdirect'),
            'ng' => esc_html__('Ndonga', 'docdirect'),
            'ne' => esc_html__('Nepali', 'docdirect'),
            'se' => esc_html__('Northern Sami', 'docdirect'),
            'no' => esc_html__('Norwegian', 'docdirect'),
            'nb' => esc_html__('Norwegian Bokmål', 'docdirect'),
            'nn' => esc_html__('Norwegian Nynorsk', 'docdirect'),
            'ii' => esc_html__('Nuosu, Sichuan Yi', 'docdirect'),
            'oc' => esc_html__('Occitan (post 1500)', 'docdirect'),
            'oj' => esc_html__('Ojibwa', 'docdirect'),
            'or' => esc_html__('Oriya', 'docdirect'),
            'om' => esc_html__('Oromo', 'docdirect'),
            'os' => esc_html__('Ossetian, Ossetic', 'docdirect'),
            'pi' => esc_html__('Pali', 'docdirect'),
            'pa' => esc_html__('Panjabi, Punjabi', 'docdirect'),
            'ps' => esc_html__('Pashto, Pushto', 'docdirect'),
            'fa' => esc_html__('Persian', 'docdirect'),
            'pl' => esc_html__('Polish', 'docdirect'),
            'pt' => esc_html__('Portuguese', 'docdirect'),
            'qu' => esc_html__('Quechua', 'docdirect'),
            'rm' => esc_html__('Romansh', 'docdirect'),
            'rn' => esc_html__('Rundi', 'docdirect'),
            'ru' => esc_html__('Russian', 'docdirect'),
            'sm' => esc_html__('Samoan', 'docdirect'),
            'sg' => esc_html__('Sango', 'docdirect'),
            'sa' => esc_html__('Sanskrit', 'docdirect'),
            'sc' => esc_html__('Sardinian', 'docdirect'),
            'sr' => esc_html__('Serbian', 'docdirect'),
            'sn' => esc_html__('Shona', 'docdirect'),
            'sd' => esc_html__('Sindhi', 'docdirect'),
            'si' => esc_html__('Sinhala, Sinhalese', 'docdirect'),
            'sk' => esc_html__('Slovak', 'docdirect'),
            'sl' => esc_html__('Slovenian', 'docdirect'),
            'so' => esc_html__('Somali', 'docdirect'),
            'st' => esc_html__('Sotho, Southern', 'docdirect'),
            'nr' => esc_html__('South Ndebele', 'docdirect'),
            'es' => esc_html__('Spanish, Castilian', 'docdirect'),
            'su' => esc_html__('Sundanese', 'docdirect'),
            'sw' => esc_html__('Swahili', 'docdirect'),
            'ss' => esc_html__('Swati', 'docdirect'),
            'sv' => esc_html__('Swedish', 'docdirect'),
            'tl' => esc_html__('Tagalog', 'docdirect'),
            'ty' => esc_html__('Tahitian', 'docdirect'),
            'tg' => esc_html__('Tajik', 'docdirect'),
            'ta' => esc_html__('Tamil', 'docdirect'),
            'tt' => esc_html__('Tatar', 'docdirect'),
            'te' => esc_html__('Telugu', 'docdirect'),
            'th' => esc_html__('Thai', 'docdirect'),
            'bo' => esc_html__('Tibetan', 'docdirect'),
            'ti' => esc_html__('Tigrinya', 'docdirect'),
            'to' => esc_html__('Tonga (Tonga Islands)', 'docdirect'),
            'ts' => esc_html__('Tsonga', 'docdirect'),
            'tn' => esc_html__('Tswana', 'docdirect'),
            'tr' => esc_html__('Turkish', 'docdirect'),
            'tk' => esc_html__('Turkmen', 'docdirect'),
            'tw' => esc_html__('Twi', 'docdirect'),
            'ug' => esc_html__('Uighur, Uyghur', 'docdirect'),
            'uk' => esc_html__('Ukrainian', 'docdirect'),
            'ur' => esc_html__('Urdu', 'docdirect'),
            'uz' => esc_html__('Uzbek', 'docdirect'),
            've' => esc_html__('Venda', 'docdirect'),
            'vi' => esc_html__('Vietnamese', 'docdirect'),
            'vo' => esc_html__('Volap_k', 'docdirect'),
            'wa' => esc_html__('Walloon', 'docdirect'),
            'cy' => esc_html__('Welsh', 'docdirect'),
            'fy' => esc_html__('Western Frisian', 'docdirect'),
            'wo' => esc_html__('Wolof', 'docdirect'),
            'xh' => esc_html__('Xhosa', 'docdirect'),
            'yi' => esc_html__('Yiddish', 'docdirect'),
            'yo' => esc_html__('Yoruba', 'docdirect'),
            'za' => esc_html__('Zhuang, Chuang', 'docdirect'),
            'zu' => esc_html__('Zulu', 'docdirect')
        );

        $language_codes = apply_filters('docdirect_filter_languages', $language_codes);

        return $language_codes;
    }

}