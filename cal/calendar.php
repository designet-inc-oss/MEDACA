<?php

/***********************************************************
 * �������������ƥ��ѥᥤ�����
 *
 * $Id: calendar.php 7232 2013-07-29 06:27:29Z kien $
 * $Revision: 7232 $
 * $Date:: 2013-07-29 15:27:29 +0900#$
 **********************************************************/
use Sabre\CalDAV;
use Sabre\DAV;
use Sabre\DAV\Auth;
use Sabre\DAVACL;

/* �ѥ���ɥե�����̾ */
define("AUTHUSERFILE", "passwd");

/* �����ॾ�������� */
date_default_timezone_set('Asia/Tokyo');

/* �饤�֥���Ȥ߹��� */
require_once 'lib/Sabre/autoload.php';
require_once 'Dg_Common.php';
require_once 'Dg_LDAP.php';
require_once '../lib/libcalendar.php';
require_once '../lib/libclass.php';

/* �����Х��ѿ��ν���� */
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


/* ����ե������ɤ߹��� */
$ret = read_calendar_conf($calendar_conf);
if ($ret === FALSE) {
    result_log($dg_log_msg);
    header("HTTP/1.1 500 Internal Server Error");
    exit(1);
}



/* �ѥ���ɥե���������å� */
$passfile = BASEDIR . ETCDIR . AUTHUSERFILE;
if (DgCommon_is_readable_file($passfile) === FALSE) {
    result_log($dg_log_msg);
    header("HTTP/1.1 500 Internal Server Error");
    exit(1);
}

/* LDAPǧ����ˡ*/
if ($calendar_conf["authldap"] == 1) {
    /* ǧ�ڥ����å� */
    $ret = check_auth_basic();
    if ($ret === FALSE) {
        result_log($dg_log_msg);
        header('HTTP/1.1 401 Unauthorized');
        header('WWW-Authenticate: Basic realm="' . $realm . '"');
        exit(1);
    }

    /* �桼��̾��Ǽ */
    $dg_user = get_username_basic();
    if ($dg_user === FALSE) {
        result_log($dg_log_msg);
        header("HTTP/1.1 403 Forbidden");
        exit(1);
    }

/* Fileǧ����ˡ*/
} else {
    /* ǧ�ڥ����å� */
    $ret = check_auth_digest();
    if ($ret === FALSE) {
        result_log($dg_log_msg);
        header('HTTP/1.1 401 Unauthorized');
        header('WWW-Authenticate: Digest realm="' . $realm .
               '",qop="auth",nonce="' . uniqid() . '",opaque="' . md5($realm) . '"');
        exit(1);
    }

    /* �桼��̾��Ǽ */
    $dg_user = get_username();
    if ($dg_user === FALSE) {
        result_log($dg_log_msg);
        header("HTTP/1.1 403 Forbidden");
        exit(1);
    }
}

/* URL��ǧ */
$ret = check_url($dg_resource, $dg_collection);
if ($ret === FALSE) {
    result_log($dg_log_msg);
    header("HTTP/1.1 404 Not Found");
    exit(1);

/* check_url�����ｪλ���ĥ��쥯�����̾��̤����ξ��ϡ�
   iPhone����Υ��������Ȥ��ư��� */
} else if ($ret === TRUE && $dg_collection == "") {
    $access_type = IPHONE;
}

/* �꥽�����η��������å� */
$ret = check_resource_name($dg_resource);
if ($ret === FALSE) {
    result_log($dg_log_msg);
    header("HTTP/1.1 404 Not Found");
    exit(1);
}

/* OPTIONS,iPhone�λ��ϡ����쥯�����ξ�������Ǥ��ʤ� */
if ($_SERVER["REQUEST_METHOD"] != "OPTIONS" && $access_type != IPHONE) {
    /* ���쥯�����η��������å� */
    $ret = check_collection_name($dg_collection);
    if ($ret === FALSE) {
        result_log($dg_log_msg);
        header("HTTP/1.1 404 Not Found");
        exit(1);
    }
}

/* LDAP��³ */
$ret = ldap_connect_server($dg_ldapid);
if ($ret === FALSE) {
    result_log($dg_log_msg);
    header("HTTP/1.1 500 Internal Server Error");
    exit(1);
}

/* OPTIONS�λ��ϡ�LDAP�γ�ǧ�Ϥ��ʤ��Ƥ褤 */
if ($_SERVER["REQUEST_METHOD"] != "OPTIONS") {
    /* �꥽�����γ�ǧ */
    /* LDAP����꥽�����μ��� */
    $ret = get_resource($dg_ldapid, $dg_resource, $resourcedata);
    if ($ret == FUNC_SYSERR) {
        /* LDAP�۾� */
        result_log($dg_log_msg);
        ldap_unbind($dg_ldapid);
        header("HTTP/1.1 500 Internal Server Error");
        exit(1);
    } elseif ($ret == FUNC_FALSE) {
        /* �꥽���������Ĥ���ʤ��ä� -> ��ư�����ե饰��ǧ
           AUTOCREATE_ON -> ��ư���� , AUTOCREATE_OFF -> ���Τޤ� */
        if ($calendar_conf["autoresourcecreate"] == AUTOCREATE_ON) {
        
            /* �桼��̾�ȥ꥽����̾�����פ��Ƥ��뤫 */
            if (strcmp($dg_user, $dg_resource) != 0) {
                $dg_log_msg = "Cannot found resource.(resource:$dg_resource)";
                result_log($dg_log_msg);
                ldap_unbind($dg_ldapid);
                header("HTTP/1.1 404 Not Found");
                exit(1);
            } 

            /* iPhone����Ǥʤ��Ȥ������쥯�����̾��ǧ */
            if ($access_type != IPHONE && strcmp($dg_collection, 
                $calendar_conf["autocreatecollectionname"]) != 0) {
                $dg_log_msg = "Cannot found resource.(resource:$dg_resource)";
                result_log($dg_log_msg);
                ldap_unbind($dg_ldapid);
                header("HTTP/1.1 404 Not Found");
                exit(1);
            }

            /* �꥽�����ȥ��쥯���������� */
            $ret = create_resource_collection($dg_resource, $dg_user);
            if ($ret !== TRUE) {
                result_log($dg_log_msg);
                ldap_unbind($dg_ldapid);
                header("HTTP/1.1 500 Internal Server Error");
                exit(1);
            }

            /* ���������Ȥ��ϰʲ��ξ�� */
            $dg_authority = AUTHREADWRITE;
        }

    } elseif ($ret == FUNC_TRUE && $access_type != IPHONE) {
        /* �꥽������¸�ߤ��Ƥ��� & iPhone�������³�ǤϤʤ�*/

        /* °��̾(���Ƥ�°�������) */
        $attrs = array();

        /* ���쥯����������� */
        $ret = get_collection($dg_resource, $dg_collection, $attrs,
                              $collectiondata);
        if ($ret == FUNC_FALSE) {
            /* ���쥯�����¸�ߤ��ʤ� */
            result_log($dg_log_msg);
            ldap_unbind($dg_ldapid);
            header("HTTP/1.1 404 Not Found");
            exit(1);
        } elseif ($ret == FUNC_SYSERR) {
            /* LDAP�۾� */
            result_log($dg_log_msg);
            ldap_unbind($dg_ldapid);
            header("HTTP/1.1 500 Internal Server Error");
            exit(1);
        }

        /* �����ƥ��֥ե饰��ǧ */
        if ($collectiondata[0][CALACTIVE][0] != COLLECTION_ACTIVE) {
            $dg_log_msg = "Collection is not active.(resource:$dg_resource, " .
                          "collection:$dg_collection)";
            result_log($dg_log_msg);
            ldap_unbind($dg_ldapid);
            header("HTTP/1.1 403 Forbidden");
            exit(1);
        }

        /* �桼�����¤ν������ */
	if (isset($collectiondata[0][CALAUTHORITYORDER][0]))  {
            $order = $collectiondata[0][CALAUTHORITYORDER][0];
	} else {
	    $order = "";
	}
        /* �桼�����¤ξ���(������Ϥ�) */
	if (isset($collectiondata[0][CALAUTHORITYARTICLE])) {
            $article = $collectiondata[0][CALAUTHORITYARTICLE];
	} else {
	    $article = "";
	}
        /* �ǥե���ȸ��� */
        $authdef = $collectiondata[0][CALAUTHORITYDEF][0];

        /* ���³�ǧ */
        $ret = check_authority_data($order, $article, $dg_user,
                                    $authdef, $dg_authority);
        if ($ret === FALSE) {
            /* ���¾��󤬤������� */
            $dg_log_msg .= "(resource:$dg_resource, " .
                           "collection:$dg_collection)";
            result_log($dg_log_msg);
            ldap_unbind($dg_ldapid);
            header("HTTP/1.1 500 Internal Server Error");
            exit(1);
        }

        /* ���¾����ǧ */
        if ($dg_authority != AUTHREADONLY &&
            $dg_authority != AUTHREADWRITE) {
            /* �ɤ߼�ꡦ�ɤ߽񤭤Ǥʤ� */
            $dg_log_msg = "Not permission.(resource:$dg_resource, " .
                          "collection:$dg_collection)";
            result_log($dg_log_msg);
            ldap_unbind($dg_ldapid);
            header("HTTP/1.1 403 Forbidden");
            exit(1);
        }
    }
}

/* �Хå���������� */
/* open����LDAP��LDAP���ID��Хå�����ɥ��֥��ȥ饯�Ȥ���Ͽ */
$calendarBackend = new Sabre_CalDAV_Backend_DGLDAP($dg_ldapid);
$principalBackend = new Sabre_DAVACL_IPrincipalBackend_DGLDAP();

$tree = array(
    new CalDAV\Principal\Collection($principalBackend),
    new CalDAV\CalendarRootNode($principalBackend, $calendarBackend, ""),
);

/* �����ФȤ��Ƥε�ǽ���������� */
$server = new DAV\Server($tree);

/* �ץ饰������Ͽ */
/* LDAPǧ����ˡ*/
if ($calendar_conf["authldap"] == 1) {
    $authBackend = new Ldap_Auth($_SERVER['PHP_AUTH_USER'], $_SERVER['PHP_AUTH_PW']);

/* Fileǧ����ˡ*/
} else {
    $authBackend = new Auth\Backend\File($passfile);
}
$authPlugin = new Auth\Plugin($authBackend, $realm);
$server->addPlugin($authPlugin);

/* ������������Τ���Υץ饰������Ͽ�ʼºݤ����Ѥ��ʤ��� */
$aclPlugin = new DAVACL\Plugin();
$aclPlugin->adminPrincipals[] = '{DAV:}all';
$server->addPlugin($aclPlugin);

/* �����Хץ饰�������� */
$caldavPlugin = new CalDAV\Plugin();
/* �����Хץ饰������Ͽ */
$server->addPlugin($caldavPlugin);

// �֥饦����Ȥäƥ��������Ǥ���褦�ˤ��뤿��Υץ饰������Ͽ */
$browser = new DAV\Browser\Plugin();
$server->addPlugin($browser);

/* �����е�ǽ�¹� */
$server->exec();
