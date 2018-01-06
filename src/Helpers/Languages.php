<?php
namespace Sinevia\Cms\Helpers;

//============================= START OF CLASS ==============================//
// CLASS: Langiages                                                          //
//===========================================================================//
class Languages {

    // iso1,name
    public static $data = array(
        array("ab", "Abkhaz"),
        array("aa", "Afar"),
        array("af", "Afrikaans"),
        array("ak", "Akan"),
        array("sq", "Albanian"),
        array("am", "Amharic"),
        array("ar", "Arabic"),
        array("an", "Aragonese"),
        array("hy", "Armenian"),
        array("as", "Assamese"),
        array("av", "Avaric"),
        array("ae", "Avestan"),
        array("ay", "Aymara"),
        array("az", "Azerbaijani"),
        array("bm", "Bambara"),
        array("ba", "Bashkir"),
        array("eu", "Basque"),
        array("be", "Belarusian"),
        array("bn", "Bengali"),
        array("bh", "Bihari"),
        array("bi", "Bislama"),
        array("bs", "Bosnian"),
        array("br", "Breton"),
        array("bg", "Bulgarian"),
        array("my", "Burmese"),
        array("ca", "Catalan; Valencian"),
        array("ch", "Chamorro"),
        array("ce", "Chechen"),
        array("ny", "Chichewa; Chewa; Nyanja"),
        array("zh", "Chinese"),
        array("cv", "Chuvash"),
        array("kw", "Cornish"),
        array("co", "Corsican"),
        array("cr", "Cree"),
        array("hr", "Croatian"),
        array("cs", "Czech"),
        array("da", "Danish"),
        array("dv", "Divehi; Dhivehi; Maldivian;"),
        array("nl", "Dutch"),
        array("en", "English"),
        array("eo", "Esperanto"),
        array("et", "Estonian"),
        array("ee", "Ewe"),
        array("fo", "Faroese"),
        array("fj", "Fijian"),
        array("fi", "Finnish"),
        array("fr", "French"),
        array("ff", "Fula; Fulah; Pulaar; Pular"),
        array("gl", "Galician"),
        array("ka", "Georgian"),
        array("de", "German"),
        array("el", "Greek, Modern"),
        array("gn", "Guaraní"),
        array("gu", "Gujarati"),
        array("ht", "Haitian; Haitian Creole"),
        array("ha", "Hausa"),
        array("he", "Hebrew (modern)"),
        array("hz", "Herero"),
        array("hi", "Hindi"),
        array("ho", "Hiri Motu"),
        array("hu", "Hungarian"),
        array("ia", "Interlingua"),
        array("id", "Indonesian"),
        array("ie", "Interlingue"),
        array("ga", "Irish"),
        array("ig", "Igbo"),
        array("ik", "Inupiaq"),
        array("io", "Ido"),
        array("is", "Icelandic"),
        array("it", "Italian"),
        array("iu", "Inuktitut"),
        array("ja", "Japanese"),
        array("jv", "Javanese"),
        array("kl", "Kalaallisut, Greenlandic"),
        array("kn", "Kannada"),
        array("kr", "Kanuri"),
        array("ks", "Kashmiri"),
        array("kk", "Kazakh"),
        array("km", "Khmer"),
        array("ki", "Kikuyu, Gikuyu"),
        array("rw", "Kinyarwanda"),
        array("ky", "Kirghiz, Kyrgyz"),
        array("kv", "Komi"),
        array("kg", "Kongo"),
        array("ko", "Korean"),
        array("ku", "Kurdish"),
        array("kj", "Kwanyama, Kuanyama"),
        array("la", "Latin"),
        array("lb", "Luxembourgish, Letzeburgesch"),
        array("lg", "Luganda"),
        array("li", "Limburgish, Limburgan, Limburger"),
        array("ln", "Lingala"),
        array("lo", "Lao"),
        array("lt", "Lithuanian"),
        array("lu", "Luba-Katanga"),
        array("lv", "Latvian"),
        array("gv", "Manx"),
        array("mk", "Macedonian"),
        array("mg", "Malagasy"),
        array("ms", "Malay"),
        array("ml", "Malayalam"),
        array("mt", "Maltese"),
        array("mi", "Maori"),
        array("mr", "Marathi (Mara?hi)"),
        array("mh", "Marshallese"),
        array("mn", "Mongolian"),
        array("na", "Nauru"),
        array("nv", "Navajo, Navaho"),
        array("nb", "Norwegian Bokmål"),
        array("nd", "North Ndebele"),
        array("ne", "Nepali"),
        array("ng", "Ndonga"),
        array("nn", "Norwegian Nynorsk"),
        array("no", "Norwegian"),
        array("ii", "Nuosu"),
        array("nr", "South Ndebele"),
        array("oc", "Occitan"),
        array("oj", "Ojibwe, Ojibwa"),
        array("cu", "Old Church Slavonic, Church Slavic, Church Slavonic, Old Bulgarian, Old Slavonic"),
        array("om", "Oromo"),
        array("or", "Oriya"),
        array("os", "Ossetian, Ossetic"),
        array("pa", "Panjabi, Punjabi"),
        array("pi", "Pali"),
        array("fa", "Persian"),
        array("pl", "Polish"),
        array("ps", "Pashto, Pushto"),
        array("pt", "Portuguese"),
        array("qu", "Quechua"),
        array("rm", "Romansh"),
        array("rn", "Kirundi"),
        array("ro", "Romanian, Moldavian, Moldovan"),
        array("ru", "Russian"),
        array("sa", "Sanskrit (Sa?sk?ta)"),
        array("sc", "Sardinian"),
        array("sd", "Sindhi"),
        array("se", "Northern Sami"),
        array("sm", "Samoan"),
        array("sg", "Sango"),
        array("sr", "Serbian"),
        array("gd", "Scottish Gaelic; Gaelic"),
        array("sn", "Shona"),
        array("si", "Sinhala, Sinhalese"),
        array("sk", "Slovak"),
        array("sl", "Slovene"),
        array("so", "Somali"),
        array("st", "Southern Sotho"),
        array("es", "Spanish; Castilian"),
        array("su", "Sundanese"),
        array("sw", "Swahili"),
        array("ss", "Swati"),
        array("sv", "Swedish"),
        array("ta", "Tamil"),
        array("te", "Telugu"),
        array("tg", "Tajik"),
        array("th", "Thai"),
        array("ti", "Tigrinya"),
        array("bo", "Tibetan Standard, Tibetan, Central"),
        array("tk", "Turkmen"),
        array("tl", "Tagalog"),
        array("tn", "Tswana"),
        array("to", "Tonga (Tonga Islands)"),
        array("tr", "Turkish"),
        array("ts", "Tsonga"),
        array("tt", "Tatar"),
        array("tw", "Twi"),
        array("ty", "Tahitian"),
        array("ug", "Uighur, Uyghur"),
        array("uk", "Ukrainian"),
        array("ur", "Urdu"),
        array("uz", "Uzbek"),
        array("ve", "Venda"),
        array("vi", "Vietnamese"),
        array("vo", "Volapük"),
        array("wa", "Walloon"),
        array("cy", "Welsh"),
        array("wo", "Wolof"),
        array("fy", "Western Frisian"),
        array("xh", "Xhosa"),
        array("yi", "Yiddish"),
        array("yo", "Yoruba"),
        array("za", "Zhuang, Chuang")
    );
    private static $_language_iso1s = false;
    private static $_language_names = false;

    //========================= START OF METHOD ===========================//
    //  METHOD: _parse                                                     //
    //=====================================================================//
    /**
     * Parses the languages into convenient arrays.
     */
    public static function _parse() {
        if (self::$_language_iso1s !== false) {
            return true;
        }
        self::$_language_iso1s = array();
        self::$_language_names = array();
        for ($i = 0; $i < count(self::$data); $i++) {
            self::$_language_iso1s[] = self::$data[$i][0];
            self::$_language_names[] = self::$data[$i][1];
        }
    }

    /**
     * Returns an array with the 2 letter abbreviation of languages according
     * to ISO standard.
     * <code>
     * foreach(Languages::getLanguagesAsIso1(){
     *     echo($iso2);
     * }
     * </code>
     * @return Array the 2 letter abbreviation of languages
     * @tested true
     */
    public static function getLanguagesAsIso1() {
        self::_parse();
        return self::$_language_iso1s;
    }

    /**
     * A list of the languages in the world.
     * <code>
     * foreach(Languages::getLanguagesAsNames() as $name){
     *     echo($name);
     * }
     * </code>
     * @return Array the world languages (keys are the abbrevieations)
     * @tested true
     */
    public static function getLanguagesAsNames() {
        self::_parse();
        return self::$_language_names;
    }

    /**
     * Gets a language name from the given code.
     * <code>
     * $language = Languages::getLanguageByIso1("en");
     * </code>
     * @return String
     * @tested true
     */
    public static function getLanguageByIso1($iso1) {
        self::_parse();
        $pos = array_search(strtolower($iso1), self::$_language_iso1s);
        if ($pos === false){
            return '';
        }
        return self::$_language_names[$pos];
    }
}
//===========================================================================//
// CLASS: Languages                                                          //
//============================== END OF CLASS ===============================//
?>