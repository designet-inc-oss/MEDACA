<?php

/***********************************************************
 * �������������ƥ��ѥ饤�֥��
 *
 * $Id: libcalendar.php 8212 2013-09-09 08:33:03Z maruyoshi $
 * $Revision: 8212 $
 * $Date:: 2013-09-09 17:33:03 +0900#$
 **********************************************************/

/* �ޥ������ */
define("ETCDIR", "etc/");
define("BASEDIR", "/usr/medaca/");

/* ����ե�����̾ */
define("CALCONF", "medaca.conf");

/* ����ե������DBType�� */
define("DBTYPE_LDAP", "LDAP");

/* URL��ǧ�� */
define("LIGHTNING", "0");
define("IPHONE",    "1");
define("URL_CALENDARS",  "calendars");
define("URL_PRINCIPALS", "principals");
define("URL_SPLIT_IPHONE_MIN"   , "3");
define("URL_SPLIT_IPHONE_MAX"   , "4");
define("URL_SPLIT_LIGHTNING_MIN", "4");
define("URL_SPLIT_LIGHTNING_MAX", "5");

/* syslog������ */
define("IDENT", "medaca");

/* ���������ѥ��֥�������̾ */
define("OBJNAME_CALRESOURCE",   "calendarResource");
define("OBJNAME_CALCOLLECTION", "calendarCollection");
define("OBJNAME_CALDATA",       "calendarData");

/* ��������������̾ */
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

/* �桼��̾Ĺ */
define("NAME_MIN", 1);
define("NAME_MAX", 20);

/* �꥽����̾Ĺ */
define("RESOURCE_NAME_MIN", 1);
define("RESOURCE_NAME_MAX", 20);

/* ���쥯�����̾Ĺ */
define("COLLECTION_NAME_MIN", 1);
define("COLLECTION_NAME_MAX", 20);

/* �ؿ�������� */
define("FUNC_TRUE",   "1");
define("FUNC_FALSE",  "0");
define("FUNC_SYSERR", "-1");

/* ���������� */
define("RETTYPE_ONE",  "0");
define("RETTYPE_MANY", "1");

/* ���¤ο��� */
define("AUTHREADONLY",    "0");
define("AUTHREADWRITE",   "1");
define("AUTHRESTRICTION", "2");

/* �����ƥ��֥ե饰 */
define("COLLECTION_ACTIVE",   1);
define("COLLECTION_INACTIVE", 0);

/* ��ư�����ե饰 */
define("AUTOCREATE_ON",  "1");
define("AUTOCREATE_OFF", "0");

/* authorityArticle�Υ桼�� */
define("ARTICLE_SEP", "U");
/* authorityArticle�Υǥե����ID */
define("ARTICLE_DEF_ID", "0");

/* collection=home */
define("COLLHOME", "home");

/* authorityDefault�Υǥե������ */
define("CALAUTHORITYDEF_DEF", "0");

/* calendarCtag�Υǥե������ */
define("CALCTAG_DEF", "0");

/* collectionCount�Υǥե������ */
define("COLLECTIONCOUNT_DEF", "1");

/* collectionNumMax�Υǥե������ */
define("COLLECTIONNUMMAX_DEF", "1");

/* collectionNumber�Υǥե������ */
define("COLLECTIONNUMBER_DEF", "1");

/* �꥽�����ɲü��� */
define("RESO_FALSE", "-1");

/* ���쥯������ɲü��� */
define("COLL_FALSE", "-2");

/* CALDAV����� */
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
 * ����ե�������ɤ߹��ߤ�Ԥ�
 *
 * [����]
 *       $calendar_conf ����ե��������(�����Ϥ�)
 * [�֤���]
 *       TRUE         ����
 *       FALSE        ����ե������ɤ߹��߰۾�
 **********************************************************/
function read_calendar_conf(&$calendar_conf)
{
    /* ����ե�������� */
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

    /* ����Υǥե������ */
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

    /* ����ե������ɤ߹��� */
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
 * DBtype�����å�
 *
 * [����]
 *      $dbtype         DBtype
 * [�֤���]
 *      TRUE            ����
 *      FALSE           �۾�
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
 * ���ե�������Ф������顼�����Ϥ�Ԥ�
 *
 * [����]
 *      $resultlog      ���顼��å�����
 * [�֤���]
 *      �ʤ�
 ************************************************************/
function result_log($resultlog)
{
    global $calendar_conf;

    /* �ե����뤬�ɤ߹��ޤ�����ꤵ��Ƥ��� */
    if (isset($calendar_conf['syslogfacility']) ) {
        /* ������̾ */
        $syslog = DgCommon_set_logfacility($calendar_conf['syslogfacility']);

        if (!isset($syslog)) {
            $syslog = LOG_LOCAL1;
        }
    } else {
        /* �ե����뤬�ɤ߹��ޤ�ʤ��ä���� */
        $syslog = LOG_LOCAL1;
    }

    /* �񤭹��ߤ����������Ƥ˥�ɽ��̾��������桼��̾���硣*/
    $user = "";
    if (isset($_SERVER['REMOTE_USER'])) {
        $user = $_SERVER['REMOTE_USER'];
    }
    $msg = $user . " " . $resultlog . "\n";

    /* �������ץ� */
    $ret = openlog(IDENT, LOG_PID, $syslog);
    if ($ret === FALSE) {
        return;
    }

    /* ������ */
    syslog(LOG_ERR, $msg);
    closelog();

    return;
}

/*********************************************************
 * check_user()
 *
 * HTTP�ꥯ�����Ȥ��桼��̾���ǧ����
 *
 * [����]
 *       �ʤ�
 * [�֤���]
 *       TRUE         ����
 *       FALSE        �۾�(ǧ�ڤ��̤äƤ��ʤ�)
 **********************************************************/
function check_user()
{
    global $dg_log_msg;

    /* �桼����������Ȥγ�ǧ */
    if (isset($_SERVER["PHP_AUTH_USER"]) === FALSE &&
        isset($_SERVER["PHP_AUTH_PW"]) === FALSE ) {
        /* ǧ�ڤ��Ƥ��ʤ� */
        $dg_log_msg = "Authentication is not being used.";
        return FALSE;
    }

    /* ������ǧ */
    $ret = check_user_name($_SERVER["PHP_AUTH_USER"]);
    if ($ret === FALSE) {
        return FALSE;
    }

    return TRUE;
}

/*********************************************************
 * check_auth_digest()
 *
 * ǧ����ˡ��DIGESTǧ�ڤǤ��뤳�Ȥ��ǧ����
 *
 * [����]
 *       �ʤ�
 * [�֤���]
 *       TRUE         ����
 *       FALSE        �۾�(ǧ�ڤ��̤äƤ��ʤ�)
 **********************************************************/
function check_auth_digest()
{
    global $dg_log_msg;

    if (empty($_SERVER['PHP_AUTH_DIGEST'])) {
        /* ǧ�ڤ��Ƥ��ʤ� */
        $dg_log_msg = "Authentication is not being used.";
        return FALSE;
    }

    return TRUE;
}

/*********************************************************
 * get_username()
 *
 * ���饤����Ȥ����������줿��Authorization�פ����Ƥ���桼��̾�����
 *
 * [����]
 *       �ʤ�
 * [�֤���]
 *       $username    �桼��̾
 *       FALSE        �����ʷ���
 **********************************************************/
function get_username()
{
    $username = "";

    /* �桼��̾���� */
    $response   = explode(",", str_replace('"', '', $_SERVER['PHP_AUTH_DIGEST']));
    $tmp = null;
    foreach ($response as $v) {
        $tmp = explode("=", trim($v));
        if ($tmp[0] === "username") {
            $username  = $tmp[1];
            break;
        }
    }

    /* ������ǧ */
    $ret = check_user_name($username);
    if ($ret === FALSE) {
        return FALSE;
    }

    return $username;
}

/*********************************************************
 * check_url()
 *
 * HTTP�ꥯ�����Ȥ���URI��ǧ��resource,collection�μ���
 *
 * [����]
 *       $resource    �꥽����̾(�����Ϥ�)
 *       $collection  ���쥯�����̾(�����Ϥ�)
 * [�֤���]
 *       TRUE         ����
 *       FALSE        �۾�(���ꤵ��Ƥ���ѥ����۾�)
 **********************************************************/
function check_url(&$resource, &$collection)
{
    global $dg_log_msg;
    global $access_type;

    /* ����� */
    $calendars  = "";
    $resource   = "";
    $collection = "";
    $min = URL_SPLIT_LIGHTNING_MIN;
    $max = URL_SPLIT_LIGHTNING_MAX;

    /* PATHʬ�� */
    $tmp = explode("/", $_SERVER["PATH_INFO"]);
    if (strcmp($tmp[1], URL_PRINCIPALS) == 0) {
        $min = URL_SPLIT_IPHONE_MIN;
        $max = URL_SPLIT_IPHONE_MAX;
        $access_type = IPHONE;
    }
    $tmpcount = count($tmp);
    if ($tmpcount != $min && $tmpcount != $max) {
        /* ���ꤷ�Ƥ���ѥ����㤦 */
        $dg_log_msg = "Invalid URI.(" . $_SERVER["PATH_INFO"] . ")";
        return FALSE;
    }

    $calendars  = $tmp[1];
    $resource   = $tmp[2];
    $collection = $tmp[3];

    /* �ѥ��γ�ǧ */
    if ($access_type == IPHONE) {
        if ($collection != "") {
            $dg_log_msg = "Invalid URI.(" . $_SERVER["PATH_INFO"] . ")";
            return FALSE;
        }
    } else if (strcmp($calendars, URL_CALENDARS) != 0) {
        /* ���ꤷ�Ƥ���ѥ����㤦 */
        $dg_log_msg = "Invalid URI.(" . $_SERVER["PATH_INFO"] . ")";
        return FALSE;
    }

    return TRUE;
}

/*********************************************************
 * check_user_name()
 *
 * �桼��̾�η�����ǧ
 *
 * [����]
 *       $name        �桼��̾
 * [�֤���]
 *       TRUE         ����
 *       FALSE        �۾�
 **********************************************************/
function check_user_name($name)
{
    global $dg_log_msg;

    /* Ĺ�������å� */
    $len = strlen($name);
    if ($len < NAME_MIN || $len > NAME_MAX) {
        $dg_log_msg = "Invalid user name.($name)";
        return FALSE;
    }

    /* Ⱦ�ѱѾ�ʸ����ʸ��������������[-_.]�Τߵ��� */
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
 * �꥽����̾�η�����ǧ
 *
 * [����]
 *       $name        �꥽����̾
 * [�֤���]
 *       TRUE         ����
 *       FALSE        �۾�
 **********************************************************/
function check_resource_name($name)
{
    global $dg_log_msg;

    /* Ĺ�������å� */
    $len = strlen($name);
    if ($len < RESOURCE_NAME_MIN || $len > RESOURCE_NAME_MAX) {
        $dg_log_msg = "Invalid resource name.(" . $_SERVER["PATH_INFO"] . ")";
        return FALSE;
    }

    /* Ⱦ�ѱѾ�ʸ����ʸ��������������[-_.]�Τߵ��� */
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
 * ���쥯�����̾�η�����ǧ
 *
 * [����]
 *       $name        ���쥯�����̾
 * [�֤���]
 *       TRUE         ����
 *       FALSE        �۾�
 **********************************************************/
function check_collection_name($name)
{
    global $dg_log_msg;

    /* Ĺ�������å� */
    $len = strlen($name);
    if ($len < COLLECTION_NAME_MIN || $len > COLLECTION_NAME_MAX) {
        $dg_log_msg = "Invalid collection name.(" . $_SERVER["PATH_INFO"] . ")";
        return FALSE;
    }

    /* Ⱦ�ѱѾ�ʸ����ʸ��������������[-_.]�Τߵ��� */
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
 * ���ꤷ���꥽������LDAP������������
 *
 * [����]
 *       $dg_ldapid    ���ID
 *       $resource     �꥽����̾
 *       $ldapdata     ��������LDAP�ǡ���(�����Ϥ�)
 * [�֤���]
 *       FUNC_TRUE      LDAP����򸫤Ĥ���
 *       FUNC_FALSE     LDAP���󤬸��Ĥ���ʤ��ä�
 *       FUNC_SYSERR    �۾郎ȯ������
 **********************************************************/
function get_resource($dg_ldapid, $resource, &$ldapdata)
{
    global $dg_log_msg;
    global $calendar_conf;

    /* filter���� */
    $filter = sprintf("%s=%s",
                      CALRESOURCE, DgLDAP_filter_escape($resource));
    $attrs = array();
    $scope = TYPE_ONEENTRY;
    $dn = sprintf("%s=%s,%s",
                   CALRESOURCE, LDAP_dn_escape($resource),
                   $calendar_conf["ldapbasedn"]);

    /* LDAP�ξ������� */
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
 * ���������ǡ������ɲä���
 *
 * [����]
 *       $resource          �꥽����̾
 *       $collection�����������쥯�����̾
 *       $objecturi�������� ��������ID
 *       $caldata           ������������
 *
 * [�֤���]
 *       TRUE               �ɲ�����
 *       FALSE              �ɲü���
 **********************************************************/
function ldap_calendar_add($resource, $collection, $objecturi, $caldata)
{
    global $calendar_conf;
    global $dg_log_msg;
    global $dg_ldapid;

    /* dn ���� */
    $dn = sprintf("%s=%s,%s=%s,%s=%s,%s",
                  CALOBJURI, LDAP_dn_escape($objecturi),
                  CALCOLLECTION, LDAP_dn_escape($collection),
                  CALRESOURCE, LDAP_dn_escape($resource),
                  $calendar_conf["ldapbasedn"]);

    /* LDAP �ɲ� */
    $ret = DgLDAP_add_entry_batch($dn, $dg_ldapid, $caldata);
    if ($ret != LDAP_OK) {
        return FALSE;
    }

    return TRUE;
}

/*********************************************************
 * ldap_calendar_mod()
 *
 * ���������ǡ������ѹ�����
 *
 * [����]
 *       $resource          �꥽����̾
 *       $collection�����������쥯�����̾
 *       $objecturi�������� ��������ID
 *       $caldata           ������������
 *
 * [�֤���]
 *       TRUE               �ѹ�����
 *       FALSE              �ѹ�����
 **********************************************************/
function ldap_calendar_mod($resource, $collection, $objecturi, $caldata)
{
    global $calendar_conf;
    global $dg_ldapid;

    /* dn ���� */
    $dn = sprintf("%s=%s,%s=%s,%s=%s,%s",
                  CALOBJURI, LDAP_dn_escape($objecturi),
                  CALCOLLECTION, LDAP_dn_escape($collection),
                  CALRESOURCE, LDAP_dn_escape($resource),
                  $calendar_conf["ldapbasedn"]);

    /* LDAP �ѹ� */
    $ret = DgLDAP_mod_entry_batch($dn, $dg_ldapid, $caldata);
    if ($ret != LDAP_OK) {
        return FALSE;
    }

    return TRUE;
}

/*********************************************************
 * ldap_calendar_del()
 *
 * ���������ǡ������ѹ�����
 *
 * [����]
 *       $resource          �꥽����̾
 *       $collection�����������쥯�����̾
 *       $objecturi�������� ��������ID
 *
 * [�֤���]
 *       TRUE               �������
 *       FALSE              �������
 **********************************************************/
function ldap_calendar_del($resource, $collection, $objecturi)
{
    global $calendar_conf;
    global $dg_ldapid;

    /* dn ���� */
    $dn = sprintf("%s=%s,%s=%s,%s=%s,%s",
                  CALOBJURI, LDAP_dn_escape($objecturi),
                  CALCOLLECTION, LDAP_dn_escape($collection),
                  CALRESOURCE, LDAP_dn_escape($resource),
                  $calendar_conf["ldapbasedn"]);

    /* LDAP ��� */
    $ret = DgLDAP_del_entry_batch($dn, $dg_ldapid);
    if ($ret != LDAP_OK) {
        return FALSE;
    }

    return TRUE;
}

/*********************************************************
 * ldap_collection_ctag_update()
 *
 * collection�ˤ���CTAG�򹹿�����
 *
 * [����]
 *       $resource          �꥽����̾
 *       $collection�����������쥯�����̾
 *       $ctag              ��������CTag����
 *
 * [�֤���]
 *      TRUE     ����
 *      FALSE    �۾�
 **********************************************************/
function ldap_collection_ctag_update($resource, $collection, $ctag)
{
    global $calendar_conf;
    global $dg_ldapid;

    /* collection�ξ���򹹿� */
    /* dn ���� */
    $dn = sprintf("%s=%s,%s=%s,%s",
                  CALCOLLECTION, LDAP_dn_escape($collection),
                  CALRESOURCE, LDAP_dn_escape($resource),
                  $calendar_conf["ldapbasedn"]);

    /* ��������CTag */
    $data[CALCTAG] = $ctag;

    /* LDAP ���� */
    $ret = DgLDAP_mod_entry_batch($dn, $dg_ldapid, $data);
    if ($ret != LDAP_OK) {
        return FALSE;
    }

    return TRUE;
}

/*********************************************************************
 * set_ldapinfo
 *
 * ldapinfo����
 *
 * [����]
 *      $authldap       Ldap Auth check
 *
 * [�֤���]
 *      TRUE             ����
 **********************************************************************/
function set_ldapinfo($authldap = FALSE)
{
    global $calendar_conf;
    global $dg_ldapinfo;

    /* ��ʬ���ȤؤΥХ����(ͭ��: TRUE ̵��: FALSE) */
    $dg_ldapinfo["ldapuserself"] = FALSE;

    /* ��ʬ���ȤإХ���ɤ�����ΥХ����DN */
    $dg_ldapinfo["ldapuserselfdn"] = "";

    /* ��ʬ���ȤإХ���ɤ�����ΥХ���ɥѥ���� */
    $dg_ldapinfo["ldapuserselfpw"] = "";

    /* read-only�����ФؤΥХ����(ͭ��: TRUE ̵��: FALSE) */
    $dg_ldapinfo["ldapro"] = FALSE;

    /* read-only�����Ф�IP���ɥ쥹 */
    $dg_ldapinfo["ldapserverro"] = "";

    /* read-only�����ФΥݡ����ֹ� */
    $dg_ldapinfo["ldapportro"] = "";

    /* �������Ϥ��줿���*/
    if ($authldap) {
        /* LDAP�����Ф�IP���ɥ쥹 */
        $dg_ldapinfo["ldapserver"] = $calendar_conf["authldapserver"];

        /* LDAP�����ФΥݡ����ֹ� */
        $dg_ldapinfo["ldapport"] = $calendar_conf["authldapport"];

        /* LDAP�����ФΥХ����DN */
        $dg_ldapinfo["ldapbinddn"] = $calendar_conf["authldapbinddn"];

        /* LDAP�����ФΥХ���ɥѥ���� */
        $dg_ldapinfo["ldapbindpw"] = $calendar_conf["authldapbindpw"];

    /* �������Ϥ��ʤ����*/
    } else {
        /* LDAP�����Ф�IP���ɥ쥹 */
        $dg_ldapinfo["ldapserver"] = $calendar_conf["ldapserver"];

        /* LDAP�����ФΥݡ����ֹ� */
        $dg_ldapinfo["ldapport"] = $calendar_conf["ldapport"];

        /* LDAP�����ФΥХ����DN */
        $dg_ldapinfo["ldapbinddn"] = $calendar_conf["ldapbinddn"];

        /* LDAP�����ФΥХ���ɥѥ���� */
        $dg_ldapinfo["ldapbindpw"] = $calendar_conf["ldapbindpw"];
    }

    return TRUE;
}

 /********************************************************************
 * ldap_connect_server()
 *
 * LDAP����³
 *
 * [����]
 *      $ds         ���ID(�����Ϥ�)
 *
 * [�֤���]
 *      TRUE        ����
 *      FALUSE      �۾�
 *********************************************************************/
function ldap_connect_server(&$ds)
{
    global $calendar_conf;

    /* ldapinfo���ͤ������ */
    set_ldapinfo();

    /* LDAP��³ */
    $ds = DgLDAP_connect_server();
    if ($ds == LDAP_ERR_BIND) {
        return FALSE;
    }

    return TRUE;
}

/*********************************************************************
 * search_all_calendar()
 *
 * LDAP���饳�쥯������۲��ˤ������ƤΥ�����������򸡺�������������
 *
 * [����]
 *      $resource        �꥽����̾
 *      $collection      ���쥯�����̾
 *      $caldata         ������������(�����Ϥ�)
 *
 * [�֤���]
 *      TRUE             ��������
 *      FALUSE           ��������
 **********************************************************************/
function search_all_calendar($resource, $collection, &$caldata)
{
    global $calendar_conf;
    global $dg_ldapid;
    global $access_type;

    /* �����١���DN */
    $basedn = sprintf("%s=%s,%s=%s,%s", CALCOLLECTION,
                      LDAP_dn_escape($collection), CALRESOURCE,
                      LDAP_dn_escape($resource), $calendar_conf["ldapbasedn"]);

    /* �����ե��륿 */
    $filter = "(" . OBJECTCLASS . "=" . OBJNAME_CALDATA . ")";
    if ($access_type == IPHONE) {

    }

    /* ��������°��̾ */
    $attrs = array();

    /* ������������ */
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
 * LDAP���饫����������򸡺�������������
 *
 * [����]
 *      $objecturi       ��������ID
 *      $resource        �꥽����̾
 *      $collection      ���쥯�����̾
 *      $caldata         ������������(�����Ϥ�)
 *
 * [�֤���]
 *      TRUE             ��������
 *      FALUSE           ��������
 **********************************************************************/
function search_calendar($objecturi, $resource, $collection, &$caldata)
{
    global $calendar_conf;
    global $dg_ldapid;

    /* �����١���DN */
    $basedn = sprintf("%s=%s,%s=%s,%s=%s,%s",
                      CALOBJURI, LDAP_dn_escape($objecturi),
                      CALCOLLECTION, LDAP_dn_escape($collection),
                      CALRESOURCE, LDAP_dn_escape($resource),
                      $calendar_conf["ldapbasedn"]);

    /* �����ե��륿 */
    $filter = "(" . OBJECTCLASS . "=" . OBJNAME_CALDATA . ")";

    /* ��������°��̾ */
    $attrs = array(CALMODTIME, CALOBJDATA);

    /* ������������ */
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
 * ���쥯����������������
 *
 * [����]
 *      $resource        �꥽����̾
 *      $collection      ���쥯�����̾
 *      $attrs           °��̾
 *      $colledata       ���쥯��������(�����Ϥ���
 *
 * [�֤���]
 *       FUNC_TRUE      LDAP����򸫤Ĥ���
 *       FUNC_FALSE     LDAP���󤬸��Ĥ���ʤ��ä�
 *       FUNC_SYSERR    �۾郎ȯ������
 ********************************************************************/
function get_collection($resource, $collection, $attrs, &$colledata)
{
    global $calendar_conf;
    global $dg_ldapid;
    global $dg_log_msg;

    /* �����١���DN */
    $basedn = sprintf("%s=%s,%s=%s,%s",
                      CALCOLLECTION, LDAP_dn_escape($collection),
                      CALRESOURCE, LDAP_dn_escape($resource),
                      $calendar_conf["ldapbasedn"]);

    /* �����ե��륿 */
    $filter = "(" . OBJECTCLASS . "=" .  OBJNAME_CALCOLLECTION . ")";

    /* ������������ */
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
 * ���쥯����������������(iPhone��)
 *
 * [����]
 *      $resource        �꥽����̾
 *      $filter		 �����ե��륿
 *      $attrs		 °��̾
 *      $colledata       ���쥯��������(�����Ϥ���
 *
 * [�֤���]
 *       FUNC_TRUE      LDAP����򸫤Ĥ���
 *       FUNC_FALSE     LDAP���󤬸��Ĥ���ʤ��ä�
 *       FUNC_SYSERR    �۾郎ȯ������
 ********************************************************************/
function get_collection_principals($resource, $filter, $attrs, &$colledata)
{
    global $calendar_conf;
    global $dg_ldapid;
    global $dg_log_msg;

    /* �����١���DN */
    $basedn = sprintf("%s=%s,%s",
                      CALRESOURCE, LDAP_dn_escape($resource),
                      $calendar_conf["ldapbasedn"]);

    /* ������������ */
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
 * authorityArticle���ͤ���������
 *
 * [����]
 *      $article              authorityArticle�����Ƥξ���(�����
 *      $sep_article_data     authorityArticle��ID��˥桼�������¤����줿����
 *                            (�����Ϥ���
 *
 * [�֤���]
 *      TRUE                  ����
 *      FALUSE                �۾�
 **********************************************************************/
function get_article_data($article, &$sep_article_data)
{
    global $dg_log_msg;

    /* authorityArticle�������Ĥ��뤫������ */
    $num = count($article);

    /* authorityArticle�򥳥����ڤ��ʬ���� */
    for ($count = 0 ; $num > $count ; $count++) {
        $article_data = explode(":", $article[$count], 2);

        /* $article_data[0]��¸�ߡ����ͥ����å� */
        $match = preg_match("/^[0-9]+$/", $article_data[0]);
        if ($match != 1) {
            $dg_log_msg = "Article ID is invalid. (" . $article[$count] . ")";
            return FALSE;
        }

        /* $article_data[1]��¸�߳�ǧ */
        if (isset($article_data[1]) === FALSE || $article_data[1] == "") {
            $dg_log_msg = "Article authority or user name is empty. (" .
                          $article[$count] . ")";
            return FALSE;
        }

        /* ���¤��ɤ߼�ꡢ�ɤ߽񤭡��ػ߰ʳ��ΤȤ� */
        if (check_auth_flag($article_data[1][0]) === FALSE) {
            $dg_log_msg .= "(" . $article[$count] . ")";
            return FALSE;
        }

        /* authorityArticle��U�����å� */
        if ($article_data[1][1] != ARTICLE_SEP) {
            $dg_log_msg = "Article form is invalid. (" . $article[$count] . ")";
            return FALSE;
        }

        /* $article_data[1]����桼��̾��������� */
        $user = substr($article_data[1], 2);

        /* authorityArticle�Υ桼��̾�����å� */
        if (check_user_name($user) === FALSE) {
            $dg_log_msg = "Article user form is invalid. (" .
                          $article[$count] . ")";
            return FALSE;
        }

        /* �����¸�߳�ǧ */
        $id = $article_data[0];
        if (isset($sep_article_data[$id]) === TRUE) {
            $dg_log_msg = "Article id is already exists. (" .
                          $article[$count] . ")";
            return FALSE;
        }

        /* ������ͤ������ */
        $sep_article_data[$id]["authority"] = $article_data[1][0];
        $sep_article_data[$id]["user"] = $user;
    }

    return TRUE;
}

/*********************************************************************
 * get_order_data()
 *
 * authorityOrder�ξ����ʬ�򤷡�����������
 *
 * [����]
 *      $order          authorityOrder
 *      $order_list     �������(�����Ϥ���
 *
 * [�֤���]
 *      TRUE        ����
 *      FALUSE      �۾�
 **********************************************************************/
function get_order_data($order, &$order_list)
{
    global $dg_log_msg;

    /* authorityOrder�򥳥����ڤ��ʬ���� */
    $order_list = explode(":", $order);

    foreach ($order_list as $order_num) {

        /* ID��¸�ߤȿ��ͥ����å� */
        $match = preg_match("/^[0-9]+$/", $order_num);
        if ($match != 1) {
            $dg_log_msg = "AuthorityOrder has broken.";
            return FALSE;
        }
    }

    /* ID�ν�ʣ�����å� */
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
 * ���쥯����󸢸¾�����ǧ����
 *
 * [����]
 *      $order         �桼�����¤ν������
 *      $article       �桼�����¾���
 *      $user          �桼��
 *      $default       �ǥե���ȸ���
 *      $authority     ����
 *
 * [�֤���]
 *      TRUE        ����
 *      FALUSE      �۾�
 **********************************************************************/
function check_authority_data($order, $article, $user, $default, &$authority)
{
    global $dg_log_msg;
    $authority = "";

    /* authorityOrder,authorityArticle��̵�����ˤϥǥե���������
       ͭ���Ȥ��� */
    if ($order == "" || $article == "") {
	$authority = $default;
	return TRUE;
    }

    /* authorityOrder���ͤ����������� */
    if (get_order_data($order, $order_list) === FALSE) {
        return FALSE;
    }

    /* authorityArticle���ͤ����������� */
    if (get_article_data($article, $sep_article_data) === FALSE) {
        return FALSE;
    }

    /* ����$order_list���ͤ����äƤ��뤫 */
    if (empty($order_list) === TRUE) {
        $dg_log_msg = "Order is empty.";
        return FALSE;
    }

    foreach ($order_list as $order_id) {
        /* ������桼����authorityArticle��¸�ߤ��뤫 */
        if (isset($sep_article_data[$order_id]) &&
            $sep_article_data[$order_id]["user"] == $user) {
            $authority = $sep_article_data[$order_id]["authority"];
            return TRUE;
        }
    }
    /* ¸�ߤ��ʤ� */
    $authority = $default;

    return TRUE;
}

/*********************************************************************
 * check_auth_flag()
 *
 * ���¤ξ����ϰ��⤫��ǧ����
 *
 * [����]
 *      $authority     ����
 *
 * [�֤���]
 *      TRUE        ����
 *      FALUSE      �۾�
 **********************************************************************/
function check_auth_flag($authority)
{
    global $dg_log_msg;

    /* ��ǧ������ */
    $checkarray = array(AUTHREADONLY, AUTHREADWRITE, AUTHRESTRICTION);

    /* ���³�ǧ */
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
 * �꥽��������
 *
 * [����]
 *      $resource      �꥽����̾
 *      $user          �桼��̾
 *
 * [�֤���]
 *      TRUE           ��������
 *      FALSE          ��������
 **********************************************************/
function add_resource($resource, $user)
{
    global $calendar_conf;
    global $dg_ldapid;
    global $dg_log_msg;

    /* �ɲä���꥽������DN */
    $dn_r = sprintf("%s=%s,%s",CALRESOURCE, LDAP_dn_escape($resource),
                    $calendar_conf["ldapbasedn"]);

    /* �꥽������°�� */
    $data_r[OBJECTCLASS] = OBJNAME_CALRESOURCE;
    $data_r[COLLECTIONCOUNT] = COLLECTIONCOUNT_DEF;
    $data_r[CALADMINU] = $user;
    $data_r[CALRESOURCE] = $resource;
    $data_r[COLLECTIONNUMMAX] = COLLECTIONNUMMAX_DEF;

    /* �꥽�������� */
    $ret_r = DgLDAP_add_entry_batch($dn_r, $dg_ldapid, $data_r);
    if ($ret_r != LDAP_OK) {
        return FALSE;
    }

    return TRUE;
}

/**********************************************************
 * add_default_collection()
 *
 * ���쥯�����home����
 *
 * [����]
 *      $resource      �꥽����̾
 *      $user          �桼��̾
 *
 * [�֤���]
 *      TRUE           ��������
 *      FALSE          ��������
 **********************************************************/
function add_default_collection($resource, $user)
{
    global $calendar_conf;
    global $dg_ldapid;
    global $dg_log_msg;

    /* �ɲä��륳�쥯������DN */
    $dn_c = sprintf("%s=%s,%s=%s,%s", CALCOLLECTION, 
	           LDAP_dn_escape($calendar_conf["autocreatecollectionname"]),
                   CALRESOURCE, LDAP_dn_escape($resource), 
                   $calendar_conf["ldapbasedn"]);

    /* authorityArticle���������� */
    $article = sprintf("%s:%s%s%s", ARTICLE_DEF_ID, AUTHREADWRITE,
                       ARTICLE_SEP, $user);

    /* ���쥯������°�� */
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

    /* ���쥯������ɲ� */
    $ret_c = DgLDAP_add_entry_batch($dn_c, $dg_ldapid, $data_c);
    if ($ret_c != LDAP_OK) {
        return FALSE;
    }

    return TRUE;
}

/**********************************************************
 * del_resource()
 *
 * �꥽�������
 *
 * [����]
 *      $resource      �꥽����̾
 *
 * [�֤���]
 *      TRUE           �������
 *      FALSE          �������
 **********************************************************/
function del_resource($resource)
{
    global $dg_ldapid;
    global $dg_log_msg;
    global $calendar_conf;

    /* �������DN */
    $deldn = sprintf("%s=%s,%s", CALRESOURCE, LDAP_dn_escape($resource),
                     $calendar_conf["ldapbasedn"]);

    /* �꥽������� */
    $ret = DgLDAP_del_entry_batch($deldn, $dg_ldapid);
    if ($ret != LDAP_OK) {
        return FALSE;
    }

    return TRUE;
}

/**********************************************************
 * create_resource_collection()
 *
 * �꥽���������쥯�����ư����
 *
 * [����]
 *      $resource      �꥽����̾
 *      $user          �桼��̾
 *
 * [�֤���]
 *      TRUE           ��������
 *      RESO_FALSE     �꥽������������
 *      COLL_FALSE     ���쥯�������������
 *      DEL_FALSE      �꥽�����������
 **********************************************************/
function create_resource_collection($resource, $user)
{
    global $dg_log_msg;

    /* �꥽�����ɲ� */
    if (add_resource($resource, $user) === FALSE) {
        return RESO_FALSE;
    }

    /* ���쥯������ɲ� */
    if (add_default_collection($resource, $user) === FALSE) {
        /* ���쥯������ɲü��Ի��Υ��顼�����ݻ� */
        $add_collection_log_msg = $dg_log_msg;

        /* �ɲä����꥽�����κ�� */
        if (del_resource($resource) === FALSE) {
            /* �꥽����������Ի��Υ��顼�����ݻ� */
            $del_resource_log_msg = $dg_log_msg;
            /* ���쥯�����ȥ꥽�����Υ����碌�� */
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
 * ���������ǡ��������Ѿ������
 *
 * [����]
 *       $ldapdata    ��������LDAP�ǡ���
 *       $rettype     �������륿����
 *                      RETTYPE_ONE :��ĤΤ�
 *                      RETTYPE_MANY:ʣ��
 * [�֤���]
 *       $retarray    ���������������
 **********************************************************/
function createReturnCalendarObject($ldapdata, $rettype)
{
    global $dg_user;

    $retarray = array();
    $tmparray = array();
    $schedule_info = "";
    $key = 0;

    /* ���ȥ�ӥ塼�Ȥ�Ĺ������硢���Ԥ����äơ���Ĥ�°���Ͽ��Ԥˤʤ�ޤ���
       ���Υǡ����Ԥ���Ƭʸ������ꤹ��*/
    $line_header = " ";

    /* ������ȥ�ӥ塼�Ȥ��������*/
    $attrs = array("RRULE",
                   /* alarm�Υ��ȥ�ӥ塼��*/
                   "BEGIN:VALARM",
                   "ACTION",
                   "TRIGGER",
                   "END:VALARM",
                   /* ���üԤΥ��ȥ�ӥ塼�Ⱦ���*/
                   "ORGANIZER;",
                   "ATTENDEE;",
                   "X-MOZ-SEND-INVITATIONS",
                   /* ź�ե��*/
                   "ATTACH",
                   "X-MOZ-LASTACK",
                   /* ���ƥ���*/
                   "CATEGORIES",
                   /* ���*/
                   "LOCATION",
                   /* �ܺ�*/
                   "DESCRIPTION",
                   /* �ץ饤�Х���*/
                   "TRANSP",
                   /* ��̾(�����ȥ�)*/
                   "SUMMARY",
                   /* ������*/
                   "X-MOZ-GENERATION",
                   "SEQUENCE",
                   /* ����¾*/
                   "X-MOZ-SNOOZE-TIME",
                   /* VTODO�Τ�*/
                   "STATUS",
                   "PERCENT-COMPLATE",
                   "RECURRENCE-ID"
                   );

    $alarm = array("TRIGGER;VALUE=DURATION");

    /* LDAP�ǡ���ʬ�ξ������������ */
    foreach ($ldapdata as $data) {
        /* ͽ�������ݻ����뤳��*/
        $schedule_info = $data[CALOBJDATA][0];

        /* �ץ饤�Х�����¾�ԤȤ��ơ��ǡ����򻲾Ȥ��ʤ� */
        if ((preg_match("/,resource=" . $dg_user . ",/", $data["dn"]) !== 1) &&
            (preg_match("/\r\nCLASS:PRIVATE\r\n/", $data[CALOBJDATA][0])
              === 1)) {
            continue;
        }

        /* �����Τ߸����ξ��������ʳ��Υǡ����������� */
        if ((preg_match("/,resource=" . $dg_user . ",/", $data["dn"]) !== 1) &&
            (preg_match("/\r\nCLASS:CONFIDENTIAL\r\n/", $data[CALOBJDATA][0])
              === 1)) {
            replaceConfidentialCalendarObject($attrs, $line_header,
                                              $schedule_info);
        }

        /* ��ʬ�ʳ������ΤϺ������ */
        if ((preg_match("/,resource=" . $dg_user . ",/", $data["dn"]) !== 1)) {
            replaceConfidentialCalendarObject($alarm, $line_header,
                                              $schedule_info);
        }

        /* �ǡ�����ź�դ˳�Ǽ*/
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
        /* ��Ĥ�����������(ñ���������ξ��) */
        $retarray = $tmparray[0];
    } else {
        /* ʣ���������� */
        $retarray = $tmparray;
    }

    return $retarray;
}

/*********************************************************
 * LDAP_dn_escape()
 *
 * DN�Υ���������
 *
 * DN�˻��ꤵ���ʸ����(,+\<>;#/\)�򥨥������פ��ޤ���
 *
 * [����]
 *      $str   ���������פ���ʸ����
 * [�֤���]
 *      string ���������׸��ʸ����
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
 * ���쥯�����θ��¥����å�
 *
 * [����]
 *      $calendarid	��������ID
 *      $collection	���쥯�����̾(�����Ϥ�)
 *      $authority	���¡ʻ����Ϥ�)
 * [�֤���]
 *      $ret 		check_authority_data���֤���
 **********************************************************/
function check_collection_authority($calendarid, &$collection, &$authority)
{
    global $dg_user;
    global $dg_log_msg;
    global $ldap_collection_data;

    foreach($ldap_collection_data as $one_data) {

        /* ��������ID�ȥ��쥯�����ʥ�С������פ����� */
        if ($calendarid == $one_data[COLLECTIONNUMBER][0]) {

            /* ���¾����Ǽ */
            $order      = $one_data[CALAUTHORITYORDER][0];
            $article    = $one_data[CALAUTHORITYARTICLE];
            $def        = $one_data[CALAUTHORITYDEF][0];
            $collection = $one_data[CALCOLLECTION][0];
            break;
        }
    }
    /* ���쥯����󸢸³�ǧ */
    $ret = check_authority_data($order, $article, $dg_user, $def, $authority);

    return $ret;
}

/*********************************************************
 * check_auth_basic()
 *
 * ǧ����ˡ��BASICǧ�ڤǤ��뤳�Ȥ��ǧ����
 *
 * [����]
 *       �ʤ�
 * [�֤���]
 *       TRUE         ����
 *       FALSE        �۾�(ǧ�ڤ��̤äƤ��ʤ�)
 **********************************************************/
function check_auth_basic()
{
    global $dg_log_msg;

    if (empty($_SERVER['PHP_AUTH_USER'])) {
        /* ǧ�ڤ��Ƥ��ʤ� */
        $dg_log_msg = "Authentication is not being used.";
        return FALSE;
    }

    return TRUE;
}

/*********************************************************
 * get_username_basic()
 *
 * ���饤����Ȥ����������줿��Authorization�פ����Ƥ���桼��̾�����
 *
 * [����]
 *       �ʤ�
 * [�֤���]
 *       $username    �桼��̾
 *       FALSE        �����ʷ���
 **********************************************************/
function get_username_basic()
{
    $username = "";

    /* �桼��̾���� */
    if (!isset($_SERVER['PHP_AUTH_USER'])) {
        return FALSE;
    }

    $username = $_SERVER['PHP_AUTH_USER'];

    /* ������ǧ */
    $ret = check_user_name($username);
    if ($ret === FALSE) {
        return FALSE;
    }

    return $username;
}

 /********************************************************************
 * ldap_bind_user()
 *
 * LDAP����³
 *
 * [����]
 *      $userid         BASIC USERID
 *      $passwd         BASIC PASSWORD
 *
 * [�֤���]
 *      TRUE        ����
 *      FALUSE      �۾�
 *********************************************************************/
function ldap_bind_user($userid, $passwd)
{
    global $calendar_conf;
    global $dg_ldapinfo;
    $result = array();
    $attrs = array();

    /* ldapinfo���ͤ������ */
    set_ldapinfo(TRUE);

    /* Filter����*/
    $filter = sprintf($calendar_conf["authldapfilter"], DgLDAP_filter_escape($userid));

    /* ��������°��̾ */
    $attrs = array("dn");

    /* ������������ */
    $type = TYPE_SUBTREE;

    /* LDAP����ȥ긡�� */
    $ret = DgLDAP_get_entry($calendar_conf["authldapbasedn"], $filter, $attrs, $type, $data);
    if ($ret !== LDAP_OK) {
        return FALSE;
    }

    /* ��ʬ���ȤؤΥХ����(ͭ��: TRUE ̵��: FALSE) */
    $dg_ldapinfo["ldapuserself"] = TRUE;

    /* ��ʬ���ȤإХ���ɤ�����ΥХ����DN */
    $dg_ldapinfo["ldapuserselfdn"] = $data[0]["dn"];

    /* ��ʬ���ȤإХ���ɤ�����ΥХ���ɥѥ���� */
    $dg_ldapinfo["ldapuserselfpw"] = $passwd;

    /* LDAP�Х���� */
    $ds = DgLDAP_connect_server();
    if ($ds == LDAP_ERR_BIND) {
        return FALSE;
    }
    return TRUE;
}

/*********************************************************
 * replaceConfidentialCalendarObject()
 *
 * �Ϥ�������ǡ�Confidential�ǡ��������¸�ߤ������ȥ�ӥ塼�Ȥ������롣
 *
 * [����]
 *       $attrs       ���°��������
 *       $data        �ץ饤�١��ȥǡ���
 * [�֤���]
 *       $TRUE    ����˽�λ
 *       $FALSE   �ʾ�˽�λ
 **********************************************************/
function replaceConfidentialCalendarObject($attrs, $line_header, &$data)
{
    global $dg_log_msg;

    $retdata = "";
    $arrdata = array();
    $del_flag = FALSE;

    /*���ȥ�ӥ塼������Ϥ�����ä��顢��λ����*/
    if ((count($attrs) == 0) || (is_array($attrs) === FALSE)) {
        $dg_log_msg = "Parameter attribute is invalid.(function replaceConfidentialCalendarObject)";
        return FALSE;
    }

    /* Original�ǡ������顢��İ��°����ʬ�䤹�뤳��*/
    $arrdata = explode("\r\n", $data);
    if ($arrdata === FALSE) {
        $dg_log_msg = "Parameter is invalid.(function replaceConfidentialCalendarObject)";
        return FALSE;
    }

    /* ���ȥ�ӥ塼�ȥ����������*/
    foreach ($attrs as $attr) {
        /* �ե饰��ꥻ�åȤ���*/
        $del_flag = FALSE;

        /* �ƥ��ȥ�ӥ塼�ȤȤ��ơ��ǡ����κ����Ԥ�*/
        foreach ($arrdata as $key => $value) {
            /* �ޥå������顢�ǡ����������롣���ԤΥǡ����Υե饰��TRUE�˥��åȤ���*/
            if (strncmp($value, $attr, strlen($attr)) === 0) {
                unset($arrdata[$key]);
                $del_flag = TRUE;

            /* ���ԥե饰��TRUE����Ƭ�Υ�����ɤ����Ĥ��ä��顢�������*/
            } elseif (($del_flag === TRUE) && (strncmp($value, $line_header, strlen($line_header)) === 0)) {
                unset($arrdata[$key]);

            /* �ե饰��FALSE���᤹*/
            } else {
                $del_flag = FALSE;
            }
        }
    }

    /* �ִ������ǡ������ݻ����뤳��*/
    $retdata = implode("\r\n", $arrdata);
    $data = $retdata;

    /* ���ｪλ���롣*/
    return TRUE;
}

?>
