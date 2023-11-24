<?php

/***********************************************************
 * カレンダーシステム用メイン処理
 *
 * $Id: calendar.php 7232 2013-07-29 06:27:29Z kien $
 * $Revision: 7232 $
 * $Date:: 2013-07-29 15:27:29 +0900#$
 **********************************************************/
use Sabre\CalDAV;
use Sabre\DAV;
use Sabre\DAV\Auth;
use Sabre\DAVACL;

/* パスワードファイル名 */
define("AUTHUSERFILE", "passwd");

/* タイムゾーン設定 */
date_default_timezone_set('Asia/Tokyo');

/* ライブラリ組み込み */
require_once 'lib/Sabre/autoload.php';
require_once 'Dg_Common.php';
require_once 'Dg_LDAP.php';
require_once '../lib/libcalendar.php';
require_once '../lib/libclass.php';

/* グローバル変数の初期化 */
$dg_ldapid = FALSE;
$calendar_conf = array();
$dg_resource = "";
$dg_collection = "";
$dg_authority = FALSE;
$access_type = LIGHTNING;
$realm = "MEDACA";

$authBackend = null;
$authPlugin = null;
$server = null;
$tree = null;
$caldavPlugin = null;
$browser = null;
$calendarBackend = null;
$principalBackend = null;
$ret = FALSE;
$passfile = "";
$dg_log_msg = "";


/* 初期ファイル読み込み */
$ret = read_calendar_conf($calendar_conf);
if ($ret === FALSE) {
    result_log($dg_log_msg);
    header("HTTP/1.1 500 Internal Server Error");
    exit(1);
}



/* パスワードファイルチェック */
$passfile = BASEDIR . ETCDIR . AUTHUSERFILE;
if (DgCommon_is_readable_file($passfile) === FALSE) {
    result_log($dg_log_msg);
    header("HTTP/1.1 500 Internal Server Error");
    exit(1);
}

/* LDAP認証方法*/
if ($calendar_conf["authldap"] == 1) {
    /* 認証チェック */
    $ret = check_auth_basic();
    if ($ret === FALSE) {
        result_log($dg_log_msg);
        header('HTTP/1.1 401 Unauthorized');
        header('WWW-Authenticate: Basic realm="' . $realm . '"');
        exit(1);
    }

    /* ユーザ名格納 */
    $dg_user = get_username_basic();
    if ($dg_user === FALSE) {
        result_log($dg_log_msg);
        header("HTTP/1.1 403 Forbidden");
        exit(1);
    }

/* File認証方法*/
} else {
    /* 認証チェック */
    $ret = check_auth_digest();
    if ($ret === FALSE) {
        result_log($dg_log_msg);
        header('HTTP/1.1 401 Unauthorized');
        header('WWW-Authenticate: Digest realm="' . $realm .
               '",qop="auth",nonce="' . uniqid() . '",opaque="' . md5($realm) . '"');
        exit(1);
    }

    /* ユーザ名格納 */
    $dg_user = get_username();
    if ($dg_user === FALSE) {
        result_log($dg_log_msg);
        header("HTTP/1.1 403 Forbidden");
        exit(1);
    }
}

/* URL確認 */
$ret = check_url($dg_resource, $dg_collection);
if ($ret === FALSE) {
    result_log($dg_log_msg);
    header("HTTP/1.1 404 Not Found");
    exit(1);

/* check_urlが正常終了かつコレクション名が未指定の場合は、
   iPhoneからのアクセスとして扱う */
} else if ($ret === TRUE && $dg_collection == "") {
    $access_type = IPHONE;
}

/* リソースの形式チェック */
$ret = check_resource_name($dg_resource);
if ($ret === FALSE) {
    result_log($dg_log_msg);
    header("HTTP/1.1 404 Not Found");
    exit(1);
}

/* OPTIONS,iPhoneの時は、コレクションの情報が飛んでこない */
if ($_SERVER["REQUEST_METHOD"] != "OPTIONS" && $access_type != IPHONE) {
    /* コレクションの形式チェック */
    $ret = check_collection_name($dg_collection);
    if ($ret === FALSE) {
        result_log($dg_log_msg);
        header("HTTP/1.1 404 Not Found");
        exit(1);
    }
}

/* LDAP接続 */
$ret = ldap_connect_server($dg_ldapid);
if ($ret === FALSE) {
    result_log($dg_log_msg);
    header("HTTP/1.1 500 Internal Server Error");
    exit(1);
}

/* OPTIONSの時は、LDAPの確認はしなくてよい */
if ($_SERVER["REQUEST_METHOD"] != "OPTIONS") {
    /* リソースの確認 */
    /* LDAPからリソースの取得 */
    $ret = get_resource($dg_ldapid, $dg_resource, $resourcedata);
    if ($ret == FUNC_SYSERR) {
        /* LDAP異常 */
        result_log($dg_log_msg);
        ldap_unbind($dg_ldapid);
        header("HTTP/1.1 500 Internal Server Error");
        exit(1);
    } elseif ($ret == FUNC_FALSE) {
        /* リソースが見つからなかった -> 自動生成フラグ確認
           AUTOCREATE_ON -> 自動生成 , AUTOCREATE_OFF -> そのまま */
        if ($calendar_conf["autoresourcecreate"] == AUTOCREATE_ON) {
        
            /* ユーザ名とリソース名が一致しているか */
            if (strcmp($dg_user, $dg_resource) != 0) {
                $dg_log_msg = "Cannot found resource.(resource:$dg_resource)";
                result_log($dg_log_msg);
                ldap_unbind($dg_ldapid);
                header("HTTP/1.1 404 Not Found");
                exit(1);
            } 

            /* iPhoneからでないとき、コレクション名確認 */
            if ($access_type != IPHONE && strcmp($dg_collection, 
                $calendar_conf["autocreatecollectionname"]) != 0) {
                $dg_log_msg = "Cannot found resource.(resource:$dg_resource)";
                result_log($dg_log_msg);
                ldap_unbind($dg_ldapid);
                header("HTTP/1.1 404 Not Found");
                exit(1);
            }

            /* リソースとコレクションの生成 */
            $ret = create_resource_collection($dg_resource, $dg_user);
            if ($ret !== TRUE) {
                result_log($dg_log_msg);
                ldap_unbind($dg_ldapid);
                header("HTTP/1.1 500 Internal Server Error");
                exit(1);
            }

            /* 作成したときは以下の条件 */
            $dg_authority = AUTHREADWRITE;
        }

    } elseif ($ret == FUNC_TRUE && $access_type != IPHONE) {
        /* リソースが存在していた & iPhoneからの接続ではない*/

        /* 属性名(全ての属性を取得) */
        $attrs = array();

        /* コレクション情報取得 */
        $ret = get_collection($dg_resource, $dg_collection, $attrs,
                              $collectiondata);
        if ($ret == FUNC_FALSE) {
            /* コレクションが存在しない */
            result_log($dg_log_msg);
            ldap_unbind($dg_ldapid);
            header("HTTP/1.1 404 Not Found");
            exit(1);
        } elseif ($ret == FUNC_SYSERR) {
            /* LDAP異常 */
            result_log($dg_log_msg);
            ldap_unbind($dg_ldapid);
            header("HTTP/1.1 500 Internal Server Error");
            exit(1);
        }

        /* アクティブフラグ確認 */
        if ($collectiondata[0][CALACTIVE][0] != COLLECTION_ACTIVE) {
            $dg_log_msg = "Collection is not active.(resource:$dg_resource, " .
                          "collection:$dg_collection)";
            result_log($dg_log_msg);
            ldap_unbind($dg_ldapid);
            header("HTTP/1.1 403 Forbidden");
            exit(1);
        }

        /* ユーザ権限の順序情報 */
	if (isset($collectiondata[0][CALAUTHORITYORDER][0]))  {
            $order = $collectiondata[0][CALAUTHORITYORDER][0];
	} else {
	    $order = "";
	}
        /* ユーザ権限の情報(配列を渡す) */
	if (isset($collectiondata[0][CALAUTHORITYARTICLE])) {
            $article = $collectiondata[0][CALAUTHORITYARTICLE];
	} else {
	    $article = "";
	}
        /* デフォルト権限 */
        $authdef = $collectiondata[0][CALAUTHORITYDEF][0];

        /* 権限確認 */
        $ret = check_authority_data($order, $article, $dg_user,
                                    $authdef, $dg_authority);
        if ($ret === FALSE) {
            /* 権限情報がおかしい */
            $dg_log_msg .= "(resource:$dg_resource, " .
                           "collection:$dg_collection)";
            result_log($dg_log_msg);
            ldap_unbind($dg_ldapid);
            header("HTTP/1.1 500 Internal Server Error");
            exit(1);
        }

        /* 権限情報確認 */
        if ($dg_authority != AUTHREADONLY &&
            $dg_authority != AUTHREADWRITE) {
            /* 読み取り・読み書きでない */
            $dg_log_msg = "Not permission.(resource:$dg_resource, " .
                          "collection:$dg_collection)";
            result_log($dg_log_msg);
            ldap_unbind($dg_ldapid);
            header("HTTP/1.1 403 Forbidden");
            exit(1);
        }
    }
}

/* バックエンド生成 */
/* openしたLDAPのLDAPリンクIDをバックエンドアブストラクトに登録 */
$calendarBackend = new Sabre_CalDAV_Backend_DGLDAP($dg_ldapid);
$principalBackend = new Sabre_DAVACL_IPrincipalBackend_DGLDAP();

$tree = array(
    new CalDAV\Principal\Collection($principalBackend),
    new CalDAV\CalendarRootNode($principalBackend, $calendarBackend, ""),
);

/* サーバとしての機能を生成する */
$server = new DAV\Server($tree);

/* プラグイン登録 */
/* LDAP認証方法*/
if ($calendar_conf["authldap"] == 1) {
    $authBackend = new Ldap_Auth($_SERVER['PHP_AUTH_USER'], $_SERVER['PHP_AUTH_PW']);

/* File認証方法*/
} else {
    $authBackend = new Auth\Backend\File($passfile);
}
$authPlugin = new Auth\Plugin($authBackend, $realm);
$server->addPlugin($authPlugin);

/* アクセス制御のためのプラグイン登録（実際は利用しない） */
$aclPlugin = new DAVACL\Plugin();
$aclPlugin->adminPrincipals[] = '{DAV:}all';
$server->addPlugin($aclPlugin);

/* サーバプラグイン生成 */
$caldavPlugin = new CalDAV\Plugin();
/* サーバプラグイン登録 */
$server->addPlugin($caldavPlugin);

// ブラウザを使ってアクセスできるようにするためのプラグイン登録 */
$browser = new DAV\Browser\Plugin();
$server->addPlugin($browser);

/* サーバ機能実行 */
$server->exec();
