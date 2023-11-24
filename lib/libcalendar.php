<?php

/***********************************************************
 * ¥«¥ì¥ó¥À¡¼¥·¥¹¥Æ¥àÍÑ¥é¥¤¥Ö¥é¥ê
 *
 * $Id: libcalendar.php 8212 2013-09-09 08:33:03Z maruyoshi $
 * $Revision: 8212 $
 * $Date:: 2013-09-09 17:33:03 +0900#$
 **********************************************************/

/* ¥Þ¥¯¥íÄêµÁ */
define("ETCDIR", "etc/");
define("BASEDIR", "/usr/medaca/");

/* ÀßÄê¥Õ¥¡¥¤¥ëÌ¾ */
define("CALCONF", "medaca.conf");

/* ÀßÄê¥Õ¥¡¥¤¥ë¤ÎDBTypeÍÑ */
define("DBTYPE_LDAP", "LDAP");

/* URL³ÎÇ§ÍÑ */
define("LIGHTNING", "0");
define("IPHONE",    "1");
define("URL_CALENDARS",  "calendars");
define("URL_PRINCIPALS", "principals");
define("URL_SPLIT_IPHONE_MIN"   , "3");
define("URL_SPLIT_IPHONE_MAX"   , "4");
define("URL_SPLIT_LIGHTNING_MIN", "4");
define("URL_SPLIT_LIGHTNING_MAX", "5");

/* syslog½ÐÎÏÍÑ */
define("IDENT", "medaca");

/* ¥«¥ì¥ó¥À¡¼ÍÑ¥ª¥Ö¥¸¥§¥¯¥ÈÌ¾ */
define("OBJNAME_CALRESOURCE",   "calendarResource");
define("OBJNAME_CALCOLLECTION", "calendarCollection");
define("OBJNAME_CALDATA",       "calendarData");

/* ¥«¥ì¥ó¥À¡¼ÍÑÍ×ÁÇÌ¾ */
define("OBJECTCLASS",           "objectClass");
define("CALRESOURCE",           "resource");
define("COLLECTIONCOUNT",       "collectionCount");
define("CALADMINU",             "calendarAdminU");
define("CALCOLLECTION",         "collection");
define("CALACTIVE",             "collectionActive");
define("CALAUTHORITYDEF",       "authorityDefault");
define("CALAUTHORITYORDER",     "authorityOrder");
define("CALAUTHORITYARTICLE",   "authorityArticle");
define("CALCTAG",               "calendarCTag");
define("CALOBJURI",             "calObjectUri");
define("CALOBJDATA",            "calData");
define("CALMODTIME",            "calTime");
define("COLLECTIONNUMMAX",      "collectionNumMax");
define("COLLECTIONNUMBER",     "collectionNumber");
define("COLLECTIONDESCRIPTION", "collectionDescription");

/* ¥æ¡¼¥¶Ì¾Ä¹ */
define("NAME_MIN", 1);
define("NAME_MAX", 20);

/* ¥ê¥½¡¼¥¹Ì¾Ä¹ */
define("RESOURCE_NAME_MIN", 1);
define("RESOURCE_NAME_MAX", 20);

/* ¥³¥ì¥¯¥·¥ç¥óÌ¾Ä¹ */
define("COLLECTION_NAME_MIN", 1);
define("COLLECTION_NAME_MAX", 20);

/* ´Ø¿ô¤ÎÌá¤êÃÍ */
define("FUNC_TRUE",   "1");
define("FUNC_FALSE",  "0");
define("FUNC_SYSERR", "-1");

/* ±þÅú¥¿¥¤¥× */
define("RETTYPE_ONE",  "0");
define("RETTYPE_MANY", "1");

/* ¸¢¸Â¤Î¿ôÃÍ */
define("AUTHREADONLY",    "0");
define("AUTHREADWRITE",   "1");
define("AUTHRESTRICTION", "2");

/* ¥¢¥¯¥Æ¥£¥Ö¥Õ¥é¥° */
define("COLLECTION_ACTIVE",   1);
define("COLLECTION_INACTIVE", 0);

/* ¼«Æ°À¸À®¥Õ¥é¥° */
define("AUTOCREATE_ON",  "1");
define("AUTOCREATE_OFF", "0");

/* authorityArticle¤Î¥æ¡¼¥¶ */
define("ARTICLE_SEP", "U");
/* authorityArticle¤Î¥Ç¥Õ¥©¥ë¥ÈID */
define("ARTICLE_DEF_ID", "0");

/* collection=home */
define("COLLHOME", "home");

/* authorityDefault¤Î¥Ç¥Õ¥©¥ë¥ÈÃÍ */
define("CALAUTHORITYDEF_DEF", "0");

/* calendarCtag¤Î¥Ç¥Õ¥©¥ë¥ÈÃÍ */
define("CALCTAG_DEF", "0");

/* collectionCount¤Î¥Ç¥Õ¥©¥ë¥ÈÃÍ */
define("COLLECTIONCOUNT_DEF", "1");

/* collectionNumMax¤Î¥Ç¥Õ¥©¥ë¥ÈÃÍ */
define("COLLECTIONNUMMAX_DEF", "1");

/* collectionNumber¤Î¥Ç¥Õ¥©¥ë¥ÈÃÍ */
define("COLLECTIONNUMBER_DEF", "1");

/* ¥ê¥½¡¼¥¹ÄÉ²Ã¼ºÇÔ */
define("RESO_FALSE", "-1");

/* ¥³¥ì¥¯¥·¥ç¥óÄÉ²Ã¼ºÇÔ */
define("COLL_FALSE", "-2");

/* CALDAV·ÏÄêµÁ */
define("CALDAV_VEVENT",       "VEVENT");
define("CALDAV_VTODO",        "VTODO");
define("CALDAV_ID",           "id");
define("CALDAV_URI",          "uri");
define("CALDAV_PRINCIPALURI", "principaluri");
define("CALDAV_CALENDARID_DEF",     "1");
define("CALDAV_CALENDARDATA", "calendardata");
define("CALDAV_CALENDARID",   "calendarid");
define("CALDAV_LASTMODIFIED", "lastmodified");
define("CALDAV_ID_NUM",           0);
define("CALDAV_CALENDARDATA_NUM", 1);
define("CALDAV_URI_NUM",          2);
define("CALDAV_CALENDARID_NUM",   3);
define("CALDAV_LASTMODIFIED_NUM", 4);

/*********************************************************
 * read_calendar_conf()
 *
 * ÀßÄê¥Õ¥¡¥¤¥ë¤ÎÆÉ¤ß¹þ¤ß¤ò¹Ô¤¦
 *
 * [°ú¿ô]
 *       $calendar_conf ÀßÄê¥Õ¥¡¥¤¥ë¾ðÊó(»²¾ÈÅÏ¤·)
 * [ÊÖ¤êÃÍ]
 *       TRUE         Àµ¾ï
 *       FALSE        ÀßÄê¥Õ¥¡¥¤¥ëÆÉ¤ß¹þ¤ß°Û¾ï
 **********************************************************/
function read_calendar_conf(&$calendar_conf)
{
    /* ÀßÄê¥Õ¥¡¥¤¥ë¹àÌÜ */
    $conf_keys = array(
                    "syslogfacility"            => "DgCommon_is_facility",
                    "dbtype"                    => "dbtype_check",
                    "ldapserver"                => "DgCommon_check_none",
                    "ldapport"                  => "DgCommon_check_none",
                    "ldapbinddn"                => "DgCommon_check_none",
                    "ldapbindpw"                => "DgCommon_check_none",
                    "ldapbasedn"		=> "DgCommon_check_none",
                    "autoresourcecreate"	=> "DgCommon_is_bool",
                    "authldap"                  => "DgCommon_is_bool",
                    "authldapserver"            => "DgCommon_check_none",
                    "authldapport"              => "DgCommon_check_none",
                    "authldapbinddn"            => "DgCommon_check_none",
                    "authldapbindpw"            => "DgCommon_check_none",
                    "authldapbasedn"		=> "DgCommon_check_none",
                    "authldapfilter"		=> "DgCommon_check_none",
                    "autocreatecollectionname"	
						=> "check_collection_name",
                    );

    /* ÀßÄê¤Î¥Ç¥Õ¥©¥ë¥ÈÃÍ */
    $conf_def = array(
                    "syslogfacility"            => "local1",
                    "ldapserver"                => "localhost",
                    "ldapport"                  => "389",
                    "authldap"                  => "0",
                    "authldapserver"            => "localhost",
                    "authldapport"              => "389",
                    "autoresourcecreate"        => "1",
		    "autocreatecollectionname"  => "home",
		    "authldapbinddn"            => "",
		    "authldapfilter"            => "",
		    "authldapbasedn"            => "",
		    "authldapbindpw"            => ""
                    );

    /* ÀßÄê¥Õ¥¡¥¤¥ëÆÉ¤ß¹þ¤ß */
    $filepath = BASEDIR . ETCDIR . CALCONF;
    $calendar_conf = DgCommon_read_conf($filepath, $conf_keys, $conf_def);
    if ($calendar_conf === FALSE) {
        return FALSE;
    }

    return TRUE;
}

/*********************************************************
 * dbtype_check()
 *
 * DBtype¥Á¥§¥Ã¥¯
 *
 * [°ú¿ô]
 *      $dbtype         DBtype
 * [ÊÖ¤êÃÍ]
 *      TRUE            Àµ¾ï
 *      FALSE           °Û¾ï
 **********************************************************/
function dbtype_check($dbtype)
{
    $checkarray = array(DBTYPE_LDAP);
    
    $ret = array_search($dbtype, $checkarray);
    if ($ret === FALSE) {
        return FALSE;
    }

    return TRUE;
}

/***********************************************************
 * result_log()
 *
 * ¥í¥°¥Õ¥¡¥¤¥ë¤ËÂÐ¤·¡¢¥¨¥é¡¼¥í¥°½ÐÎÏ¤ò¹Ô¤¦
 *
 * [°ú¿ô]
 *      $resultlog      ¥¨¥é¡¼¥á¥Ã¥»¡¼¥¸
 * [ÊÖ¤êÃÍ]
 *      ¤Ê¤·
 ************************************************************/
function result_log($resultlog)
{
    global $calendar_conf;

    /* ¥Õ¥¡¥¤¥ë¤¬ÆÉ¤ß¹þ¤Þ¤ì¤ÆÀßÄê¤µ¤ì¤Æ¤¤¤¿ */
    if (isset($calendar_conf['syslogfacility']) ) {
        /* ½ÐÎÏÀèÌ¾ */
        $syslog = DgCommon_set_logfacility($calendar_conf['syslogfacility']);

        if (!isset($syslog)) {
            $syslog = LOG_LOCAL1;
        }
    } else {
        /* ¥Õ¥¡¥¤¥ë¤¬ÆÉ¤ß¹þ¤Þ¤ì¤Ê¤«¤Ã¤¿¾ì¹ç */
        $syslog = LOG_LOCAL1;
    }

    /* ½ñ¤­¹þ¤ß¤¿¤¤¥í¥°¤ÎÆâÍÆ¤Ë¥í¥°É½¼¨Ì¾¡¢¥í¥°¥¤¥ó¥æ¡¼¥¶Ì¾¤ò·ë¹ç¡£*/
    $user = "";
    if (isset($_SERVER['REMOTE_USER'])) {
        $user = $_SERVER['REMOTE_USER'];
    }
    $msg = $user . " " . $resultlog . "\n";

    /* ¥í¥°¥ª¡¼¥×¥ó */
    $ret = openlog(IDENT, LOG_PID, $syslog);
    if ($ret === FALSE) {
        return;
    }

    /* ¥í¥°½ÐÎÏ */
    syslog(LOG_ERR, $msg);
    closelog();

    return;
}

/*********************************************************
 * check_user()
 *
 * HTTP¥ê¥¯¥¨¥¹¥È¤è¤ê¥æ¡¼¥¶Ì¾¤ò³ÎÇ§¤¹¤ë
 *
 * [°ú¿ô]
 *       ¤Ê¤·
 * [ÊÖ¤êÃÍ]
 *       TRUE         Àµ¾ï
 *       FALSE        °Û¾ï(Ç§¾Ú¤òÄÌ¤Ã¤Æ¤¤¤Ê¤¤)
 **********************************************************/
function check_user()
{
    global $dg_log_msg;

    /* ¥æ¡¼¥¶¥¢¥«¥¦¥ó¥È¤Î³ÎÇ§ */
    if (isset($_SERVER["PHP_AUTH_USER"]) === FALSE &&
        isset($_SERVER["PHP_AUTH_PW"]) === FALSE ) {
        /* Ç§¾Ú¤·¤Æ¤¤¤Ê¤¤ */
        $dg_log_msg = "Authentication is not being used.";
        return FALSE;
    }

    /* ·Á¼°³ÎÇ§ */
    $ret = check_user_name($_SERVER["PHP_AUTH_USER"]);
    if ($ret === FALSE) {
        return FALSE;
    }

    return TRUE;
}

/*********************************************************
 * check_auth_digest()
 *
 * Ç§¾ÚÊýË¡¤¬DIGESTÇ§¾Ú¤Ç¤¢¤ë¤³¤È¤ò³ÎÇ§¤¹¤ë
 *
 * [°ú¿ô]
 *       ¤Ê¤·
 * [ÊÖ¤êÃÍ]
 *       TRUE         Àµ¾ï
 *       FALSE        °Û¾ï(Ç§¾Ú¤òÄÌ¤Ã¤Æ¤¤¤Ê¤¤)
 **********************************************************/
function check_auth_digest()
{
    global $dg_log_msg;

    if (empty($_SERVER['PHP_AUTH_DIGEST'])) {
        /* Ç§¾Ú¤·¤Æ¤¤¤Ê¤¤ */
        $dg_log_msg = "Authentication is not being used.";
        return FALSE;
    }

    return TRUE;
}

/*********************************************************
 * get_username()
 *
 * ¥¯¥é¥¤¥¢¥ó¥È¤«¤éÁ÷¿®¤µ¤ì¤¿¡ÖAuthorization¡×¤ÎÆâÍÆ¤«¤é¥æ¡¼¥¶Ì¾¤ò¼èÆÀ
 *
 * [°ú¿ô]
 *       ¤Ê¤·
 * [ÊÖ¤êÃÍ]
 *       $username    ¥æ¡¼¥¶Ì¾
 *       FALSE        ÉÔÀµ¤Ê·Á¼°
 **********************************************************/
function get_username()
{
    $username = "";

    /* ¥æ¡¼¥¶Ì¾¼èÆÀ */
    $response   = explode(",", str_replace('"', '', $_SERVER['PHP_AUTH_DIGEST']));
    $tmp = null;
    foreach ($response as $v) {
        $tmp = explode("=", trim($v));
        if ($tmp[0] === "username") {
            $username  = $tmp[1];
            break;
        }
    }

    /* ·Á¼°³ÎÇ§ */
    $ret = check_user_name($username);
    if ($ret === FALSE) {
        return FALSE;
    }

    return $username;
}

/*********************************************************
 * check_url()
 *
 * HTTP¥ê¥¯¥¨¥¹¥È¤«¤éURI³ÎÇ§¤Èresource,collection¤Î¼èÆÀ
 *
 * [°ú¿ô]
 *       $resource    ¥ê¥½¡¼¥¹Ì¾(»²¾ÈÅÏ¤·)
 *       $collection  ¥³¥ì¥¯¥·¥ç¥óÌ¾(»²¾ÈÅÏ¤·)
 * [ÊÖ¤êÃÍ]
 *       TRUE         Àµ¾ï
 *       FALSE        °Û¾ï(»ØÄê¤µ¤ì¤Æ¤¤¤ë¥Ñ¥¹¤¬°Û¾ï)
 **********************************************************/
function check_url(&$resource, &$collection)
{
    global $dg_log_msg;
    global $access_type;

    /* ½é´ü²½ */
    $calendars  = "";
    $resource   = "";
    $collection = "";
    $min = URL_SPLIT_LIGHTNING_MIN;
    $max = URL_SPLIT_LIGHTNING_MAX;

    /* PATHÊ¬³ä */
    $tmp = explode("/", $_SERVER["PATH_INFO"]);
    if (strcmp($tmp[1], URL_PRINCIPALS) == 0) {
        $min = URL_SPLIT_IPHONE_MIN;
        $max = URL_SPLIT_IPHONE_MAX;
        $access_type = IPHONE;
    }
    $tmpcount = count($tmp);
    if ($tmpcount != $min && $tmpcount != $max) {
        /* »ØÄê¤·¤Æ¤¤¤ë¥Ñ¥¹¤¬°ã¤¦ */
        $dg_log_msg = "Invalid URI.(" . $_SERVER["PATH_INFO"] . ")";
        return FALSE;
    }

    $calendars  = $tmp[1];
    $resource   = $tmp[2];
    $collection = $tmp[3];

    /* ¥Ñ¥¹¤Î³ÎÇ§ */
    if ($access_type == IPHONE) {
        if ($collection != "") {
            $dg_log_msg = "Invalid URI.(" . $_SERVER["PATH_INFO"] . ")";
            return FALSE;
        }
    } else if (strcmp($calendars, URL_CALENDARS) != 0) {
        /* »ØÄê¤·¤Æ¤¤¤ë¥Ñ¥¹¤¬°ã¤¦ */
        $dg_log_msg = "Invalid URI.(" . $_SERVER["PATH_INFO"] . ")";
        return FALSE;
    }

    return TRUE;
}

/*********************************************************
 * check_user_name()
 *
 * ¥æ¡¼¥¶Ì¾¤Î·Á¼°³ÎÇ§
 *
 * [°ú¿ô]
 *       $name        ¥æ¡¼¥¶Ì¾
 * [ÊÖ¤êÃÍ]
 *       TRUE         Àµ¾ï
 *       FALSE        °Û¾ï
 **********************************************************/
function check_user_name($name)
{
    global $dg_log_msg;

    /* Ä¹¤µ¥Á¥§¥Ã¥¯ */
    $len = strlen($name);
    if ($len < NAME_MIN || $len > NAME_MAX) {
        $dg_log_msg = "Invalid user name.($name)";
        return FALSE;
    }

    /* È¾³Ñ±Ñ¾®Ê¸»úÂçÊ¸»ú¡¢¿ô»ú¡¢µ­¹æ[-_.]¤Î¤ßµö²Ä */
    $num = "0123456789";
    $sl = "abcdefghijklmnopqrstuvwxyz";
    $ll = strtoupper($sl);
    $sym = "-_.";
    $allow_letter = $num . $sl . $ll . $sym;
    if (strspn($name, $allow_letter) != $len) {
        $dg_log_msg = "Invalid user name.($name)";
        return FALSE;
    }

    return TRUE;
}

/*********************************************************
 * check_resource_name()
 *
 * ¥ê¥½¡¼¥¹Ì¾¤Î·Á¼°³ÎÇ§
 *
 * [°ú¿ô]
 *       $name        ¥ê¥½¡¼¥¹Ì¾
 * [ÊÖ¤êÃÍ]
 *       TRUE         Àµ¾ï
 *       FALSE        °Û¾ï
 **********************************************************/
function check_resource_name($name)
{
    global $dg_log_msg;

    /* Ä¹¤µ¥Á¥§¥Ã¥¯ */
    $len = strlen($name);
    if ($len < RESOURCE_NAME_MIN || $len > RESOURCE_NAME_MAX) {
        $dg_log_msg = "Invalid resource name.(" . $_SERVER["PATH_INFO"] . ")";
        return FALSE;
    }

    /* È¾³Ñ±Ñ¾®Ê¸»úÂçÊ¸»ú¡¢¿ô»ú¡¢µ­¹æ[-_.]¤Î¤ßµö²Ä */
    $num = "0123456789";
    $sl = "abcdefghijklmnopqrstuvwxyz";
    $ll = strtoupper($sl);
    $sym = "-_.";
    $allow_letter = $num . $sl . $ll . $sym;
    if (strspn($name, $allow_letter) != $len) {
        $dg_log_msg = "Invalid resource name.(" . $_SERVER["PATH_INFO"] . ")";
        return FALSE;
    }

    return TRUE;
}

/*********************************************************
 * check_collection_name()
 *
 * ¥³¥ì¥¯¥·¥ç¥óÌ¾¤Î·Á¼°³ÎÇ§
 *
 * [°ú¿ô]
 *       $name        ¥³¥ì¥¯¥·¥ç¥óÌ¾
 * [ÊÖ¤êÃÍ]
 *       TRUE         Àµ¾ï
 *       FALSE        °Û¾ï
 **********************************************************/
function check_collection_name($name)
{
    global $dg_log_msg;

    /* Ä¹¤µ¥Á¥§¥Ã¥¯ */
    $len = strlen($name);
    if ($len < COLLECTION_NAME_MIN || $len > COLLECTION_NAME_MAX) {
        $dg_log_msg = "Invalid collection name.(" . $_SERVER["PATH_INFO"] . ")";
        return FALSE;
    }

    /* È¾³Ñ±Ñ¾®Ê¸»úÂçÊ¸»ú¡¢¿ô»ú¡¢µ­¹æ[-_.]¤Î¤ßµö²Ä */
    $num = "0123456789";
    $sl = "abcdefghijklmnopqrstuvwxyz";
    $ll = strtoupper($sl);
    $sym = "-_.";
    $allow_letter = $num . $sl . $ll . $sym;
    if (strspn($name, $allow_letter) != $len) {
        $dg_log_msg = "Invalid collection name.(" . $_SERVER["PATH_INFO"] . ")";
        return FALSE;
    }

    return TRUE;
}

/*********************************************************
 * get_resource()
 *
 * »ØÄê¤·¤¿¥ê¥½¡¼¥¹¤ÎLDAP¾ðÊó¤ò¼èÆÀ¤¹¤ë
 *
 * [°ú¿ô]
 *       $dg_ldapid    ¥ê¥ó¥¯ID
 *       $resource     ¥ê¥½¡¼¥¹Ì¾
 *       $ldapdata     ¸¡º÷¤·¤¿LDAP¥Ç¡¼¥¿(»²¾ÈÅÏ¤·)
 * [ÊÖ¤êÃÍ]
 *       FUNC_TRUE      LDAP¾ðÊó¤ò¸«¤Ä¤±¤¿
 *       FUNC_FALSE     LDAP¾ðÊó¤¬¸«¤Ä¤«¤é¤Ê¤«¤Ã¤¿
 *       FUNC_SYSERR    °Û¾ï¤¬È¯À¸¤·¤¿
 **********************************************************/
function get_resource($dg_ldapid, $resource, &$ldapdata)
{
    global $dg_log_msg;
    global $calendar_conf;

    /* filterºîÀ® */
    $filter = sprintf("%s=%s",
                      CALRESOURCE, DgLDAP_filter_escape($resource));
    $attrs = array();
    $scope = TYPE_ONEENTRY;
    $dn = sprintf("%s=%s,%s",
                   CALRESOURCE, LDAP_dn_escape($resource),
                   $calendar_conf["ldapbasedn"]);

    /* LDAP¤Î¾ðÊó¤ò¼èÆÀ */
    $data = array();
    $ret = DgLDAP_get_entry_batch($dn, $dg_ldapid,
                                  $filter, $attrs, $scope, $data);
    if ($ret == LDAP_ERR_NODATA) {
        return FUNC_FALSE;
    } elseif ($ret != LDAP_OK) {
        return FUNC_SYSERR;
    }

    $ldapdata = $data[0];

    return FUNC_TRUE;
}

/*********************************************************
 * ldap_calendar_add()
 *
 * ¥«¥ì¥ó¥À¡¼¥Ç¡¼¥¿¤òÄÉ²Ã¤¹¤ë
 *
 * [°ú¿ô]
 *       $resource          ¥ê¥½¡¼¥¹Ì¾
 *       $collection¡¡¡¡¡¡¡¡¥³¥ì¥¯¥·¥ç¥óÌ¾
 *       $objecturi¡¡¡¡¡¡¡¡ ¥«¥ì¥ó¥À¡¼ID
 *       $caldata           ¥«¥ì¥ó¥À¡¼¾ðÊó
 *
 * [ÊÖ¤êÃÍ]
 *       TRUE               ÄÉ²ÃÀ®¸ù
 *       FALSE              ÄÉ²Ã¼ºÇÔ
 **********************************************************/
function ldap_calendar_add($resource, $collection, $objecturi, $caldata)
{
    global $calendar_conf;
    global $dg_log_msg;
    global $dg_ldapid;

    /* dn ºîÀ® */
    $dn = sprintf("%s=%s,%s=%s,%s=%s,%s",
                  CALOBJURI, LDAP_dn_escape($objecturi),
                  CALCOLLECTION, LDAP_dn_escape($collection),
                  CALRESOURCE, LDAP_dn_escape($resource),
                  $calendar_conf["ldapbasedn"]);

    /* LDAP ÄÉ²Ã */
    $ret = DgLDAP_add_entry_batch($dn, $dg_ldapid, $caldata);
    if ($ret != LDAP_OK) {
        return FALSE;
    }

    return TRUE;
}

/*********************************************************
 * ldap_calendar_mod()
 *
 * ¥«¥ì¥ó¥À¡¼¥Ç¡¼¥¿¤òÊÑ¹¹¤¹¤ë
 *
 * [°ú¿ô]
 *       $resource          ¥ê¥½¡¼¥¹Ì¾
 *       $collection¡¡¡¡¡¡¡¡¥³¥ì¥¯¥·¥ç¥óÌ¾
 *       $objecturi¡¡¡¡¡¡¡¡ ¥«¥ì¥ó¥À¡¼ID
 *       $caldata           ¥«¥ì¥ó¥À¡¼¾ðÊó
 *
 * [ÊÖ¤êÃÍ]
 *       TRUE               ÊÑ¹¹À®¸ù
 *       FALSE              ÊÑ¹¹¼ºÇÔ
 **********************************************************/
function ldap_calendar_mod($resource, $collection, $objecturi, $caldata)
{
    global $calendar_conf;
    global $dg_ldapid;

    /* dn ºîÀ® */
    $dn = sprintf("%s=%s,%s=%s,%s=%s,%s",
                  CALOBJURI, LDAP_dn_escape($objecturi),
                  CALCOLLECTION, LDAP_dn_escape($collection),
                  CALRESOURCE, LDAP_dn_escape($resource),
                  $calendar_conf["ldapbasedn"]);

    /* LDAP ÊÑ¹¹ */
    $ret = DgLDAP_mod_entry_batch($dn, $dg_ldapid, $caldata);
    if ($ret != LDAP_OK) {
        return FALSE;
    }

    return TRUE;
}

/*********************************************************
 * ldap_calendar_del()
 *
 * ¥«¥ì¥ó¥À¡¼¥Ç¡¼¥¿¤òÊÑ¹¹¤¹¤ë
 *
 * [°ú¿ô]
 *       $resource          ¥ê¥½¡¼¥¹Ì¾
 *       $collection¡¡¡¡¡¡¡¡¥³¥ì¥¯¥·¥ç¥óÌ¾
 *       $objecturi¡¡¡¡¡¡¡¡ ¥«¥ì¥ó¥À¡¼ID
 *
 * [ÊÖ¤êÃÍ]
 *       TRUE               ºï½üÀ®¸ù
 *       FALSE              ºï½ü¼ºÇÔ
 **********************************************************/
function ldap_calendar_del($resource, $collection, $objecturi)
{
    global $calendar_conf;
    global $dg_ldapid;

    /* dn ºîÀ® */
    $dn = sprintf("%s=%s,%s=%s,%s=%s,%s",
                  CALOBJURI, LDAP_dn_escape($objecturi),
                  CALCOLLECTION, LDAP_dn_escape($collection),
                  CALRESOURCE, LDAP_dn_escape($resource),
                  $calendar_conf["ldapbasedn"]);

    /* LDAP ºï½ü */
    $ret = DgLDAP_del_entry_batch($dn, $dg_ldapid);
    if ($ret != LDAP_OK) {
        return FALSE;
    }

    return TRUE;
}

/*********************************************************
 * ldap_collection_ctag_update()
 *
 * collection¤Ë¤¢¤ëCTAG¤ò¹¹¿·¤¹¤ë
 *
 * [°ú¿ô]
 *       $resource          ¥ê¥½¡¼¥¹Ì¾
 *       $collection¡¡¡¡¡¡¡¡¥³¥ì¥¯¥·¥ç¥óÌ¾
 *       $ctag              ¹¹¿·¤¹¤ëCTag¾ðÊó
 *
 * [ÊÖ¤êÃÍ]
 *      TRUE     Àµ¾ï
 *      FALSE    °Û¾ï
 **********************************************************/
function ldap_collection_ctag_update($resource, $collection, $ctag)
{
    global $calendar_conf;
    global $dg_ldapid;

    /* collection¤Î¾ðÊó¤ò¹¹¿· */
    /* dn ºîÀ® */
    $dn = sprintf("%s=%s,%s=%s,%s",
                  CALCOLLECTION, LDAP_dn_escape($collection),
                  CALRESOURCE, LDAP_dn_escape($resource),
                  $calendar_conf["ldapbasedn"]);

    /* ¹¹¿·¤¹¤ëCTag */
    $data[CALCTAG] = $ctag;

    /* LDAP ¹¹¿· */
    $ret = DgLDAP_mod_entry_batch($dn, $dg_ldapid, $data);
    if ($ret != LDAP_OK) {
        return FALSE;
    }

    return TRUE;
}

/*********************************************************************
 * set_ldapinfo
 *
 * ldapinfoºîÀ®
 *
 * [°ú¿ô]
 *      $authldap       Ldap Auth check
 *
 * [ÊÖ¤êÃÍ]
 *      TRUE             Àµ¾ï
 **********************************************************************/
function set_ldapinfo($authldap = FALSE)
{
    global $calendar_conf;
    global $dg_ldapinfo;

    /* ¼«Ê¬¼«¿È¤Ø¤Î¥Ð¥¤¥ó¥É(Í­¸ú: TRUE Ìµ¸ú: FALSE) */
    $dg_ldapinfo["ldapuserself"] = FALSE;

    /* ¼«Ê¬¼«¿È¤Ø¥Ð¥¤¥ó¥É¤¹¤ë¾ì¹ç¤Î¥Ð¥¤¥ó¥ÉDN */
    $dg_ldapinfo["ldapuserselfdn"] = "";

    /* ¼«Ê¬¼«¿È¤Ø¥Ð¥¤¥ó¥É¤¹¤ë¾ì¹ç¤Î¥Ð¥¤¥ó¥É¥Ñ¥¹¥ï¡¼¥É */
    $dg_ldapinfo["ldapuserselfpw"] = "";

    /* read-only¥µ¡¼¥Ð¤Ø¤Î¥Ð¥¤¥ó¥É(Í­¸ú: TRUE Ìµ¸ú: FALSE) */
    $dg_ldapinfo["ldapro"] = FALSE;

    /* read-only¥µ¡¼¥Ð¤ÎIP¥¢¥É¥ì¥¹ */
    $dg_ldapinfo["ldapserverro"] = "";

    /* read-only¥µ¡¼¥Ð¤Î¥Ý¡¼¥ÈÈÖ¹æ */
    $dg_ldapinfo["ldapportro"] = "";

    /* °ú¿ô¤¬ÅÏ¤µ¤ì¤¿¾ì¹ç*/
    if ($authldap) {
        /* LDAP¥µ¡¼¥Ð¤ÎIP¥¢¥É¥ì¥¹ */
        $dg_ldapinfo["ldapserver"] = $calendar_conf["authldapserver"];

        /* LDAP¥µ¡¼¥Ð¤Î¥Ý¡¼¥ÈÈÖ¹æ */
        $dg_ldapinfo["ldapport"] = $calendar_conf["authldapport"];

        /* LDAP¥µ¡¼¥Ð¤Î¥Ð¥¤¥ó¥ÉDN */
        $dg_ldapinfo["ldapbinddn"] = $calendar_conf["authldapbinddn"];

        /* LDAP¥µ¡¼¥Ð¤Î¥Ð¥¤¥ó¥É¥Ñ¥¹¥ï¡¼¥É */
        $dg_ldapinfo["ldapbindpw"] = $calendar_conf["authldapbindpw"];

    /* °ú¿ô¤¬ÅÏ¤µ¤Ê¤¤¾ì¹ç*/
    } else {
        /* LDAP¥µ¡¼¥Ð¤ÎIP¥¢¥É¥ì¥¹ */
        $dg_ldapinfo["ldapserver"] = $calendar_conf["ldapserver"];

        /* LDAP¥µ¡¼¥Ð¤Î¥Ý¡¼¥ÈÈÖ¹æ */
        $dg_ldapinfo["ldapport"] = $calendar_conf["ldapport"];

        /* LDAP¥µ¡¼¥Ð¤Î¥Ð¥¤¥ó¥ÉDN */
        $dg_ldapinfo["ldapbinddn"] = $calendar_conf["ldapbinddn"];

        /* LDAP¥µ¡¼¥Ð¤Î¥Ð¥¤¥ó¥É¥Ñ¥¹¥ï¡¼¥É */
        $dg_ldapinfo["ldapbindpw"] = $calendar_conf["ldapbindpw"];
    }

    return TRUE;
}

 /********************************************************************
 * ldap_connect_server()
 *
 * LDAP¤ËÀÜÂ³
 *
 * [°ú¿ô]
 *      $ds         ¥ê¥ó¥¯ID(»²¾ÈÅÏ¤·)
 *
 * [ÊÖ¤êÃÍ]
 *      TRUE        Àµ¾ï
 *      FALUSE      °Û¾ï
 *********************************************************************/
function ldap_connect_server(&$ds)
{
    global $calendar_conf;

    /* ldapinfo¤ÎÃÍ¤òÆþ¤ì¤ë */
    set_ldapinfo();

    /* LDAPÀÜÂ³ */
    $ds = DgLDAP_connect_server();
    if ($ds == LDAP_ERR_BIND) {
        return FALSE;
    }

    return TRUE;
}

/*********************************************************************
 * search_all_calendar()
 *
 * LDAP¤«¤é¥³¥ì¥¯¥·¥ç¥óÇÛ²¼¤Ë¤¢¤ëÁ´¤Æ¤Î¥«¥ì¥ó¥À¡¼¾ðÊó¤ò¸¡º÷¤·¡¢¼èÆÀ¤¹¤ë
 *
 * [°ú¿ô]
 *      $resource        ¥ê¥½¡¼¥¹Ì¾
 *      $collection      ¥³¥ì¥¯¥·¥ç¥óÌ¾
 *      $caldata         ¥«¥ì¥ó¥À¡¼¾ðÊó(»²¾ÈÅÏ¤·)
 *
 * [ÊÖ¤êÃÍ]
 *      TRUE             ¸¡º÷À®¸ù
 *      FALUSE           ¸¡º÷¼ºÇÔ
 **********************************************************************/
function search_all_calendar($resource, $collection, &$caldata)
{
    global $calendar_conf;
    global $dg_ldapid;
    global $access_type;

    /* ¸¡º÷¥Ù¡¼¥¹DN */
    $basedn = sprintf("%s=%s,%s=%s,%s", CALCOLLECTION,
                      LDAP_dn_escape($collection), CALRESOURCE,
                      LDAP_dn_escape($resource), $calendar_conf["ldapbasedn"]);

    /* ¸¡º÷¥Õ¥£¥ë¥¿ */
    $filter = "(" . OBJECTCLASS . "=" . OBJNAME_CALDATA . ")";
    if ($access_type == IPHONE) {

    }

    /* ¼èÆÀ¤¹¤ëÂ°À­Ì¾ */
    $attrs = array();

    /* ¸¡º÷¥¹¥³¡¼¥× */
    $type = TYPE_ONELEVEL;

    $ret = DgLDAP_get_entry_batch($basedn, $dg_ldapid, $filter,
                                  $attrs, $type, $caldata);
    if ($ret != LDAP_OK && $ret != LDAP_ERR_NODATA) {
        return FALSE;
    }

    return TRUE;
}

/*********************************************************************
 * search_calendar()
 *
 * LDAP¤«¤é¥«¥ì¥ó¥À¡¼¾ðÊó¤ò¸¡º÷¤·¡¢¼èÆÀ¤¹¤ë
 *
 * [°ú¿ô]
 *      $objecturi       ¥«¥ì¥ó¥À¡¼ID
 *      $resource        ¥ê¥½¡¼¥¹Ì¾
 *      $collection      ¥³¥ì¥¯¥·¥ç¥óÌ¾
 *      $caldata         ¥«¥ì¥ó¥À¡¼¾ðÊó(»²¾ÈÅÏ¤·)
 *
 * [ÊÖ¤êÃÍ]
 *      TRUE             ¸¡º÷À®¸ù
 *      FALUSE           ¸¡º÷¼ºÇÔ
 **********************************************************************/
function search_calendar($objecturi, $resource, $collection, &$caldata)
{
    global $calendar_conf;
    global $dg_ldapid;

    /* ¸¡º÷¥Ù¡¼¥¹DN */
    $basedn = sprintf("%s=%s,%s=%s,%s=%s,%s",
                      CALOBJURI, LDAP_dn_escape($objecturi),
                      CALCOLLECTION, LDAP_dn_escape($collection),
                      CALRESOURCE, LDAP_dn_escape($resource),
                      $calendar_conf["ldapbasedn"]);

    /* ¸¡º÷¥Õ¥£¥ë¥¿ */
    $filter = "(" . OBJECTCLASS . "=" . OBJNAME_CALDATA . ")";

    /* ¼èÆÀ¤¹¤ëÂ°À­Ì¾ */
    $attrs = array(CALMODTIME, CALOBJDATA);

    /* ¸¡º÷¥¹¥³¡¼¥× */
    $type = TYPE_ONEENTRY;

    $ret = DgLDAP_get_entry_batch($basedn, $dg_ldapid, $filter,
                                  $attrs, $type, $caldata);
    if ($ret != LDAP_OK && $ret != LDAP_ERR_NODATA) {
        return FALSE;
    }

    return TRUE;
}

/*********************************************************************
 * get_collection()
 *
 * ¥³¥ì¥¯¥·¥ç¥ó¾ðÊó¤ò¼èÆÀ¤¹¤ë
 *
 * [°ú¿ô]
 *      $resource        ¥ê¥½¡¼¥¹Ì¾
 *      $collection      ¥³¥ì¥¯¥·¥ç¥óÌ¾
 *      $attrs           Â°À­Ì¾
 *      $colledata       ¥³¥ì¥¯¥·¥ç¥ó¾ðÊó(»²¾ÈÅÏ¤·¡Ë
 *
 * [ÊÖ¤êÃÍ]
 *       FUNC_TRUE      LDAP¾ðÊó¤ò¸«¤Ä¤±¤¿
 *       FUNC_FALSE     LDAP¾ðÊó¤¬¸«¤Ä¤«¤é¤Ê¤«¤Ã¤¿
 *       FUNC_SYSERR    °Û¾ï¤¬È¯À¸¤·¤¿
 ********************************************************************/
function get_collection($resource, $collection, $attrs, &$colledata)
{
    global $calendar_conf;
    global $dg_ldapid;
    global $dg_log_msg;

    /* ¸¡º÷¥Ù¡¼¥¹DN */
    $basedn = sprintf("%s=%s,%s=%s,%s",
                      CALCOLLECTION, LDAP_dn_escape($collection),
                      CALRESOURCE, LDAP_dn_escape($resource),
                      $calendar_conf["ldapbasedn"]);

    /* ¸¡º÷¥Õ¥£¥ë¥¿ */
    $filter = "(" . OBJECTCLASS . "=" .  OBJNAME_CALCOLLECTION . ")";

    /* ¸¡º÷¥¹¥³¡¼¥× */
    $type = TYPE_ONEENTRY;

    $ret = DgLDAP_get_entry_batch($basedn, $dg_ldapid, $filter, $attrs,
                                  $type, $colledata);
    if ($ret == LDAP_ERR_NODATA) {
        return FUNC_FALSE;
    } elseif ($ret != LDAP_OK) {
        return FUNC_SYSERR;
    }

    return FUNC_TRUE;
}

/*********************************************************************
 * get_collection_principals()
 *
 * ¥³¥ì¥¯¥·¥ç¥ó¾ðÊó¤ò¼èÆÀ¤¹¤ë(iPhoneÍÑ)
 *
 * [°ú¿ô]
 *      $resource        ¥ê¥½¡¼¥¹Ì¾
 *      $filter		 ¸¡º÷¥Õ¥£¥ë¥¿
 *      $attrs		 Â°À­Ì¾
 *      $colledata       ¥³¥ì¥¯¥·¥ç¥ó¾ðÊó(»²¾ÈÅÏ¤·¡Ë
 *
 * [ÊÖ¤êÃÍ]
 *       FUNC_TRUE      LDAP¾ðÊó¤ò¸«¤Ä¤±¤¿
 *       FUNC_FALSE     LDAP¾ðÊó¤¬¸«¤Ä¤«¤é¤Ê¤«¤Ã¤¿
 *       FUNC_SYSERR    °Û¾ï¤¬È¯À¸¤·¤¿
 ********************************************************************/
function get_collection_principals($resource, $filter, $attrs, &$colledata)
{
    global $calendar_conf;
    global $dg_ldapid;
    global $dg_log_msg;

    /* ¸¡º÷¥Ù¡¼¥¹DN */
    $basedn = sprintf("%s=%s,%s",
                      CALRESOURCE, LDAP_dn_escape($resource),
                      $calendar_conf["ldapbasedn"]);

    /* ¸¡º÷¥¹¥³¡¼¥× */
    $type = TYPE_ONELEVEL;

    $ret = DgLDAP_get_entry_batch($basedn, $dg_ldapid, $filter, $attrs,
                                  $type, $colledata);
    if ($ret == LDAP_ERR_NODATA) {
        return FUNC_FALSE;
    } elseif ($ret != LDAP_OK) {
        return FUNC_SYSERR;
    }

    return FUNC_TRUE;
}

/*********************************************************************
 * get_article_data()
 *
 * authorityArticle¤ÎÃÍ¤òÀ®·Á¤¹¤ë
 *
 * [°ú¿ô]
 *      $article              authorityArticle¤ÎÁ´¤Æ¤Î¾ðÊó(ÇÛÎó¡Ë
 *      $sep_article_data     authorityArticle¤ÎIDËè¤Ë¥æ¡¼¥¶¡¢¸¢¸Â¤òÆþ¤ì¤¿ÇÛÎó
 *                            (»²¾ÈÅÏ¤·¡Ë
 *
 * [ÊÖ¤êÃÍ]
 *      TRUE                  Àµ¾ï
 *      FALUSE                °Û¾ï
 **********************************************************************/
function get_article_data($article, &$sep_article_data)
{
    global $dg_log_msg;

    /* authorityArticle¤¬¤¤¤¯¤Ä¤¢¤ë¤«¿ô¤¨¤ë */
    $num = count($article);

    /* authorityArticle¤ò¥³¥í¥ó¶èÀÚ¤ê¤ÇÊ¬¤±¤ë */
    for ($count = 0 ; $num > $count ; $count++) {
        $article_data = explode(":", $article[$count], 2);

        /* $article_data[0]¤ÎÂ¸ºß¡¢¿ôÃÍ¥Á¥§¥Ã¥¯ */
        $match = preg_match("/^[0-9]+$/", $article_data[0]);
        if ($match != 1) {
            $dg_log_msg = "Article ID is invalid. (" . $article[$count] . ")";
            return FALSE;
        }

        /* $article_data[1]¤ÎÂ¸ºß³ÎÇ§ */
        if (isset($article_data[1]) === FALSE || $article_data[1] == "") {
            $dg_log_msg = "Article authority or user name is empty. (" .
                          $article[$count] . ")";
            return FALSE;
        }

        /* ¸¢¸Â¤¬ÆÉ¤ß¼è¤ê¡¢ÆÉ¤ß½ñ¤­¡¢¶Ø»ß°Ê³°¤Î¤È¤­ */
        if (check_auth_flag($article_data[1][0]) === FALSE) {
            $dg_log_msg .= "(" . $article[$count] . ")";
            return FALSE;
        }

        /* authorityArticle¤ÎU¥Á¥§¥Ã¥¯ */
        if ($article_data[1][1] != ARTICLE_SEP) {
            $dg_log_msg = "Article form is invalid. (" . $article[$count] . ")";
            return FALSE;
        }

        /* $article_data[1]¤«¤é¥æ¡¼¥¶Ì¾¤ò¼èÆÀ¤¹¤ë */
        $user = substr($article_data[1], 2);

        /* authorityArticle¤Î¥æ¡¼¥¶Ì¾¥Á¥§¥Ã¥¯ */
        if (check_user_name($user) === FALSE) {
            $dg_log_msg = "Article user form is invalid. (" .
                          $article[$count] . ")";
            return FALSE;
        }

        /* ÇÛÎó¤ÎÂ¸ºß³ÎÇ§ */
        $id = $article_data[0];
        if (isset($sep_article_data[$id]) === TRUE) {
            $dg_log_msg = "Article id is already exists. (" .
                          $article[$count] . ")";
            return FALSE;
        }

        /* ÇÛÎó¤ËÃÍ¤òÆþ¤ì¤ë */
        $sep_article_data[$id]["authority"] = $article_data[1][0];
        $sep_article_data[$id]["user"] = $user;
    }

    return TRUE;
}

/*********************************************************************
 * get_order_data()
 *
 * authorityOrder¤Î¾ðÊó¤òÊ¬²ò¤·¡¢ÇÛÎó¤ËÆþ¤ì¤ë
 *
 * [°ú¿ô]
 *      $order          authorityOrder
 *      $order_list     ½ç½ø¾ðÊó(»²¾ÈÅÏ¤·¡Ë
 *
 * [ÊÖ¤êÃÍ]
 *      TRUE        Àµ¾ï
 *      FALUSE      °Û¾ï
 **********************************************************************/
function get_order_data($order, &$order_list)
{
    global $dg_log_msg;

    /* authorityOrder¤ò¥³¥í¥ó¶èÀÚ¤ê¤ÇÊ¬¤±¤ë */
    $order_list = explode(":", $order);

    foreach ($order_list as $order_num) {

        /* ID¤ÎÂ¸ºß¤È¿ôÃÍ¥Á¥§¥Ã¥¯ */
        $match = preg_match("/^[0-9]+$/", $order_num);
        if ($match != 1) {
            $dg_log_msg = "AuthorityOrder has broken.";
            return FALSE;
        }
    }

    /* ID¤Î½ÅÊ£¥Á¥§¥Ã¥¯ */
    $uniq_id = array_unique($order_list);
    $same_id = array_diff_assoc($order_list, $uniq_id);
    if (empty($same_id) === FALSE) {
        $dg_log_msg = "AuthorityOrder has broken.";
        return FALSE;
    }

    return TRUE;
}

/*********************************************************************
 * check_authority_data()
 *
 * ¥³¥ì¥¯¥·¥ç¥ó¸¢¸Â¾ðÊó¤ò³ÎÇ§¤¹¤ë
 *
 * [°ú¿ô]
 *      $order         ¥æ¡¼¥¶¸¢¸Â¤Î½ç½ø¾ðÊó
 *      $article       ¥æ¡¼¥¶¸¢¸Â¾ðÊó
 *      $user          ¥æ¡¼¥¶
 *      $default       ¥Ç¥Õ¥©¥ë¥È¸¢¸Â
 *      $authority     ¸¢¸Â
 *
 * [ÊÖ¤êÃÍ]
 *      TRUE        Àµ¾ï
 *      FALUSE      °Û¾ï
 **********************************************************************/
function check_authority_data($order, $article, $user, $default, &$authority)
{
    global $dg_log_msg;
    $authority = "";

    /* authorityOrder,authorityArticle¤¬Ìµ¤¤»þ¤Ë¤Ï¥Ç¥Õ¥©¥ë¥ÈÀßÄê¤ò
       Í­¸ú¤È¤¹¤ë */
    if ($order == "" || $article == "") {
	$authority = $default;
	return TRUE;
    }

    /* authorityOrder¤ÎÃÍ¤òÇÛÎó¤ËÆþ¤ì¤ë */
    if (get_order_data($order, $order_list) === FALSE) {
        return FALSE;
    }

    /* authorityArticle¤ÎÃÍ¤òÇÛÎó¤ËÆþ¤ì¤ë */
    if (get_article_data($article, $sep_article_data) === FALSE) {
        return FALSE;
    }

    /* ÇÛÎó$order_list¤ËÃÍ¤¬Æþ¤Ã¤Æ¤¤¤ë¤« */
    if (empty($order_list) === TRUE) {
        $dg_log_msg = "Order is empty.";
        return FALSE;
    }

    foreach ($order_list as $order_id) {
        /* ¥í¥°¥¤¥ó¥æ¡¼¥¶¤¬authorityArticle¤ËÂ¸ºß¤¹¤ë¤« */
        if (isset($sep_article_data[$order_id]) &&
            $sep_article_data[$order_id]["user"] == $user) {
            $authority = $sep_article_data[$order_id]["authority"];
            return TRUE;
        }
    }
    /* Â¸ºß¤·¤Ê¤¤ */
    $authority = $default;

    return TRUE;
}

/*********************************************************************
 * check_auth_flag()
 *
 * ¸¢¸Â¤Î¾ðÊó¤¬ÈÏ°ÏÆâ¤«³ÎÇ§¤¹¤ë
 *
 * [°ú¿ô]
 *      $authority     ¸¢¸Â
 *
 * [ÊÖ¤êÃÍ]
 *      TRUE        Àµ¾ï
 *      FALUSE      °Û¾ï
 **********************************************************************/
function check_auth_flag($authority)
{
    global $dg_log_msg;

    /* ³ÎÇ§ÍÑÇÛÎó */
    $checkarray = array(AUTHREADONLY, AUTHREADWRITE, AUTHRESTRICTION);

    /* ¸¢¸Â³ÎÇ§ */
    $ret = array_search($authority, $checkarray);
    if ($ret === FALSE) {
        $dg_log_msg = "Authority value is inaccurate.(authority=" . $authority . ")";
        return FALSE;
    }

    return TRUE;
}

/**********************************************************
 * add_resource()
 *
 * ¥ê¥½¡¼¥¹À¸À®
 *
 * [°ú¿ô]
 *      $resource      ¥ê¥½¡¼¥¹Ì¾
 *      $user          ¥æ¡¼¥¶Ì¾
 *
 * [ÊÖ¤êÃÍ]
 *      TRUE           À¸À®À®¸ù
 *      FALSE          À¸À®¼ºÇÔ
 **********************************************************/
function add_resource($resource, $user)
{
    global $calendar_conf;
    global $dg_ldapid;
    global $dg_log_msg;

    /* ÄÉ²Ã¤¹¤ë¥ê¥½¡¼¥¹¤ÎDN */
    $dn_r = sprintf("%s=%s,%s",CALRESOURCE, LDAP_dn_escape($resource),
                    $calendar_conf["ldapbasedn"]);

    /* ¥ê¥½¡¼¥¹¤ÎÂ°À­ */
    $data_r[OBJECTCLASS] = OBJNAME_CALRESOURCE;
    $data_r[COLLECTIONCOUNT] = COLLECTIONCOUNT_DEF;
    $data_r[CALADMINU] = $user;
    $data_r[CALRESOURCE] = $resource;
    $data_r[COLLECTIONNUMMAX] = COLLECTIONNUMMAX_DEF;

    /* ¥ê¥½¡¼¥¹ºîÀ® */
    $ret_r = DgLDAP_add_entry_batch($dn_r, $dg_ldapid, $data_r);
    if ($ret_r != LDAP_OK) {
        return FALSE;
    }

    return TRUE;
}

/**********************************************************
 * add_default_collection()
 *
 * ¥³¥ì¥¯¥·¥ç¥óhomeÀ¸À®
 *
 * [°ú¿ô]
 *      $resource      ¥ê¥½¡¼¥¹Ì¾
 *      $user          ¥æ¡¼¥¶Ì¾
 *
 * [ÊÖ¤êÃÍ]
 *      TRUE           À¸À®À®¸ù
 *      FALSE          À¸À®¼ºÇÔ
 **********************************************************/
function add_default_collection($resource, $user)
{
    global $calendar_conf;
    global $dg_ldapid;
    global $dg_log_msg;

    /* ÄÉ²Ã¤¹¤ë¥³¥ì¥¯¥·¥ç¥ó¤ÎDN */
    $dn_c = sprintf("%s=%s,%s=%s,%s", CALCOLLECTION, 
	           LDAP_dn_escape($calendar_conf["autocreatecollectionname"]),
                   CALRESOURCE, LDAP_dn_escape($resource), 
                   $calendar_conf["ldapbasedn"]);

    /* authorityArticle¤òÀ°·Á¤¹¤ë */
    $article = sprintf("%s:%s%s%s", ARTICLE_DEF_ID, AUTHREADWRITE,
                       ARTICLE_SEP, $user);

    /* ¥³¥ì¥¯¥·¥ç¥ó¤ÎÂ°À­ */
    $data_c[OBJECTCLASS] = OBJNAME_CALCOLLECTION;
    $data_c[CALACTIVE] = COLLECTION_ACTIVE;
    $data_c[CALAUTHORITYDEF] = CALAUTHORITYDEF_DEF;
    $data_c[CALAUTHORITYORDER] = AUTHREADONLY;
    $data_c[CALAUTHORITYARTICLE] = $article;
    $data_c[CALCTAG] = CALCTAG_DEF;
    $data_c[CALCOLLECTION] = $calendar_conf["autocreatecollectionname"];
    $data_c[COLLECTIONNUMBER] = COLLECTIONNUMBER_DEF;
    $data_c[COLLECTIONDESCRIPTION] = $resource . "_" .
                                     $calendar_conf["autocreatecollectionname"];

    /* ¥³¥ì¥¯¥·¥ç¥óÄÉ²Ã */
    $ret_c = DgLDAP_add_entry_batch($dn_c, $dg_ldapid, $data_c);
    if ($ret_c != LDAP_OK) {
        return FALSE;
    }

    return TRUE;
}

/**********************************************************
 * del_resource()
 *
 * ¥ê¥½¡¼¥¹ºï½ü
 *
 * [°ú¿ô]
 *      $resource      ¥ê¥½¡¼¥¹Ì¾
 *
 * [ÊÖ¤êÃÍ]
 *      TRUE           ºï½üÀ®¸ù
 *      FALSE          ºï½ü¼ºÇÔ
 **********************************************************/
function del_resource($resource)
{
    global $dg_ldapid;
    global $dg_log_msg;
    global $calendar_conf;

    /* ºï½ü¤¹¤ëDN */
    $deldn = sprintf("%s=%s,%s", CALRESOURCE, LDAP_dn_escape($resource),
                     $calendar_conf["ldapbasedn"]);

    /* ¥ê¥½¡¼¥¹ºï½ü */
    $ret = DgLDAP_del_entry_batch($deldn, $dg_ldapid);
    if ($ret != LDAP_OK) {
        return FALSE;
    }

    return TRUE;
}

/**********************************************************
 * create_resource_collection()
 *
 * ¥ê¥½¡¼¥¹¡¦¥³¥ì¥¯¥·¥ç¥ó¼«Æ°À¸À®
 *
 * [°ú¿ô]
 *      $resource      ¥ê¥½¡¼¥¹Ì¾
 *      $user          ¥æ¡¼¥¶Ì¾
 *
 * [ÊÖ¤êÃÍ]
 *      TRUE           À¸À®À®¸ù
 *      RESO_FALSE     ¥ê¥½¡¼¥¹À¸À®¼ºÇÔ
 *      COLL_FALSE     ¥³¥ì¥¯¥·¥ç¥óÀ¸À®¼ºÇÔ
 *      DEL_FALSE      ¥ê¥½¡¼¥¹ºï½ü¼ºÇÔ
 **********************************************************/
function create_resource_collection($resource, $user)
{
    global $dg_log_msg;

    /* ¥ê¥½¡¼¥¹ÄÉ²Ã */
    if (add_resource($resource, $user) === FALSE) {
        return RESO_FALSE;
    }

    /* ¥³¥ì¥¯¥·¥ç¥óÄÉ²Ã */
    if (add_default_collection($resource, $user) === FALSE) {
        /* ¥³¥ì¥¯¥·¥ç¥óÄÉ²Ã¼ºÇÔ»þ¤Î¥¨¥é¡¼¥í¥°¤òÊÝ»ý */
        $add_collection_log_msg = $dg_log_msg;

        /* ÄÉ²Ã¤·¤¿¥ê¥½¡¼¥¹¤Îºï½ü */
        if (del_resource($resource) === FALSE) {
            /* ¥ê¥½¡¼¥¹ºï½ü¼ºÇÔ»þ¤Î¥¨¥é¡¼¥í¥°¤òÊÝ»ý */
            $del_resource_log_msg = $dg_log_msg;
            /* ¥³¥ì¥¯¥·¥ç¥ó¤È¥ê¥½¡¼¥¹¤Î¥í¥°¤ò¹ç¤ï¤»¤ë */
            $dg_log_msg = $add_collection_log_msg . ", " . $del_resource_log_msg;
            return DEL_FALSE;
        }
        return COLL_FALSE;
    }

    return TRUE;
}

/*********************************************************
 * createReturnCalendarObject()
 *
 * ¥«¥ì¥ó¥À¡¼¥Ç¡¼¥¿±þÅúÍÑ¾ðÊóºîÀ®
 *
 * [°ú¿ô]
 *       $ldapdata    ¥«¥ì¥ó¥À¡¼LDAP¥Ç¡¼¥¿
 *       $rettype     ±þÅú¤¹¤ë¥¿¥¤¥×
 *                      RETTYPE_ONE :°ì¤Ä¤Î¤ß
 *                      RETTYPE_MANY:Ê£¿ô
 * [ÊÖ¤êÃÍ]
 *       $retarray    ±þÅú¤¹¤ëÇÛÎó¾ðÊó
 **********************************************************/
function createReturnCalendarObject($ldapdata, $rettype)
{
    global $dg_user;

    $retarray = array();
    $tmparray = array();
    $schedule_info = "";
    $key = 0;

    /* ¥¢¥È¥ê¥Ó¥å¡¼¥È¤¬Ä¹¤¹¤®¾ì¹ç¡¢¶õ¹Ô¤òÆþ¤Ã¤Æ¡¢°ì¤Ä¤ÎÂ°À­¤Ï¿ô¹Ô¤Ë¤Ê¤ê¤Þ¤¹¡£
       ¼¡¤Î¥Ç¡¼¥¿¹Ô¤ÎÀèÆ¬Ê¸»ú¤ò³ÎÄê¤¹¤ë*/
    $line_header = " ";

    /* ºï½ü¥¢¥È¥ê¥Ó¥å¡¼¥È¤ÎÇÛÎóÀë¸À*/
    $attrs = array("RRULE",
                   /* alarm¤Î¥¢¥È¥ê¥Ó¥å¡¼¥È*/
                   "BEGIN:VALARM",
                   "ACTION",
                   "TRIGGER",
                   "END:VALARM",
                   /* »²²Ã¼Ô¤Î¥¢¥È¥ê¥Ó¥å¡¼¥È¾ðÊó*/
                   "ORGANIZER;",
                   "ATTENDEE;",
                   "X-MOZ-SEND-INVITATIONS",
                   /* ÅºÉÕ¥ê¥ó¥¯*/
                   "ATTACH",
                   "X-MOZ-LASTACK",
                   /* ¥«¥Æ¥´¥ê*/
                   "CATEGORIES",
                   /* ¾ì½ê*/
                   "LOCATION",
                   /* ¾ÜºÙ*/
                   "DESCRIPTION",
                   /* ¥×¥é¥¤¥Ð¥·¡¼*/
                   "TRANSP",
                   /* ·ïÌ¾(¥¿¥¤¥È¥ë)*/
                   "SUMMARY",
                   /* ½¤Àµ¿ô*/
                   "X-MOZ-GENERATION",
                   "SEQUENCE",
                   /* ¤½¤ÎÂ¾*/
                   "X-MOZ-SNOOZE-TIME",
                   /* VTODO¤Î¤ß*/
                   "STATUS",
                   "PERCENT-COMPLATE",
                   "RECURRENCE-ID"
                   );

    $alarm = array("TRIGGER;VALUE=DURATION");

    /* LDAP¥Ç¡¼¥¿Ê¬¤Î¾ðÊó¤òÀ¸À®¤¹¤ë */
    foreach ($ldapdata as $data) {
        /* Í½Äê¾ðÊó¤òÊÝ»ý¤¹¤ë¤³¤È*/
        $schedule_info = $data[CALOBJDATA][0];

        /* ¥×¥é¥¤¥Ð¥·¡¼¤ÇÂ¾¼Ô¤È¤·¤Æ¡¢¥Ç¡¼¥¿¤ò»²¾È¤·¤Ê¤¤ */
        if ((preg_match("/,resource=" . $dg_user . ",/", $data["dn"]) !== 1) &&
            (preg_match("/\r\nCLASS:PRIVATE\r\n/", $data[CALOBJDATA][0])
              === 1)) {
            continue;
        }

        /* Æü»þ¤Î¤ß¸ø³«¤Î¾ì¹ç¤ÏÆü»þ°Ê³°¤Î¥Ç¡¼¥¿¤òºï½ü¤¹¤ë */
        if ((preg_match("/,resource=" . $dg_user . ",/", $data["dn"]) !== 1) &&
            (preg_match("/\r\nCLASS:CONFIDENTIAL\r\n/", $data[CALOBJDATA][0])
              === 1)) {
            replaceConfidentialCalendarObject($attrs, $line_header,
                                              $schedule_info);
        }

        /* ¼«Ê¬°Ê³°¤ÎÄÌÃÎ¤Ïºï½ü¤¹¤ë */
        if ((preg_match("/,resource=" . $dg_user . ",/", $data["dn"]) !== 1)) {
            replaceConfidentialCalendarObject($alarm, $line_header,
                                              $schedule_info);
        }

        /* ¥Ç¡¼¥¿¤òÅºÉÕ¤Ë³ÊÇ¼*/
        $tmparray[$key][CALDAV_ID]               = $key + 1;
        $tmparray[$key][CALDAV_ID_NUM]           = $key + 1;
        $tmparray[$key][CALDAV_CALENDARDATA]     = $schedule_info;
        $tmparray[$key][CALDAV_CALENDARDATA_NUM] = $schedule_info;
        $tmparray[$key][CALDAV_URI]              = $data[CALOBJURI][0];
        $tmparray[$key][CALDAV_URI_NUM]          = $data[CALOBJURI][0];
        $tmparray[$key][CALDAV_CALENDARID]       = CALDAV_CALENDARID_DEF;
        $tmparray[$key][CALDAV_CALENDARID_NUM]   = CALDAV_CALENDARID_DEF;
        $tmparray[$key][CALDAV_LASTMODIFIED]     = $data[CALMODTIME][0];
        $tmparray[$key][CALDAV_LASTMODIFIED_NUM] = $data[CALMODTIME][0];
        $key++;
    }

    if ($rettype == RETTYPE_ONE) {
        /* °ì¤Ä¤À¤±±þÅú¤¹¤ë(Ã±°ì¾ðÊó¼èÆÀ¤Î¾ì¹ç) */
        $retarray = $tmparray[0];
    } else {
        /* Ê£¿ô±þÅú¤¹¤ë */
        $retarray = $tmparray;
    }

    return $retarray;
}

/*********************************************************
 * LDAP_dn_escape()
 *
 * DN¤Î¥¨¥¹¥±¡¼¥×
 *
 * DN¤Ë»ØÄê¤µ¤ì¤ëÊ¸»úÎó(,+\<>;#/\)¤ò¥¨¥¹¥±¡¼¥×¤·¤Þ¤¹¡£
 *
 * [°ú¿ô]
 *      $str   ¥¨¥¹¥±¡¼¥×¤¹¤ëÊ¸»úÎó
 * [ÊÖ¤êÃÍ]
 *      string ¥¨¥¹¥±¡¼¥×¸å¤ÎÊ¸»úÎó
 **********************************************************/
function LDAP_dn_escape($str)
{
    $trans = array("," => "\\,",
                   "+" => "\\+",
                   "\"" => "\\\"",
                   "<" => "\\<",
                   ">" => "\\>",
                   ";" => "\\;",
                   "#" => "\\#",
                   "/" => "\\/",
                   "\\" => "\\\\");

    return strtr($str, $trans);
}
/*********************************************************
 * check_collection_authority
 * 
 * ¥³¥ì¥¯¥·¥ç¥ó¤Î¸¢¸Â¥Á¥§¥Ã¥¯
 *
 * [°ú¿ô]
 *      $calendarid	¥«¥ì¥ó¥À¡¼ID
 *      $collection	¥³¥ì¥¯¥·¥ç¥óÌ¾(»²¾ÈÅÏ¤·)
 *      $authority	¸¢¸Â¡Ê»²¾ÈÅÏ¤·)
 * [ÊÖ¤êÃÍ]
 *      $ret 		check_authority_data¤ÎÊÖ¤êÃÍ
 **********************************************************/
function check_collection_authority($calendarid, &$collection, &$authority)
{
    global $dg_user;
    global $dg_log_msg;
    global $ldap_collection_data;

    foreach($ldap_collection_data as $one_data) {

        /* ¥«¥ì¥ó¥À¡¼ID¤È¥³¥ì¥¯¥·¥ç¥ó¥Ê¥ó¥Ð¡¼¤¬°ìÃ×¤·¤¿¤é */
        if ($calendarid == $one_data[COLLECTIONNUMBER][0]) {

            /* ¸¢¸Â¾ðÊó³ÊÇ¼ */
            $order      = $one_data[CALAUTHORITYORDER][0];
            $article    = $one_data[CALAUTHORITYARTICLE];
            $def        = $one_data[CALAUTHORITYDEF][0];
            $collection = $one_data[CALCOLLECTION][0];
            break;
        }
    }
    /* ¥³¥ì¥¯¥·¥ç¥ó¸¢¸Â³ÎÇ§ */
    $ret = check_authority_data($order, $article, $dg_user, $def, $authority);

    return $ret;
}

/*********************************************************
 * check_auth_basic()
 *
 * Ç§¾ÚÊýË¡¤¬BASICÇ§¾Ú¤Ç¤¢¤ë¤³¤È¤ò³ÎÇ§¤¹¤ë
 *
 * [°ú¿ô]
 *       ¤Ê¤·
 * [ÊÖ¤êÃÍ]
 *       TRUE         Àµ¾ï
 *       FALSE        °Û¾ï(Ç§¾Ú¤òÄÌ¤Ã¤Æ¤¤¤Ê¤¤)
 **********************************************************/
function check_auth_basic()
{
    global $dg_log_msg;

    if (empty($_SERVER['PHP_AUTH_USER'])) {
        /* Ç§¾Ú¤·¤Æ¤¤¤Ê¤¤ */
        $dg_log_msg = "Authentication is not being used.";
        return FALSE;
    }

    return TRUE;
}

/*********************************************************
 * get_username_basic()
 *
 * ¥¯¥é¥¤¥¢¥ó¥È¤«¤éÁ÷¿®¤µ¤ì¤¿¡ÖAuthorization¡×¤ÎÆâÍÆ¤«¤é¥æ¡¼¥¶Ì¾¤ò¼èÆÀ
 *
 * [°ú¿ô]
 *       ¤Ê¤·
 * [ÊÖ¤êÃÍ]
 *       $username    ¥æ¡¼¥¶Ì¾
 *       FALSE        ÉÔÀµ¤Ê·Á¼°
 **********************************************************/
function get_username_basic()
{
    $username = "";

    /* ¥æ¡¼¥¶Ì¾¼èÆÀ */
    if (!isset($_SERVER['PHP_AUTH_USER'])) {
        return FALSE;
    }

    $username = $_SERVER['PHP_AUTH_USER'];

    /* ·Á¼°³ÎÇ§ */
    $ret = check_user_name($username);
    if ($ret === FALSE) {
        return FALSE;
    }

    return $username;
}

 /********************************************************************
 * ldap_bind_user()
 *
 * LDAP¤ËÀÜÂ³
 *
 * [°ú¿ô]
 *      $userid         BASIC USERID
 *      $passwd         BASIC PASSWORD
 *
 * [ÊÖ¤êÃÍ]
 *      TRUE        Àµ¾ï
 *      FALUSE      °Û¾ï
 *********************************************************************/
function ldap_bind_user($userid, $passwd)
{
    global $calendar_conf;
    global $dg_ldapinfo;
    $result = array();
    $attrs = array();

    /* ldapinfo¤ÎÃÍ¤òÆþ¤ì¤ë */
    set_ldapinfo(TRUE);

    /* FilterºîÀ®*/
    $filter = sprintf($calendar_conf["authldapfilter"], DgLDAP_filter_escape($userid));

    /* ¼èÆÀ¤¹¤ëÂ°À­Ì¾ */
    $attrs = array("dn");

    /* ¸¡º÷¥¹¥³¡¼¥× */
    $type = TYPE_SUBTREE;

    /* LDAP¥¨¥ó¥È¥ê¸¡º÷ */
    $ret = DgLDAP_get_entry($calendar_conf["authldapbasedn"], $filter, $attrs, $type, $data);
    if ($ret !== LDAP_OK) {
        return FALSE;
    }

    /* ¼«Ê¬¼«¿È¤Ø¤Î¥Ð¥¤¥ó¥É(Í­¸ú: TRUE Ìµ¸ú: FALSE) */
    $dg_ldapinfo["ldapuserself"] = TRUE;

    /* ¼«Ê¬¼«¿È¤Ø¥Ð¥¤¥ó¥É¤¹¤ë¾ì¹ç¤Î¥Ð¥¤¥ó¥ÉDN */
    $dg_ldapinfo["ldapuserselfdn"] = $data[0]["dn"];

    /* ¼«Ê¬¼«¿È¤Ø¥Ð¥¤¥ó¥É¤¹¤ë¾ì¹ç¤Î¥Ð¥¤¥ó¥É¥Ñ¥¹¥ï¡¼¥É */
    $dg_ldapinfo["ldapuserselfpw"] = $passwd;

    /* LDAP¥Ð¥¤¥ó¥É */
    $ds = DgLDAP_connect_server();
    if ($ds == LDAP_ERR_BIND) {
        return FALSE;
    }
    return TRUE;
}

/*********************************************************
 * replaceConfidentialCalendarObject()
 *
 * ÅÏ¤·¤¿ÇÛÎó¤Ç¡¢Confidential¥Ç¡¼¥¿¤ÎÃæ¤ËÂ¸ºß¤·¤¿¥¢¥È¥ê¥Ó¥å¡¼¥È¤òºï½ü¤¹¤ë¡£
 *
 * [°ú¿ô]
 *       $attrs       ºï½üÂ°À­¤ÎÇÛÎó
 *       $data        ¥×¥é¥¤¥Ù¡¼¥È¥Ç¡¼¥¿
 * [ÊÖ¤êÃÍ]
 *       $TRUE    Àµ¾ï¤Ë½ªÎ»
 *       $FALSE   °Ê¾å¤Ë½ªÎ»
 **********************************************************/
function replaceConfidentialCalendarObject($attrs, $line_header, &$data)
{
    global $dg_log_msg;

    $retdata = "";
    $arrdata = array();
    $del_flag = FALSE;

    /*¥¢¥È¥ê¥Ó¥å¡¼¥ÈÇÛÎó¤Ï¤«¤é¤À¤Ã¤¿¤é¡¢½ªÎ»¤¹¤ë*/
    if ((count($attrs) == 0) || (is_array($attrs) === FALSE)) {
        $dg_log_msg = "Parameter attribute is invalid.(function replaceConfidentialCalendarObject)";
        return FALSE;
    }

    /* Original¥Ç¡¼¥¿¤«¤é¡¢°ì¤Ä°ì¤ÄÂ°À­¤òÊ¬³ä¤¹¤ë¤³¤È*/
    $arrdata = explode("\r\n", $data);
    if ($arrdata === FALSE) {
        $dg_log_msg = "Parameter is invalid.(function replaceConfidentialCalendarObject)";
        return FALSE;
    }

    /* ¥¢¥È¥ê¥Ó¥å¡¼¥È¥º¤±ÜÍ÷¤¹¤ë*/
    foreach ($attrs as $attr) {
        /* ¥Õ¥é¥°¤ò¥ê¥»¥Ã¥È¤¹¤ë*/
        $del_flag = FALSE;

        /* ³Æ¥¢¥È¥ê¥Ó¥å¡¼¥È¤È¤·¤Æ¡¢¥Ç¡¼¥¿¤Îºï½ü¤ò¹Ô¤¦*/
        foreach ($arrdata as $key => $value) {
            /* ¥Þ¥Ã¥Á¤À¤¿¤é¡¢¥Ç¡¼¥¿¤òºï½ü¤¹¤ë¡£²þ¹Ô¤Î¥Ç¡¼¥¿¤Î¥Õ¥é¥°¤òTRUE¤Ë¥»¥Ã¥È¤¹¤ë*/
            if (strncmp($value, $attr, strlen($attr)) === 0) {
                unset($arrdata[$key]);
                $del_flag = TRUE;

            /* ²þ¹Ô¥Õ¥é¥°¤ÏTRUE¤ÈÀèÆ¬¤Î¥­¡¼¥ï¡¼¥É¤¬¸«¤Ä¤«¤Ã¤¿¤é¡¢ºï½ü¤¹¤ë*/
            } elseif (($del_flag === TRUE) && (strncmp($value, $line_header, strlen($line_header)) === 0)) {
                unset($arrdata[$key]);

            /* ¥Õ¥é¥°¤òFALSE¤ËÌá¤¹*/
            } else {
                $del_flag = FALSE;
            }
        }
    }

    /* ÃÖ´¹¤·¤¿¥Ç¡¼¥¿¤òÊÝ»ý¤¹¤ë¤³¤È*/
    $retdata = implode("\r\n", $arrdata);
    $data = $retdata;

    /* Àµ¾ï½ªÎ»¤¹¤ë¡£*/
    return TRUE;
}

?>
