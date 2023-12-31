<?php

/***********************************************************
 * カレンダーシステム用ライブラリ
 *
 * $Id: libcalendar.php 8212 2013-09-09 08:33:03Z maruyoshi $
 * $Revision: 8212 $
 * $Date:: 2013-09-09 17:33:03 +0900#$
 **********************************************************/

/* マクロ定義 */
define("ETCDIR", "etc/");
define("BASEDIR", "/usr/medaca/");

/* 設定ファイル名 */
define("CALCONF", "medaca.conf");

/* 設定ファイルのDBType用 */
define("DBTYPE_LDAP", "LDAP");

/* URL確認用 */
define("LIGHTNING", "0");
define("IPHONE",    "1");
define("URL_CALENDARS",  "calendars");
define("URL_PRINCIPALS", "principals");
define("URL_SPLIT_IPHONE_MIN"   , "3");
define("URL_SPLIT_IPHONE_MAX"   , "4");
define("URL_SPLIT_LIGHTNING_MIN", "4");
define("URL_SPLIT_LIGHTNING_MAX", "5");

/* syslog出力用 */
define("IDENT", "medaca");

/* カレンダー用オブジェクト名 */
define("OBJNAME_CALRESOURCE",   "calendarResource");
define("OBJNAME_CALCOLLECTION", "calendarCollection");
define("OBJNAME_CALDATA",       "calendarData");

/* カレンダー用要素名 */
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

/* ユーザ名長 */
define("NAME_MIN", 1);
define("NAME_MAX", 20);

/* リソース名長 */
define("RESOURCE_NAME_MIN", 1);
define("RESOURCE_NAME_MAX", 20);

/* コレクション名長 */
define("COLLECTION_NAME_MIN", 1);
define("COLLECTION_NAME_MAX", 20);

/* 関数の戻り値 */
define("FUNC_TRUE",   "1");
define("FUNC_FALSE",  "0");
define("FUNC_SYSERR", "-1");

/* 応答タイプ */
define("RETTYPE_ONE",  "0");
define("RETTYPE_MANY", "1");

/* 権限の数値 */
define("AUTHREADONLY",    "0");
define("AUTHREADWRITE",   "1");
define("AUTHRESTRICTION", "2");

/* アクティブフラグ */
define("COLLECTION_ACTIVE",   1);
define("COLLECTION_INACTIVE", 0);

/* 自動生成フラグ */
define("AUTOCREATE_ON",  "1");
define("AUTOCREATE_OFF", "0");

/* authorityArticleのユーザ */
define("ARTICLE_SEP", "U");
/* authorityArticleのデフォルトID */
define("ARTICLE_DEF_ID", "0");

/* collection=home */
define("COLLHOME", "home");

/* authorityDefaultのデフォルト値 */
define("CALAUTHORITYDEF_DEF", "0");

/* calendarCtagのデフォルト値 */
define("CALCTAG_DEF", "0");

/* collectionCountのデフォルト値 */
define("COLLECTIONCOUNT_DEF", "1");

/* collectionNumMaxのデフォルト値 */
define("COLLECTIONNUMMAX_DEF", "1");

/* collectionNumberのデフォルト値 */
define("COLLECTIONNUMBER_DEF", "1");

/* リソース追加失敗 */
define("RESO_FALSE", "-1");

/* コレクション追加失敗 */
define("COLL_FALSE", "-2");

/* CALDAV系定義 */
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
 * 設定ファイルの読み込みを行う
 *
 * [引数]
 *       $calendar_conf 設定ファイル情報(参照渡し)
 * [返り値]
 *       TRUE         正常
 *       FALSE        設定ファイル読み込み異常
 **********************************************************/
function read_calendar_conf(&$calendar_conf)
{
    /* 設定ファイル項目 */
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

    /* 設定のデフォルト値 */
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

    /* 設定ファイル読み込み */
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
 * DBtypeチェック
 *
 * [引数]
 *      $dbtype         DBtype
 * [返り値]
 *      TRUE            正常
 *      FALSE           異常
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
 * ログファイルに対し、エラーログ出力を行う
 *
 * [引数]
 *      $resultlog      エラーメッセージ
 * [返り値]
 *      なし
 ************************************************************/
function result_log($resultlog)
{
    global $calendar_conf;

    /* ファイルが読み込まれて設定されていた */
    if (isset($calendar_conf['syslogfacility']) ) {
        /* 出力先名 */
        $syslog = DgCommon_set_logfacility($calendar_conf['syslogfacility']);

        if (!isset($syslog)) {
            $syslog = LOG_LOCAL1;
        }
    } else {
        /* ファイルが読み込まれなかった場合 */
        $syslog = LOG_LOCAL1;
    }

    /* 書き込みたいログの内容にログ表示名、ログインユーザ名を結合。*/
    $user = "";
    if (isset($_SERVER['REMOTE_USER'])) {
        $user = $_SERVER['REMOTE_USER'];
    }
    $msg = $user . " " . $resultlog . "\n";

    /* ログオープン */
    $ret = openlog(IDENT, LOG_PID, $syslog);
    if ($ret === FALSE) {
        return;
    }

    /* ログ出力 */
    syslog(LOG_ERR, $msg);
    closelog();

    return;
}

/*********************************************************
 * check_user()
 *
 * HTTPリクエストよりユーザ名を確認する
 *
 * [引数]
 *       なし
 * [返り値]
 *       TRUE         正常
 *       FALSE        異常(認証を通っていない)
 **********************************************************/
function check_user()
{
    global $dg_log_msg;

    /* ユーザアカウントの確認 */
    if (isset($_SERVER["PHP_AUTH_USER"]) === FALSE &&
        isset($_SERVER["PHP_AUTH_PW"]) === FALSE ) {
        /* 認証していない */
        $dg_log_msg = "Authentication is not being used.";
        return FALSE;
    }

    /* 形式確認 */
    $ret = check_user_name($_SERVER["PHP_AUTH_USER"]);
    if ($ret === FALSE) {
        return FALSE;
    }

    return TRUE;
}

/*********************************************************
 * check_auth_digest()
 *
 * 認証方法がDIGEST認証であることを確認する
 *
 * [引数]
 *       なし
 * [返り値]
 *       TRUE         正常
 *       FALSE        異常(認証を通っていない)
 **********************************************************/
function check_auth_digest()
{
    global $dg_log_msg;

    if (empty($_SERVER['PHP_AUTH_DIGEST'])) {
        /* 認証していない */
        $dg_log_msg = "Authentication is not being used.";
        return FALSE;
    }

    return TRUE;
}

/*********************************************************
 * get_username()
 *
 * クライアントから送信された「Authorization」の内容からユーザ名を取得
 *
 * [引数]
 *       なし
 * [返り値]
 *       $username    ユーザ名
 *       FALSE        不正な形式
 **********************************************************/
function get_username()
{
    $username = "";

    /* ユーザ名取得 */
    $response   = explode(",", str_replace('"', '', $_SERVER['PHP_AUTH_DIGEST']));
    $tmp = null;
    foreach ($response as $v) {
        $tmp = explode("=", trim($v));
        if ($tmp[0] === "username") {
            $username  = $tmp[1];
            break;
        }
    }

    /* 形式確認 */
    $ret = check_user_name($username);
    if ($ret === FALSE) {
        return FALSE;
    }

    return $username;
}

/*********************************************************
 * check_url()
 *
 * HTTPリクエストからURI確認とresource,collectionの取得
 *
 * [引数]
 *       $resource    リソース名(参照渡し)
 *       $collection  コレクション名(参照渡し)
 * [返り値]
 *       TRUE         正常
 *       FALSE        異常(指定されているパスが異常)
 **********************************************************/
function check_url(&$resource, &$collection)
{
    global $dg_log_msg;
    global $access_type;

    /* 初期化 */
    $calendars  = "";
    $resource   = "";
    $collection = "";
    $min = URL_SPLIT_LIGHTNING_MIN;
    $max = URL_SPLIT_LIGHTNING_MAX;

    /* PATH分割 */
    $tmp = explode("/", $_SERVER["PATH_INFO"]);
    if (strcmp($tmp[1], URL_PRINCIPALS) == 0) {
        $min = URL_SPLIT_IPHONE_MIN;
        $max = URL_SPLIT_IPHONE_MAX;
        $access_type = IPHONE;
    }
    $tmpcount = count($tmp);
    if ($tmpcount != $min && $tmpcount != $max) {
        /* 指定しているパスが違う */
        $dg_log_msg = "Invalid URI.(" . $_SERVER["PATH_INFO"] . ")";
        return FALSE;
    }

    $calendars  = $tmp[1];
    $resource   = $tmp[2];
    $collection = $tmp[3];

    /* パスの確認 */
    if ($access_type == IPHONE) {
        if ($collection != "") {
            $dg_log_msg = "Invalid URI.(" . $_SERVER["PATH_INFO"] . ")";
            return FALSE;
        }
    } else if (strcmp($calendars, URL_CALENDARS) != 0) {
        /* 指定しているパスが違う */
        $dg_log_msg = "Invalid URI.(" . $_SERVER["PATH_INFO"] . ")";
        return FALSE;
    }

    return TRUE;
}

/*********************************************************
 * check_user_name()
 *
 * ユーザ名の形式確認
 *
 * [引数]
 *       $name        ユーザ名
 * [返り値]
 *       TRUE         正常
 *       FALSE        異常
 **********************************************************/
function check_user_name($name)
{
    global $dg_log_msg;

    /* 長さチェック */
    $len = strlen($name);
    if ($len < NAME_MIN || $len > NAME_MAX) {
        $dg_log_msg = "Invalid user name.($name)";
        return FALSE;
    }

    /* 半角英小文字大文字、数字、記号[-_.]のみ許可 */
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
 * リソース名の形式確認
 *
 * [引数]
 *       $name        リソース名
 * [返り値]
 *       TRUE         正常
 *       FALSE        異常
 **********************************************************/
function check_resource_name($name)
{
    global $dg_log_msg;

    /* 長さチェック */
    $len = strlen($name);
    if ($len < RESOURCE_NAME_MIN || $len > RESOURCE_NAME_MAX) {
        $dg_log_msg = "Invalid resource name.(" . $_SERVER["PATH_INFO"] . ")";
        return FALSE;
    }

    /* 半角英小文字大文字、数字、記号[-_.]のみ許可 */
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
 * コレクション名の形式確認
 *
 * [引数]
 *       $name        コレクション名
 * [返り値]
 *       TRUE         正常
 *       FALSE        異常
 **********************************************************/
function check_collection_name($name)
{
    global $dg_log_msg;

    /* 長さチェック */
    $len = strlen($name);
    if ($len < COLLECTION_NAME_MIN || $len > COLLECTION_NAME_MAX) {
        $dg_log_msg = "Invalid collection name.(" . $_SERVER["PATH_INFO"] . ")";
        return FALSE;
    }

    /* 半角英小文字大文字、数字、記号[-_.]のみ許可 */
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
 * 指定したリソースのLDAP情報を取得する
 *
 * [引数]
 *       $dg_ldapid    リンクID
 *       $resource     リソース名
 *       $ldapdata     検索したLDAPデータ(参照渡し)
 * [返り値]
 *       FUNC_TRUE      LDAP情報を見つけた
 *       FUNC_FALSE     LDAP情報が見つからなかった
 *       FUNC_SYSERR    異常が発生した
 **********************************************************/
function get_resource($dg_ldapid, $resource, &$ldapdata)
{
    global $dg_log_msg;
    global $calendar_conf;

    /* filter作成 */
    $filter = sprintf("%s=%s",
                      CALRESOURCE, DgLDAP_filter_escape($resource));
    $attrs = array();
    $scope = TYPE_ONEENTRY;
    $dn = sprintf("%s=%s,%s",
                   CALRESOURCE, LDAP_dn_escape($resource),
                   $calendar_conf["ldapbasedn"]);

    /* LDAPの情報を取得 */
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
 * カレンダーデータを追加する
 *
 * [引数]
 *       $resource          リソース名
 *       $collection　　　　コレクション名
 *       $objecturi　　　　 カレンダーID
 *       $caldata           カレンダー情報
 *
 * [返り値]
 *       TRUE               追加成功
 *       FALSE              追加失敗
 **********************************************************/
function ldap_calendar_add($resource, $collection, $objecturi, $caldata)
{
    global $calendar_conf;
    global $dg_log_msg;
    global $dg_ldapid;

    /* dn 作成 */
    $dn = sprintf("%s=%s,%s=%s,%s=%s,%s",
                  CALOBJURI, LDAP_dn_escape($objecturi),
                  CALCOLLECTION, LDAP_dn_escape($collection),
                  CALRESOURCE, LDAP_dn_escape($resource),
                  $calendar_conf["ldapbasedn"]);

    /* LDAP 追加 */
    $ret = DgLDAP_add_entry_batch($dn, $dg_ldapid, $caldata);
    if ($ret != LDAP_OK) {
        return FALSE;
    }

    return TRUE;
}

/*********************************************************
 * ldap_calendar_mod()
 *
 * カレンダーデータを変更する
 *
 * [引数]
 *       $resource          リソース名
 *       $collection　　　　コレクション名
 *       $objecturi　　　　 カレンダーID
 *       $caldata           カレンダー情報
 *
 * [返り値]
 *       TRUE               変更成功
 *       FALSE              変更失敗
 **********************************************************/
function ldap_calendar_mod($resource, $collection, $objecturi, $caldata)
{
    global $calendar_conf;
    global $dg_ldapid;

    /* dn 作成 */
    $dn = sprintf("%s=%s,%s=%s,%s=%s,%s",
                  CALOBJURI, LDAP_dn_escape($objecturi),
                  CALCOLLECTION, LDAP_dn_escape($collection),
                  CALRESOURCE, LDAP_dn_escape($resource),
                  $calendar_conf["ldapbasedn"]);

    /* LDAP 変更 */
    $ret = DgLDAP_mod_entry_batch($dn, $dg_ldapid, $caldata);
    if ($ret != LDAP_OK) {
        return FALSE;
    }

    return TRUE;
}

/*********************************************************
 * ldap_calendar_del()
 *
 * カレンダーデータを変更する
 *
 * [引数]
 *       $resource          リソース名
 *       $collection　　　　コレクション名
 *       $objecturi　　　　 カレンダーID
 *
 * [返り値]
 *       TRUE               削除成功
 *       FALSE              削除失敗
 **********************************************************/
function ldap_calendar_del($resource, $collection, $objecturi)
{
    global $calendar_conf;
    global $dg_ldapid;

    /* dn 作成 */
    $dn = sprintf("%s=%s,%s=%s,%s=%s,%s",
                  CALOBJURI, LDAP_dn_escape($objecturi),
                  CALCOLLECTION, LDAP_dn_escape($collection),
                  CALRESOURCE, LDAP_dn_escape($resource),
                  $calendar_conf["ldapbasedn"]);

    /* LDAP 削除 */
    $ret = DgLDAP_del_entry_batch($dn, $dg_ldapid);
    if ($ret != LDAP_OK) {
        return FALSE;
    }

    return TRUE;
}

/*********************************************************
 * ldap_collection_ctag_update()
 *
 * collectionにあるCTAGを更新する
 *
 * [引数]
 *       $resource          リソース名
 *       $collection　　　　コレクション名
 *       $ctag              更新するCTag情報
 *
 * [返り値]
 *      TRUE     正常
 *      FALSE    異常
 **********************************************************/
function ldap_collection_ctag_update($resource, $collection, $ctag)
{
    global $calendar_conf;
    global $dg_ldapid;

    /* collectionの情報を更新 */
    /* dn 作成 */
    $dn = sprintf("%s=%s,%s=%s,%s",
                  CALCOLLECTION, LDAP_dn_escape($collection),
                  CALRESOURCE, LDAP_dn_escape($resource),
                  $calendar_conf["ldapbasedn"]);

    /* 更新するCTag */
    $data[CALCTAG] = $ctag;

    /* LDAP 更新 */
    $ret = DgLDAP_mod_entry_batch($dn, $dg_ldapid, $data);
    if ($ret != LDAP_OK) {
        return FALSE;
    }

    return TRUE;
}

/*********************************************************************
 * set_ldapinfo
 *
 * ldapinfo作成
 *
 * [引数]
 *      $authldap       Ldap Auth check
 *
 * [返り値]
 *      TRUE             正常
 **********************************************************************/
function set_ldapinfo($authldap = FALSE)
{
    global $calendar_conf;
    global $dg_ldapinfo;

    /* 自分自身へのバインド(有効: TRUE 無効: FALSE) */
    $dg_ldapinfo["ldapuserself"] = FALSE;

    /* 自分自身へバインドする場合のバインドDN */
    $dg_ldapinfo["ldapuserselfdn"] = "";

    /* 自分自身へバインドする場合のバインドパスワード */
    $dg_ldapinfo["ldapuserselfpw"] = "";

    /* read-onlyサーバへのバインド(有効: TRUE 無効: FALSE) */
    $dg_ldapinfo["ldapro"] = FALSE;

    /* read-onlyサーバのIPアドレス */
    $dg_ldapinfo["ldapserverro"] = "";

    /* read-onlyサーバのポート番号 */
    $dg_ldapinfo["ldapportro"] = "";

    /* 引数が渡された場合*/
    if ($authldap) {
        /* LDAPサーバのIPアドレス */
        $dg_ldapinfo["ldapserver"] = $calendar_conf["authldapserver"];

        /* LDAPサーバのポート番号 */
        $dg_ldapinfo["ldapport"] = $calendar_conf["authldapport"];

        /* LDAPサーバのバインドDN */
        $dg_ldapinfo["ldapbinddn"] = $calendar_conf["authldapbinddn"];

        /* LDAPサーバのバインドパスワード */
        $dg_ldapinfo["ldapbindpw"] = $calendar_conf["authldapbindpw"];

    /* 引数が渡さない場合*/
    } else {
        /* LDAPサーバのIPアドレス */
        $dg_ldapinfo["ldapserver"] = $calendar_conf["ldapserver"];

        /* LDAPサーバのポート番号 */
        $dg_ldapinfo["ldapport"] = $calendar_conf["ldapport"];

        /* LDAPサーバのバインドDN */
        $dg_ldapinfo["ldapbinddn"] = $calendar_conf["ldapbinddn"];

        /* LDAPサーバのバインドパスワード */
        $dg_ldapinfo["ldapbindpw"] = $calendar_conf["ldapbindpw"];
    }

    return TRUE;
}

 /********************************************************************
 * ldap_connect_server()
 *
 * LDAPに接続
 *
 * [引数]
 *      $ds         リンクID(参照渡し)
 *
 * [返り値]
 *      TRUE        正常
 *      FALUSE      異常
 *********************************************************************/
function ldap_connect_server(&$ds)
{
    global $calendar_conf;

    /* ldapinfoの値を入れる */
    set_ldapinfo();

    /* LDAP接続 */
    $ds = DgLDAP_connect_server();
    if ($ds == LDAP_ERR_BIND) {
        return FALSE;
    }

    return TRUE;
}

/*********************************************************************
 * search_all_calendar()
 *
 * LDAPからコレクション配下にある全てのカレンダー情報を検索し、取得する
 *
 * [引数]
 *      $resource        リソース名
 *      $collection      コレクション名
 *      $caldata         カレンダー情報(参照渡し)
 *
 * [返り値]
 *      TRUE             検索成功
 *      FALUSE           検索失敗
 **********************************************************************/
function search_all_calendar($resource, $collection, &$caldata)
{
    global $calendar_conf;
    global $dg_ldapid;
    global $access_type;

    /* 検索ベースDN */
    $basedn = sprintf("%s=%s,%s=%s,%s", CALCOLLECTION,
                      LDAP_dn_escape($collection), CALRESOURCE,
                      LDAP_dn_escape($resource), $calendar_conf["ldapbasedn"]);

    /* 検索フィルタ */
    $filter = "(" . OBJECTCLASS . "=" . OBJNAME_CALDATA . ")";
    if ($access_type == IPHONE) {

    }

    /* 取得する属性名 */
    $attrs = array();

    /* 検索スコープ */
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
 * LDAPからカレンダー情報を検索し、取得する
 *
 * [引数]
 *      $objecturi       カレンダーID
 *      $resource        リソース名
 *      $collection      コレクション名
 *      $caldata         カレンダー情報(参照渡し)
 *
 * [返り値]
 *      TRUE             検索成功
 *      FALUSE           検索失敗
 **********************************************************************/
function search_calendar($objecturi, $resource, $collection, &$caldata)
{
    global $calendar_conf;
    global $dg_ldapid;

    /* 検索ベースDN */
    $basedn = sprintf("%s=%s,%s=%s,%s=%s,%s",
                      CALOBJURI, LDAP_dn_escape($objecturi),
                      CALCOLLECTION, LDAP_dn_escape($collection),
                      CALRESOURCE, LDAP_dn_escape($resource),
                      $calendar_conf["ldapbasedn"]);

    /* 検索フィルタ */
    $filter = "(" . OBJECTCLASS . "=" . OBJNAME_CALDATA . ")";

    /* 取得する属性名 */
    $attrs = array(CALMODTIME, CALOBJDATA);

    /* 検索スコープ */
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
 * コレクション情報を取得する
 *
 * [引数]
 *      $resource        リソース名
 *      $collection      コレクション名
 *      $attrs           属性名
 *      $colledata       コレクション情報(参照渡し）
 *
 * [返り値]
 *       FUNC_TRUE      LDAP情報を見つけた
 *       FUNC_FALSE     LDAP情報が見つからなかった
 *       FUNC_SYSERR    異常が発生した
 ********************************************************************/
function get_collection($resource, $collection, $attrs, &$colledata)
{
    global $calendar_conf;
    global $dg_ldapid;
    global $dg_log_msg;

    /* 検索ベースDN */
    $basedn = sprintf("%s=%s,%s=%s,%s",
                      CALCOLLECTION, LDAP_dn_escape($collection),
                      CALRESOURCE, LDAP_dn_escape($resource),
                      $calendar_conf["ldapbasedn"]);

    /* 検索フィルタ */
    $filter = "(" . OBJECTCLASS . "=" .  OBJNAME_CALCOLLECTION . ")";

    /* 検索スコープ */
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
 * コレクション情報を取得する(iPhone用)
 *
 * [引数]
 *      $resource        リソース名
 *      $filter		 検索フィルタ
 *      $attrs		 属性名
 *      $colledata       コレクション情報(参照渡し）
 *
 * [返り値]
 *       FUNC_TRUE      LDAP情報を見つけた
 *       FUNC_FALSE     LDAP情報が見つからなかった
 *       FUNC_SYSERR    異常が発生した
 ********************************************************************/
function get_collection_principals($resource, $filter, $attrs, &$colledata)
{
    global $calendar_conf;
    global $dg_ldapid;
    global $dg_log_msg;

    /* 検索ベースDN */
    $basedn = sprintf("%s=%s,%s",
                      CALRESOURCE, LDAP_dn_escape($resource),
                      $calendar_conf["ldapbasedn"]);

    /* 検索スコープ */
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
 * authorityArticleの値を成形する
 *
 * [引数]
 *      $article              authorityArticleの全ての情報(配列）
 *      $sep_article_data     authorityArticleのID毎にユーザ、権限を入れた配列
 *                            (参照渡し）
 *
 * [返り値]
 *      TRUE                  正常
 *      FALUSE                異常
 **********************************************************************/
function get_article_data($article, &$sep_article_data)
{
    global $dg_log_msg;

    /* authorityArticleがいくつあるか数える */
    $num = count($article);

    /* authorityArticleをコロン区切りで分ける */
    for ($count = 0 ; $num > $count ; $count++) {
        $article_data = explode(":", $article[$count], 2);

        /* $article_data[0]の存在、数値チェック */
        $match = preg_match("/^[0-9]+$/", $article_data[0]);
        if ($match != 1) {
            $dg_log_msg = "Article ID is invalid. (" . $article[$count] . ")";
            return FALSE;
        }

        /* $article_data[1]の存在確認 */
        if (isset($article_data[1]) === FALSE || $article_data[1] == "") {
            $dg_log_msg = "Article authority or user name is empty. (" .
                          $article[$count] . ")";
            return FALSE;
        }

        /* 権限が読み取り、読み書き、禁止以外のとき */
        if (check_auth_flag($article_data[1][0]) === FALSE) {
            $dg_log_msg .= "(" . $article[$count] . ")";
            return FALSE;
        }

        /* authorityArticleのUチェック */
        if ($article_data[1][1] != ARTICLE_SEP) {
            $dg_log_msg = "Article form is invalid. (" . $article[$count] . ")";
            return FALSE;
        }

        /* $article_data[1]からユーザ名を取得する */
        $user = substr($article_data[1], 2);

        /* authorityArticleのユーザ名チェック */
        if (check_user_name($user) === FALSE) {
            $dg_log_msg = "Article user form is invalid. (" .
                          $article[$count] . ")";
            return FALSE;
        }

        /* 配列の存在確認 */
        $id = $article_data[0];
        if (isset($sep_article_data[$id]) === TRUE) {
            $dg_log_msg = "Article id is already exists. (" .
                          $article[$count] . ")";
            return FALSE;
        }

        /* 配列に値を入れる */
        $sep_article_data[$id]["authority"] = $article_data[1][0];
        $sep_article_data[$id]["user"] = $user;
    }

    return TRUE;
}

/*********************************************************************
 * get_order_data()
 *
 * authorityOrderの情報を分解し、配列に入れる
 *
 * [引数]
 *      $order          authorityOrder
 *      $order_list     順序情報(参照渡し）
 *
 * [返り値]
 *      TRUE        正常
 *      FALUSE      異常
 **********************************************************************/
function get_order_data($order, &$order_list)
{
    global $dg_log_msg;

    /* authorityOrderをコロン区切りで分ける */
    $order_list = explode(":", $order);

    foreach ($order_list as $order_num) {

        /* IDの存在と数値チェック */
        $match = preg_match("/^[0-9]+$/", $order_num);
        if ($match != 1) {
            $dg_log_msg = "AuthorityOrder has broken.";
            return FALSE;
        }
    }

    /* IDの重複チェック */
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
 * コレクション権限情報を確認する
 *
 * [引数]
 *      $order         ユーザ権限の順序情報
 *      $article       ユーザ権限情報
 *      $user          ユーザ
 *      $default       デフォルト権限
 *      $authority     権限
 *
 * [返り値]
 *      TRUE        正常
 *      FALUSE      異常
 **********************************************************************/
function check_authority_data($order, $article, $user, $default, &$authority)
{
    global $dg_log_msg;
    $authority = "";

    /* authorityOrder,authorityArticleが無い時にはデフォルト設定を
       有効とする */
    if ($order == "" || $article == "") {
	$authority = $default;
	return TRUE;
    }

    /* authorityOrderの値を配列に入れる */
    if (get_order_data($order, $order_list) === FALSE) {
        return FALSE;
    }

    /* authorityArticleの値を配列に入れる */
    if (get_article_data($article, $sep_article_data) === FALSE) {
        return FALSE;
    }

    /* 配列$order_listに値が入っているか */
    if (empty($order_list) === TRUE) {
        $dg_log_msg = "Order is empty.";
        return FALSE;
    }

    foreach ($order_list as $order_id) {
        /* ログインユーザがauthorityArticleに存在するか */
        if (isset($sep_article_data[$order_id]) &&
            $sep_article_data[$order_id]["user"] == $user) {
            $authority = $sep_article_data[$order_id]["authority"];
            return TRUE;
        }
    }
    /* 存在しない */
    $authority = $default;

    return TRUE;
}

/*********************************************************************
 * check_auth_flag()
 *
 * 権限の情報が範囲内か確認する
 *
 * [引数]
 *      $authority     権限
 *
 * [返り値]
 *      TRUE        正常
 *      FALUSE      異常
 **********************************************************************/
function check_auth_flag($authority)
{
    global $dg_log_msg;

    /* 確認用配列 */
    $checkarray = array(AUTHREADONLY, AUTHREADWRITE, AUTHRESTRICTION);

    /* 権限確認 */
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
 * リソース生成
 *
 * [引数]
 *      $resource      リソース名
 *      $user          ユーザ名
 *
 * [返り値]
 *      TRUE           生成成功
 *      FALSE          生成失敗
 **********************************************************/
function add_resource($resource, $user)
{
    global $calendar_conf;
    global $dg_ldapid;
    global $dg_log_msg;

    /* 追加するリソースのDN */
    $dn_r = sprintf("%s=%s,%s",CALRESOURCE, LDAP_dn_escape($resource),
                    $calendar_conf["ldapbasedn"]);

    /* リソースの属性 */
    $data_r[OBJECTCLASS] = OBJNAME_CALRESOURCE;
    $data_r[COLLECTIONCOUNT] = COLLECTIONCOUNT_DEF;
    $data_r[CALADMINU] = $user;
    $data_r[CALRESOURCE] = $resource;
    $data_r[COLLECTIONNUMMAX] = COLLECTIONNUMMAX_DEF;

    /* リソース作成 */
    $ret_r = DgLDAP_add_entry_batch($dn_r, $dg_ldapid, $data_r);
    if ($ret_r != LDAP_OK) {
        return FALSE;
    }

    return TRUE;
}

/**********************************************************
 * add_default_collection()
 *
 * コレクションhome生成
 *
 * [引数]
 *      $resource      リソース名
 *      $user          ユーザ名
 *
 * [返り値]
 *      TRUE           生成成功
 *      FALSE          生成失敗
 **********************************************************/
function add_default_collection($resource, $user)
{
    global $calendar_conf;
    global $dg_ldapid;
    global $dg_log_msg;

    /* 追加するコレクションのDN */
    $dn_c = sprintf("%s=%s,%s=%s,%s", CALCOLLECTION, 
	           LDAP_dn_escape($calendar_conf["autocreatecollectionname"]),
                   CALRESOURCE, LDAP_dn_escape($resource), 
                   $calendar_conf["ldapbasedn"]);

    /* authorityArticleを整形する */
    $article = sprintf("%s:%s%s%s", ARTICLE_DEF_ID, AUTHREADWRITE,
                       ARTICLE_SEP, $user);

    /* コレクションの属性 */
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

    /* コレクション追加 */
    $ret_c = DgLDAP_add_entry_batch($dn_c, $dg_ldapid, $data_c);
    if ($ret_c != LDAP_OK) {
        return FALSE;
    }

    return TRUE;
}

/**********************************************************
 * del_resource()
 *
 * リソース削除
 *
 * [引数]
 *      $resource      リソース名
 *
 * [返り値]
 *      TRUE           削除成功
 *      FALSE          削除失敗
 **********************************************************/
function del_resource($resource)
{
    global $dg_ldapid;
    global $dg_log_msg;
    global $calendar_conf;

    /* 削除するDN */
    $deldn = sprintf("%s=%s,%s", CALRESOURCE, LDAP_dn_escape($resource),
                     $calendar_conf["ldapbasedn"]);

    /* リソース削除 */
    $ret = DgLDAP_del_entry_batch($deldn, $dg_ldapid);
    if ($ret != LDAP_OK) {
        return FALSE;
    }

    return TRUE;
}

/**********************************************************
 * create_resource_collection()
 *
 * リソース・コレクション自動生成
 *
 * [引数]
 *      $resource      リソース名
 *      $user          ユーザ名
 *
 * [返り値]
 *      TRUE           生成成功
 *      RESO_FALSE     リソース生成失敗
 *      COLL_FALSE     コレクション生成失敗
 *      DEL_FALSE      リソース削除失敗
 **********************************************************/
function create_resource_collection($resource, $user)
{
    global $dg_log_msg;

    /* リソース追加 */
    if (add_resource($resource, $user) === FALSE) {
        return RESO_FALSE;
    }

    /* コレクション追加 */
    if (add_default_collection($resource, $user) === FALSE) {
        /* コレクション追加失敗時のエラーログを保持 */
        $add_collection_log_msg = $dg_log_msg;

        /* 追加したリソースの削除 */
        if (del_resource($resource) === FALSE) {
            /* リソース削除失敗時のエラーログを保持 */
            $del_resource_log_msg = $dg_log_msg;
            /* コレクションとリソースのログを合わせる */
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
 * カレンダーデータ応答用情報作成
 *
 * [引数]
 *       $ldapdata    カレンダーLDAPデータ
 *       $rettype     応答するタイプ
 *                      RETTYPE_ONE :一つのみ
 *                      RETTYPE_MANY:複数
 * [返り値]
 *       $retarray    応答する配列情報
 **********************************************************/
function createReturnCalendarObject($ldapdata, $rettype)
{
    global $dg_user;

    $retarray = array();
    $tmparray = array();
    $schedule_info = "";
    $key = 0;

    /* アトリビュートが長すぎ場合、空行を入って、一つの属性は数行になります。
       次のデータ行の先頭文字を確定する*/
    $line_header = " ";

    /* 削除アトリビュートの配列宣言*/
    $attrs = array("RRULE",
                   /* alarmのアトリビュート*/
                   "BEGIN:VALARM",
                   "ACTION",
                   "TRIGGER",
                   "END:VALARM",
                   /* 参加者のアトリビュート情報*/
                   "ORGANIZER;",
                   "ATTENDEE;",
                   "X-MOZ-SEND-INVITATIONS",
                   /* 添付リンク*/
                   "ATTACH",
                   "X-MOZ-LASTACK",
                   /* カテゴリ*/
                   "CATEGORIES",
                   /* 場所*/
                   "LOCATION",
                   /* 詳細*/
                   "DESCRIPTION",
                   /* プライバシー*/
                   "TRANSP",
                   /* 件名(タイトル)*/
                   "SUMMARY",
                   /* 修正数*/
                   "X-MOZ-GENERATION",
                   "SEQUENCE",
                   /* その他*/
                   "X-MOZ-SNOOZE-TIME",
                   /* VTODOのみ*/
                   "STATUS",
                   "PERCENT-COMPLATE",
                   "RECURRENCE-ID"
                   );

    $alarm = array("TRIGGER;VALUE=DURATION");

    /* LDAPデータ分の情報を生成する */
    foreach ($ldapdata as $data) {
        /* 予定情報を保持すること*/
        $schedule_info = $data[CALOBJDATA][0];

        /* プライバシーで他者として、データを参照しない */
        if ((preg_match("/,resource=" . $dg_user . ",/", $data["dn"]) !== 1) &&
            (preg_match("/\r\nCLASS:PRIVATE\r\n/", $data[CALOBJDATA][0])
              === 1)) {
            continue;
        }

        /* 日時のみ公開の場合は日時以外のデータを削除する */
        if ((preg_match("/,resource=" . $dg_user . ",/", $data["dn"]) !== 1) &&
            (preg_match("/\r\nCLASS:CONFIDENTIAL\r\n/", $data[CALOBJDATA][0])
              === 1)) {
            replaceConfidentialCalendarObject($attrs, $line_header,
                                              $schedule_info);
        }

        /* 自分以外の通知は削除する */
        if ((preg_match("/,resource=" . $dg_user . ",/", $data["dn"]) !== 1)) {
            replaceConfidentialCalendarObject($alarm, $line_header,
                                              $schedule_info);
        }

        /* データを添付に格納*/
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
        /* 一つだけ応答する(単一情報取得の場合) */
        $retarray = $tmparray[0];
    } else {
        /* 複数応答する */
        $retarray = $tmparray;
    }

    return $retarray;
}

/*********************************************************
 * LDAP_dn_escape()
 *
 * DNのエスケープ
 *
 * DNに指定される文字列(,+\<>;#/\)をエスケープします。
 *
 * [引数]
 *      $str   エスケープする文字列
 * [返り値]
 *      string エスケープ後の文字列
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
 * コレクションの権限チェック
 *
 * [引数]
 *      $calendarid	カレンダーID
 *      $collection	コレクション名(参照渡し)
 *      $authority	権限（参照渡し)
 * [返り値]
 *      $ret 		check_authority_dataの返り値
 **********************************************************/
function check_collection_authority($calendarid, &$collection, &$authority)
{
    global $dg_user;
    global $dg_log_msg;
    global $ldap_collection_data;

    foreach($ldap_collection_data as $one_data) {

        /* カレンダーIDとコレクションナンバーが一致したら */
        if ($calendarid == $one_data[COLLECTIONNUMBER][0]) {

            /* 権限情報格納 */
            $order      = $one_data[CALAUTHORITYORDER][0];
            $article    = $one_data[CALAUTHORITYARTICLE];
            $def        = $one_data[CALAUTHORITYDEF][0];
            $collection = $one_data[CALCOLLECTION][0];
            break;
        }
    }
    /* コレクション権限確認 */
    $ret = check_authority_data($order, $article, $dg_user, $def, $authority);

    return $ret;
}

/*********************************************************
 * check_auth_basic()
 *
 * 認証方法がBASIC認証であることを確認する
 *
 * [引数]
 *       なし
 * [返り値]
 *       TRUE         正常
 *       FALSE        異常(認証を通っていない)
 **********************************************************/
function check_auth_basic()
{
    global $dg_log_msg;

    if (empty($_SERVER['PHP_AUTH_USER'])) {
        /* 認証していない */
        $dg_log_msg = "Authentication is not being used.";
        return FALSE;
    }

    return TRUE;
}

/*********************************************************
 * get_username_basic()
 *
 * クライアントから送信された「Authorization」の内容からユーザ名を取得
 *
 * [引数]
 *       なし
 * [返り値]
 *       $username    ユーザ名
 *       FALSE        不正な形式
 **********************************************************/
function get_username_basic()
{
    $username = "";

    /* ユーザ名取得 */
    if (!isset($_SERVER['PHP_AUTH_USER'])) {
        return FALSE;
    }

    $username = $_SERVER['PHP_AUTH_USER'];

    /* 形式確認 */
    $ret = check_user_name($username);
    if ($ret === FALSE) {
        return FALSE;
    }

    return $username;
}

 /********************************************************************
 * ldap_bind_user()
 *
 * LDAPに接続
 *
 * [引数]
 *      $userid         BASIC USERID
 *      $passwd         BASIC PASSWORD
 *
 * [返り値]
 *      TRUE        正常
 *      FALUSE      異常
 *********************************************************************/
function ldap_bind_user($userid, $passwd)
{
    global $calendar_conf;
    global $dg_ldapinfo;
    $result = array();
    $attrs = array();

    /* ldapinfoの値を入れる */
    set_ldapinfo(TRUE);

    /* Filter作成*/
    $filter = sprintf($calendar_conf["authldapfilter"], DgLDAP_filter_escape($userid));

    /* 取得する属性名 */
    $attrs = array("dn");

    /* 検索スコープ */
    $type = TYPE_SUBTREE;

    /* LDAPエントリ検索 */
    $ret = DgLDAP_get_entry($calendar_conf["authldapbasedn"], $filter, $attrs, $type, $data);
    if ($ret !== LDAP_OK) {
        return FALSE;
    }

    /* 自分自身へのバインド(有効: TRUE 無効: FALSE) */
    $dg_ldapinfo["ldapuserself"] = TRUE;

    /* 自分自身へバインドする場合のバインドDN */
    $dg_ldapinfo["ldapuserselfdn"] = $data[0]["dn"];

    /* 自分自身へバインドする場合のバインドパスワード */
    $dg_ldapinfo["ldapuserselfpw"] = $passwd;

    /* LDAPバインド */
    $ds = DgLDAP_connect_server();
    if ($ds == LDAP_ERR_BIND) {
        return FALSE;
    }
    return TRUE;
}

/*********************************************************
 * replaceConfidentialCalendarObject()
 *
 * 渡した配列で、Confidentialデータの中に存在したアトリビュートを削除する。
 *
 * [引数]
 *       $attrs       削除属性の配列
 *       $data        プライベートデータ
 * [返り値]
 *       $TRUE    正常に終了
 *       $FALSE   以上に終了
 **********************************************************/
function replaceConfidentialCalendarObject($attrs, $line_header, &$data)
{
    global $dg_log_msg;

    $retdata = "";
    $arrdata = array();
    $del_flag = FALSE;

    /*アトリビュート配列はからだったら、終了する*/
    if ((count($attrs) == 0) || (is_array($attrs) === FALSE)) {
        $dg_log_msg = "Parameter attribute is invalid.(function replaceConfidentialCalendarObject)";
        return FALSE;
    }

    /* Originalデータから、一つ一つ属性を分割すること*/
    $arrdata = explode("\r\n", $data);
    if ($arrdata === FALSE) {
        $dg_log_msg = "Parameter is invalid.(function replaceConfidentialCalendarObject)";
        return FALSE;
    }

    /* アトリビュートズけ寨�する*/
    foreach ($attrs as $attr) {
        /* フラグをリセットする*/
        $del_flag = FALSE;

        /* 各アトリビュートとして、データの削除を行う*/
        foreach ($arrdata as $key => $value) {
            /* マッチだたら、データを削除する。改行のデータのフラグをTRUEにセットする*/
            if (strncmp($value, $attr, strlen($attr)) === 0) {
                unset($arrdata[$key]);
                $del_flag = TRUE;

            /* 改行フラグはTRUEと先頭のキーワードが見つかったら、削除する*/
            } elseif (($del_flag === TRUE) && (strncmp($value, $line_header, strlen($line_header)) === 0)) {
                unset($arrdata[$key]);

            /* フラグをFALSEに戻す*/
            } else {
                $del_flag = FALSE;
            }
        }
    }

    /* 置換したデータを保持すること*/
    $retdata = implode("\r\n", $arrdata);
    $data = $retdata;

    /* 正常終了する。*/
    return TRUE;
}

?>
