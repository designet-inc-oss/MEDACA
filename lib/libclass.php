<?php

/***********************************************************
 * カレンダーシステム用ライブラリ
 *
 * $Id: libclass.php 7234 2013-07-29 06:37:53Z kien $
 * $Revision: 7234 $
 * $Date:: 2013-07-29 15:37:53 +0900#$
 **********************************************************/
use Sabre\DAV;
use Sabre\DAV\Exception;
use Sabre\CalDAV;
use Sabre\CalDAV\Backend;
use Sabre\CalDAV\Property;
use Sabre\DAVACL\PrincipalBackend;
use Sabre\HTTP;
use Sabre\HTTP\AbstractAuth;
use Sabre\DAV\Auth\Backend\AbstractBasic;

/*********************************************************
 * Sabre_CalDAV_Backend_DGLDAP
 *
 * LDAPカレンダー用のSabreDAVバックエンドアブストラクト
 * (Sabre\CalDAV\Backend\AbstractBackendを継承して作成)
 *
 * [引数]
 *       なし
 **********************************************************/
class Sabre_CalDAV_Backend_DGLDAP extends Backend\AbstractBackend {

    /* LDAPリンクID:LDAPオープンに成功した場合に値を格納する */
    protected $ldapid;

    /*********************************************************
     * getCalendarsForUser()
     *
     * 初期処理
     *
     * [引数]
     *       $principalUri  URI情報(リソース名)
     * [返り値]
     *       値が格納された配列           正常
     *       空の配列                     異常
     **********************************************************/
    public function getCalendarsForUser($principalUri)
    {
        global $dg_log_msg;
        global $dg_resource;
        global $dg_collection;
        global $access_type;
        global $ldap_collection_data;

        /* クライアントタイプ 確認 */
        if ($access_type == LIGHTNING) {

            /* 属性名(CTAGのみ) */
            $attrs = array(CALCTAG);

            /* LDAPからコレクション情報を取得 */
            $ret = get_collection($dg_resource, $dg_collection, $attrs, $data);
            if ($ret != FUNC_TRUE) {
                result_log($dg_log_msg);
                return array();
            }

            /* CTag情報を変数に格納 */
            $ctag = $data[0][CALCTAG][0];

            /* 応答する情報を作成する */
            $components = array(CALDAV_VEVENT, CALDAV_VTODO);

            $ret = array();
            $ret[0] = array(
                CALDAV_ID           => CALDAV_CALENDARID_DEF,
                CALDAV_URI          => "$dg_collection",
                CALDAV_PRINCIPALURI => "$dg_resource",
                '{' . CalDAV\Plugin::NS_CALENDARSERVER . '}getctag' => "$ctag",
                '{' . CalDAV\Plugin::NS_CALDAV . '}supported-calendar-component-set' => new Property\SupportedCalendarComponentSet($components),
                           );
        /* iPhone 処理 */
        } else if ($access_type == IPHONE) {

            /* 検索フィルタ */
            $filter = "(&(" . OBJECTCLASS . "=" .  OBJNAME_CALCOLLECTION . ")(" .
                      CALACTIVE . "=" . COLLECTION_ACTIVE . "))";

             /* 属性名 */
             $attrs = array(CALCOLLECTION, CALCTAG, COLLECTIONNUMBER,
                            COLLECTIONDESCRIPTION, CALAUTHORITYDEF, 
                            CALAUTHORITYORDER, CALAUTHORITYARTICLE);

            /* LDAPからコレクション情報を取得 */
            $ret = get_collection_principals($dg_resource, $filter, $attrs, $data);
            /* 該当コレクションがなかったとき */
            if ($ret == FUNC_FALSE) {
                $dg_log_msg = "Cannot Find Active Collection.(resource:" .
                              $dg_resource . ")";
                result_log($dg_log_msg);
                return array();
            /* コレクション情報の取得に失敗したとき */
            } else if ($ret != FUNC_TRUE) {
                result_log($dg_log_msg);
                return array();
            }

            $ret = array();
            foreach($data as $one_data) {

                /* 情報を変数に格納 */
                $collection_name = $one_data[CALCOLLECTION][0];
                $ctag            = $one_data[CALCTAG][0];
                $cnumber         = $one_data[COLLECTIONNUMBER][0];
                $cdescription    = $one_data[COLLECTIONDESCRIPTION][0];

                /* 応答する情報を作成する */
                $components = array(CALDAV_VEVENT, CALDAV_VTODO);

                $ret[] = array(
                    CALDAV_ID           => "$cnumber",
                    CALDAV_URI          => "$collection_name",
                    CALDAV_PRINCIPALURI => "$dg_resource",
                    '{' . CalDAV\Plugin::NS_CALENDARSERVER . '}getctag' => "$ctag",
                    '{' . CalDAV\Plugin::NS_CALDAV . '}supported-calendar-component-set' => new Property\SupportedCalendarComponentSet($components),
                "{DAV:}displayname"     => $cdescription,
                "{urn:ietf:params:xml:ns:caldav}calendar-description"=> "",
                "{urn:ietf:params:xml:ns:caldav}calendar-timezone"=> NULL,
                "{http://apple.com/ns/ical/}calendar-order"=> NULL,
                "{http://apple.com/ns/ical/}calendar-color"=> NULL
                           );
            }
        }
        /* コレクションデータ格納 */
        $ldap_collection_data = $data;
        return $ret;
    }

    /*********************************************************
     * createCalendar()
     *
     * カレンダーの生成
     *
     * [引数]
     *       $principalUri  URI情報(リソース名)
     *       $calendarUri   URI情報(コレクション名)
     *       $properties    プロパティ
     * [返り値]
     *       TRUE           正常
     **********************************************************/
    public function createCalendar($principalUri,$calendarUri,array $properties)
    {
        return TRUE;
    }

    /*********************************************************
     * updateCalendar()
     *
     * カレンダーの変更
     *
     * [引数]
     *       $calendarId    カレンダーID
     *       $properties    プロパティ
     * [返り値]
     *       TRUE            正常
     **********************************************************/
    public function updateCalendar($calendarId, array $properties)
    {
        return TRUE;
    }

    /*********************************************************
     * deleteCalendar()
     *
     * カレンダーの削除
     *
     * [引数]
     *       $calendarId    カレンダーID
     * [返り値]
     *       TRUE           正常
     **********************************************************/
    public function deleteCalendar($calendarId)
    {
        return TRUE;
    }

    /*********************************************************
     * getCalendarObjects()
     *
     * カレンダー情報の応答(複数)
     *
     * [引数]
     *       $calendarId    カレンダーID
     * [返り値]
     *       $objects       オブジェクトの配列
     *       (応答しない)   異常(Exceptionで終了)
     **********************************************************/
    public function getCalendarObjects($calendarId)
    {
        global $dg_log_msg;
        global $calendar_conf;
        global $dg_resource;
        global $dg_collection;
        global $dg_ldapid;
        global $access_type;
        global $dg_user;
        global $ldap_collection_data;

        $ldapdata = array();
        $objects = array();
        $collection_name = $dg_collection;

        /* iPhoneのときは、禁止コレクションは無視する */
        if ($access_type == IPHONE) {

            /* コレクション権限取得 */
            $ret = check_collection_authority($calendarId, $colname, $dg_authority);
            if ($ret === FALSE) {
                result_log($dg_log_msg);
                throw new Exception("Cannot get collection authority." .
                                    "(resource:$dg_resource, " . 
                                    "collection:$colname)");
            }

            /* 権限確認:読書き or 読み込みのみだったらOK */
            if ($dg_authority != AUTHREADONLY && $dg_authority != AUTHREADWRITE) {
                result_log($dg_log_msg);
                throw new Exception("Not Permission." .
                                    "(resource:$dg_resource, " . 
                                    "collection:$colname)");
            }

            /* コレクション名 */
            $collection_name = $colname;
        }

        /* LDAPから指定のリソース・コレクションの
           全てのカレンダー情報を取得する */
        $ret = search_all_calendar($dg_resource, $collection_name, $ldapdata);
        if ($ret === FALSE) {
            result_log($dg_log_msg);
            throw new Exception("Cannot get calendar objects." .
                                "(resource:$dg_resource, " .
                                "collection:$collection_name)");
        }

        /* カレンダーが存在していたか確認 */
        if (count($ldapdata) == 0) {
            /* カレンダー情報が一つもない */
            return array();
        }

        /* 応答するための形式に変換する */
        $objects = createReturnCalendarObject($ldapdata, RETTYPE_MANY);

        return $objects;
    }

    /*********************************************************
     * getCalendarObject()
     *
     * カレンダー情報の応答(単一)
     $*
     * [引数]
     *       $calendarId    カレンダーID
     *       $objectUri     カレンダーオブジェクトID
     * [返り値]
     *       $objects       オブジェクトの配列
     *       (応答しない)   異常(Exceptionで終了)
     **********************************************************/
    public function getCalendarObject($calendarId, $objectUri)
    {
        global $dg_log_msg;
        global $calendar_conf;
        global $dg_resource;
        global $dg_collection;
        global $dg_ldapid;
        global $access_type;
        global $dg_user;
        global $ldap_collection_data;

        $ldapdata = array();
        $object = array();
        $collection_name = $dg_collection;

        /* iPhoneのときは、禁止コレクションは無視する */
        if ($access_type == IPHONE) {

            /* コレクション権限取得 */
            $ret = check_collection_authority($calendarId, $colname, $dg_authority);
            if ($ret === FALSE) {
                result_log($dg_log_msg);
                throw new Exception("Cannot get collection authority." .
                                    "(resource:$dg_resource, " .
                                    "collection:$colname)");
            }

            /* 権限確認 */
            if ($dg_authority != AUTHREADONLY && $dg_authority != AUTHREADWRITE) {
                result_log($dg_log_msg);
                throw new Exception("Not Permission." .
                                    "(resource:$dg_resource, " .
                                    "collection:$colname)");
            }

            /* コレクション名 */
            $collection_name = $colname;
        }

        /* LDAPから指定のリソース・コレクションの
           カレンダー情報を取得する */
        $ret = search_calendar($objectUri, $dg_resource,
                               $collection_name, $ldapdata);
        /* カレンダー情報を一つ取得する */
        if ($ret === FALSE) {
            result_log($dg_log_msg);
            throw new Exception("Cannot get calendar object." .
                                "(resource:$dg_resource, " .
                                "collection:$collection_name)");
        }

        /* カレンダーが存在していたか確認 */
        if (count($ldapdata) == 0) {
            /* カレンダー情報がない */
            return array();
        }

        /* ldapdataに要素を追加する */
        $ldapdata[0][CALOBJURI][0] = $objectUri;

        /* 応答するための形式に変換する */
        $object = createReturnCalendarObject($ldapdata, RETTYPE_ONE);

        return $object;
    }

    /*********************************************************
     * createCalendarObject()
     *
     * カレンダー情報の追加
     *
     * [引数]
     *       $calendarId    カレンダーID
     *       $objectUri     カレンダーオブジェクトID
     *       $calendarData  カレンダーデータ
     * [返り値]
     *       TRUE           正常
     *       (応答しない)   異常(Exceptionで終了)
     **********************************************************/
    public function createCalendarObject($calendarId, $objectUri, $calendarData)
    {
        global $dg_log_msg;
        global $dg_authority;
        global $dg_resource;
        global $dg_collection;
        global $access_type;
        global $dg_user;
        global $ldap_collection_data;

        $authority = $dg_authority;
        $collection_name = $dg_collection;

        /* iPhoneのときは、禁止コレクションは無視する */
        if ($access_type == IPHONE) {

            /* コレクション権限取得 */
            $ret = check_collection_authority($calendarId, $colname, $tmp_authority);
            if ($ret === FALSE) {
                result_log($dg_log_msg);
                throw new Exception("Cannot get collection authority." .
                                    "(resource:$dg_resource, " .
                                    "collection:$colname)");
            }
            /* コレクション名 */
            $collection_name = $colname;

            /* コレクション権限 */
 	    $authority = $tmp_authority;
        }

        /* 権限確認:読書きだったらOK */
        if ($authority != AUTHREADWRITE) {
            $dg_log_msg = "Not permission.(resource:$dg_resource, " .
                          "collection:$collection_name)";
            result_log($dg_log_msg);
            throw new Exception($dg_log_msg);
        }

        /* 属性名(CTAGのみ) */
        $attrs = array(CALCTAG);

        /* コレクション情報取得 */
        $ret = get_collection($dg_resource, $collection_name, $attrs, $data);
        if ($ret != FUNC_TRUE) {
            result_log($dg_log_msg);
            throw new Exception("Cannot get collection." .
                                "(resource:$dg_resource, " .
                                "collection:$collection_name)");
        }

        /* Ctagの値を保持 */
        $ctag = $data[0][CALCTAG][0];
        
        /* LDAPに登録を行う */
        /* URI情報 */
        $caldata[CALOBJURI] = $objectUri;
        /* カレンダーデータ */
        $caldata[CALOBJDATA] = $calendarData;
        /* 更新日時 */
        $caldata[CALMODTIME] = time();
        /* オブジェクトクラス */
        $caldata[OBJECTCLASS] = OBJNAME_CALDATA;

        /* LDAPに予定・TODOを追加 */
        $ret = ldap_calendar_add($dg_resource, $collection_name,
                                 $objectUri, $caldata);
        if($ret === FALSE) {
            result_log($dg_log_msg);
            throw new Exception("Cannot add calendar data." .
                                "(resource:$dg_resource, " .
                                "collection:$collection_name");
        }

        /* カレンダーを更新したらCTagをインクリメントする */
        $ctag = $ctag + 1;

        /* コレクションのCTag情報を更新する */
        $ret = ldap_collection_ctag_update($dg_resource, $collection_name, $ctag);
        if ($ret === FALSE) {
            /* CTag情報更新失敗ログを一時領域に保存 */
            $tmp_log_msg = $dg_log_msg;
            /* 初期化 */
            $dg_log_msg = "";

            /* Ctagの更新に失敗した場合、切り戻しを行う */
            /* 登録したカレンダーデータを削除する */
            $ret = ldap_calendar_del($dg_resource, $collection_name, $objectUri);
            if($ret === FALSE) {
                /* 失敗したログを結合して出力する */
                $dg_log_msg = $tmp_log_msg . ", " . $dg_log_msg;
            } else {
                /* CTag情報更新失敗のログだけ出力する */
                $dg_log_msg = $tmp_log_msg;
            }

            result_log($dg_log_msg);

            throw new Exception("Cannot add calendar data." .
                                "(resource:$dg_resource, " .
                                "collection:$collection_name");
        }
    
        return TRUE;
    }

    /*********************************************************
     * updateCalendarObject()
     *
     * カレンダーオブジェクト変更
     *
     * [引数]
     *       $calendarId    カレンダーID
     *       $objectUri     カレンダーオブジェクトID
     *       $calendarData  カレンダーデータ
     * [返り値]
     *       TRUE           正常
     *       (応答しない)   異常(Exceptionで終了)
     **********************************************************/
    public function updateCalendarObject($calendarId, $objectUri, $calendarData)
    {
        global $dg_log_msg;
        global $dg_authority;
        global $dg_resource;
        global $dg_collection;
        global $access_type;
        global $dg_user;
        global $ldap_collection_data;

        $authority = $dg_authority;
        $collection_name = $dg_collection;

        /* iPhoneのときは、禁止コレクションは無視する */
        if ($access_type == IPHONE) {

            /* コレクション権限取得 */
            $ret = check_collection_authority($calendarId, $colname, $tmp_authority);
            if ($ret === FALSE) {
                result_log($dg_log_msg);
                throw new Exception("Cannot get collection authority." .
                                    "(resource:$dg_resource, " .
                                    "collection:$colname)");
            }
            /* コレクション名 */
            $collection_name = $colname;

            /* コレクション権限 */
            $authority = $tmp_authority;
        }

        /* 権限確認:読書きだったらOK */
        if ($dg_authority != AUTHREADWRITE) {
            $dg_log_msg = "Not permission.(resource:$dg_resource," .
                          "collection:$collection_name)";
            result_log($dg_log_msg);
            throw new Exception($dg_log_msg);
        }

        /* 属性名(CTAGのみ) */
        $attrs = array(CALCTAG);

        /* コレクション情報取得 */
        $ret = get_collection($dg_resource, $collection_name, $attrs, $data);
        if ($ret != FUNC_TRUE) {
            result_log($dg_log_msg);
            throw new Exception("Cannot get collection." .
                                "(resource:$dg_resource, " .
                                "collection:$collection_name)");
        }

        /* Ctagの値を保持 */
        $ctag = $data[0][CALCTAG][0];

        /* LDAPからカレンダーデータの情報取得 */
        /* 切り戻し用の情報 */
        $ret = search_calendar($objectUri,
                               $dg_resource, $collection_name, $ldapdata);
        if ($ret === FALSE) {
            result_log($dg_log_msg);
            throw new Exception("Cannot get calendar data." .
                                "(resource:$dg_resource, " .
                                "collection:$collection_name, " .
                                          "uri:$objectUri)");
        }

        /* カレンダーが存在していたか確認 */
        if (count($ldapdata) == 0) {
            /* カレンダー情報が一つもない */
            result_log($dg_log_msg);
            throw new Exception("Cannot found calendar data." .
                                "(resource:$dg_resource, " .
                                "collection:$collection_name, " .
                                          "uri:$objectUri)");
        }
        
        /* LDAPの更新を行う */
        /* カレンダーデータ */
        $caldata[CALOBJDATA] = $calendarData;
        /* 更新時間 */
        $caldata[CALMODTIME] = time();

        /* LDAPの予定・TODOを変更 */
        $ret = ldap_calendar_mod($dg_resource, $collection_name,
                                     $objectUri, $caldata);
        if($ret === FALSE) {
            result_log($dg_log_msg);
            throw new Exception("Cannot mod calendar data." .
                                "(resource:$dg_resource, " .
                                "collection:$collection_name, " .
                                          "uri:$objectUri)");
        }

        /* カレンダーを更新したらCTagをインクリメントする */
        $ctag = $ctag + 1;

        /* コレクションのCTag情報を更新する */
        $ret = ldap_collection_ctag_update($dg_resource, $collection_name, $ctag);
        if ($ret === FALSE) {
            /* CTag情報更新失敗ログを一時領域に保存 */
            $tmp_log_msg = $dg_log_msg;
            /* 初期化 */
            $dg_log_msg = "";

            /* Ctagの更新に失敗した場合、切り戻しを行う */
            $caldata = array();
            /* 変更前の情報に直す */
            $caldata[CALOBJDATA] = $ldapdata[0][CALOBJDATA][0];
            /* 更新時間 */
            $caldata[CALMODTIME] = $ldapdata[0][CALMODTIME][0];

            /* LDAPのカレンダー更新 */
            $ret = ldap_calendar_mod($dg_resource, $collection_name,
                                     $objectUri, $caldata);
            if($ret === FALSE) {
                /* 失敗したログを結合して出力する */
                $dg_log_msg = $tmp_log_msg . ", " . $dg_log_msg;
            } else {
                /* CTag情報更新失敗のログだけ出力する */
                $dg_log_msg = $tmp_log_msg;
            }
            result_log($dg_log_msg);

            throw new Exception("Cannot mod calendar data." .
                                "(resource:$dg_resource, " .
                                "collection:$collection_name, " .
                                "uri:$objectUri)");
        }

        return TRUE;
    }

    /*********************************************************
     * deleteCalendarObject()
     *
     * カレンダーオブジェクト削除
     *
     * [引数]
     *       $calendarId    カレンダーID
     *       $objectUri     カレンダーオブジェクトID
     * [返り値]
     *       TRUE           正常
     *       FALSE          異常
     **********************************************************/
    public function deleteCalendarObject($calendarId, $objectUri)
    {
        global $dg_log_msg;
        global $dg_authority;
        global $dg_resource;
        global $dg_collection;
        global $access_type;
        global $dg_user;
        global $ldap_collection_data;

        $authority = $dg_authority;
        $collection_name = $dg_collection;

        /* iPhoneのときは、禁止コレクションは無視する */
        if ($access_type == IPHONE) {

            /* コレクション権限取得 */
            $ret = check_collection_authority($calendarId, $colname, $tmp_authority);
            if ($ret === FALSE) {
                result_log($dg_log_msg);
                throw new Exception("Cannot get collection authority." .
                                    "(resource:$dg_resource, " .
                                    "collection:$colname)");
            }
            /* コレクション名 */
            $collection_name = $colname;

            /* コレクション権限 */
            $authority = $tmp_authority;
        }

        /* 権限確認:読書きだったらOK */
        if ($dg_authority != AUTHREADWRITE) {
            $dg_log_msg = "Not permission.(resource:$dg_resource," .
                          "collection:$collection_name)";
            result_log($dg_log_msg);
            throw new Exception($dg_log_msg);
        }

        /* 属性名(CTAGのみ) */
        $attrs = array(CALCTAG);

        /* コレクション情報取得 */
        $ret = get_collection($dg_resource, $collection_name, $attrs, $data);
        if ($ret != FUNC_TRUE) {
            result_log($dg_log_msg);
            throw new Exception("Cannot get collection." .
                                "(resource:$dg_resource, " .
                                "collection:$collection_name)");
        }

        /* Ctagの値を保持 */
        $ctag = $data[0][CALCTAG][0];

        /* LDAPからカレンダーデータの情報取得 */
        /* 切り戻し用の情報 */
        $ret = search_calendar($objectUri,
                               $dg_resource, $collection_name, $ldapdata);
        if ($ret === FALSE) {
            result_log($dg_log_msg);
            throw new Exception("Cannot get calendar data." .
                                "(resource:$dg_resource, " .
                                "collection:$collection_name, " .
                                          "uri:$objectUri)");
        }

        /* カレンダーが存在していたか確認 */
        if (count($ldapdata) == 0) {
            /* カレンダー情報が一つもない */
            $dg_log_msg = "Cannot found calendar data." .
                          "(resource:$dg_resource, " .
                          "collection:$collection_name, " .
                          "uri:$objectUri)";
            result_log($dg_log_msg);
            /* 削除済みなので、何も処理しない */
            return TRUE;
        }
        
        /* LDAPの削除を行う */
        $ret = ldap_calendar_del($dg_resource, $collection_name, $objectUri);
        if($ret === FALSE) {
            result_log($dg_log_msg);
            throw new Exception("Cannot del calendar data." .
                                "(resource:$dg_resource, " .
                                "collection:$collection_name, " .
                                          "uri:$objectUri)");
        }

        /* カレンダーを更新したらCTagをインクリメントする */
        $ctag = $ctag + 1;

        /* コレクションのCtag情報を更新する */
        $ret = ldap_collection_ctag_update($dg_resource, $collection_name, $ctag);
        if ($ret === FALSE) {
            /* CTag情報更新失敗ログを一時領域に保存 */
            $tmp_log_msg = $dg_log_msg;
            /* 初期化 */
            $dg_log_msg = "";

            /* Ctagの更新に失敗した場合、切り戻しを行う */
            $caldata = array();
            /* 削除前の情報を登録する */
            /* URI情報 */
            $caldata[CALOBJURI] = $objectUri;
            /* カレンダーデータ */
            $caldata[CALOBJDATA] = $ldapdata[0][CALOBJDATA][0];
            /* 更新時間 */
            $caldata[CALMODTIME] = $ldapdata[0][CALMODTIME][0];
            /* オブジェクトクラス */
            $caldata[OBJECTCLASS] = OBJNAME_CALDATA;

            /* LDAPに追加 */
            $ret = ldap_calendar_add($dg_resource, $collection_name,
                                     $objectUri, $caldata);
            if($ret === FALSE) {
                /* 失敗したログを結合して出力する */
                $dg_log_msg = $tmp_log_msg . ", " . $dg_log_msg;
            } else {
                /* CTag情報更新失敗のログだけ出力する */
                $dg_log_msg = $tmp_log_msg;
            }
            result_log($dg_log_msg);

            throw new Exception("Cannot del calendar data." .
                                "(resource:$dg_resource, " .
                                "collection:$collection_name, " .
                                "uri:$objectUri)");
        }

        return TRUE;
    }

    /*********************************************************
     * __construct()
     *
     * コンストラクタ
     *
     * [引数]
     *       なし
     * [返り値]
     *       なし
     **********************************************************/
    public function __construct($id) {
        $this->ldapid = $id;
    }

    /*********************************************************
     * __destruct()
     *
     * デストラクタ
     *
     * [引数]
     *       なし
     * [返り値]
     *       なし
     **********************************************************/
    public function __destruct() {
        ldap_unbind($this->ldapid);
    }
}

/*********************************************************
 * Sabre_DAVACL_IPrincipalBackend_DGLDAP
 *
 * LDAPカレンダー用のプリンシパルのバックエンド
 * (Sabre\DAVACL\PrincipalBackend\AbstractBackendを継承して作成)
 *
 * [引数]
 *       なし
 **********************************************************/
class Sabre_DAVACL_IPrincipalBackend_DGLDAP extends PrincipalBackend\AbstractBackend {

    /*********************************************************
     * getPrincipalsByPrefix()
     *
     * プレフィックスを応答する
     *
     * [引数]
     *       $prefixPath  プレフィックス
     * [返り値]
     *       (空の配列)   正常
     **********************************************************/
    function getPrincipalsByPrefix($prefixPath)
    {
        $tmp[] = array();
        return $tmp;
    }

    /*********************************************************
     * getPrincipalByPath()
     *
     * プリンシパルのパスを応答する
     *
     * [引数]
     *       $path        パス
     * [返り値]
     *       (配列)       正常
     **********************************************************/
    function getPrincipalByPath($path)
    {
        $tmp = array(CALDAV_ID  => CALDAV_CALENDARID_DEF,
                     CALDAV_URI => $path);
        return $tmp;
    }

    /*********************************************************
     * getGroupMembership()
     *
     * メンバーのグループを応答する
     *
     * [引数]
     *       $principal   プリンシパル
     * [返り値]
     *       (配列)       正常
     **********************************************************/
    function getGroupMembership($principal)
    {
        return array();
    }

    /*********************************************************
     * getGroupMemberSet()
     *
     * プリンシパルのメンバーグループを取得
     *
     * [引数]
     *       $principal   プリンシパル
     * [返り値]
     *       なし
     **********************************************************/
    function getGroupMemberSet($principal)
    {
    }

    /*********************************************************
     * setGroupMemberSet()
     *
     * プリンシパルのメンバーグループを設定
     *
     * [引数]
     *       $principal   プリンシパル
     *       $members     メンバー
     * [返り値]
     *       なし
     **********************************************************/
    function setGroupMemberSet($principal, array $members)
    {
    }

    /*********************************************************
     * updatePrincipal()
     *
     * プリンシパル情報を更新する
     *
     * [引数]
     *       $principal   プリンシパル
     *       $members     メンバー
     * [返り値]
     *       TRUE           正常
     **********************************************************/
    function updatePrincipal($path, $mutations)
    {
        return TRUE;
    }

    /*********************************************************
     * searchPrincipals()
     *
     * 引数で渡された条件（表示名orMailAddress）でプリンシパルを検索する
     *
     * [引数]
     *       $principal   プリンシパル
     *       $members     メンバー
     * [返り値]
     *       TRUE           正常
     **********************************************************/
     function searchPrincipals($prefixPath, array $searchProperties)
     {
        return TRUE;
     }
}

/*********************************************************
 * Ldap_Auth
 *
 * LDAPカレンダー用のプリンシパルのバックエンド
 *
 * [引数]
 *       なし
 **********************************************************/
class Ldap_Auth extends AbstractBasic {

    /* ログインしてユーザIDを保持する変数*/
    protected $currentUser;
    protected $user_info;

    /*********************************************************
     * __construct()
     *
     * コンストラクタ
     *
     * [引数]
     *       なし
     * [返り値]
     *       なし
     **********************************************************/
    public function __construct($userid, $passwd) {
        $this->currentUser = "";
        $this->user_info = array($userid, $passwd);
    }

    /*********************************************************
     * authenticate()
     *
     * Authサーバに接続して現在のユーザを認証
     *
     * [引数]
     *       $server
     *       $realm
     * [返り値]
     *       TRUE           正常(認証成功)
     *       (認証失敗)     異常(Exceptionで終了)
     **********************************************************/
    public function authenticate(DAV\Server $server, $realm) {

        $auth = new HTTP\BasicAuth();

        /* ユーザIDとパスワードを取得d*
        if (($this->user_info[0] == "") || ($this->user_info[1] == "")) {
            $auth->requireLogin();
            throw new DAV\Exception\No$dg_ldapidtAuthenticated('No basic authentication headers were found');
        }

        /* ユーザ認証*/
        if ($this->validateUserPass($this->user_info[0], $this->user_info[1]) === FALSE) {
            $auth->requireLogin();
            throw new DAV\Exception\NotAuthenticated('Incorrect username');
        }

        /* カレントユーザ保持*/
        $this->currentUser = $this->user_info[0];
        return TRUE;

    }

    /*********************************************************
     * validateUserPass()
     *
     * Authサーバに接続して現在のユーザを認証
     *
     * [引数]
     *       $userid        BASICユーザID
     *       $password      BASICパスワード
     * [返り値]
     *       TRUE           正常(認証成功)
     *       FALSE          異常(認証失敗)
     **********************************************************/
    protected function validateUserPass($userid, $password){
        return ldap_bind_user($userid, $password);
    }

}

?>
