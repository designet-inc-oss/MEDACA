<?php

/***********************************************************
 * �������������ƥ��ѥ饤�֥��
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
 * LDAP���������Ѥ�SabreDAV�Хå�����ɥ��֥��ȥ饯��
 * (Sabre\CalDAV\Backend\AbstractBackend��Ѿ����ƺ���)
 *
 * [����]
 *       �ʤ�
 **********************************************************/
class Sabre_CalDAV_Backend_DGLDAP extends Backend\AbstractBackend {

    /* LDAP���ID:LDAP�����ץ���������������ͤ��Ǽ���� */
    protected $ldapid;

    /*********************************************************
     * getCalendarsForUser()
     *
     * �������
     *
     * [����]
     *       $principalUri  URI����(�꥽����̾)
     * [�֤���]
     *       �ͤ���Ǽ���줿����           ����
     *       ��������                     �۾�
     **********************************************************/
    public function getCalendarsForUser($principalUri)
    {
        global $dg_log_msg;
        global $dg_resource;
        global $dg_collection;
        global $access_type;
        global $ldap_collection_data;

        /* ���饤����ȥ����� ��ǧ */
        if ($access_type == LIGHTNING) {

            /* °��̾(CTAG�Τ�) */
            $attrs = array(CALCTAG);

            /* LDAP���饳�쥯������������ */
            $ret = get_collection($dg_resource, $dg_collection, $attrs, $data);
            if ($ret != FUNC_TRUE) {
                result_log($dg_log_msg);
                return array();
            }

            /* CTag������ѿ��˳�Ǽ */
            $ctag = $data[0][CALCTAG][0];

            /* ������������������� */
            $components = array(CALDAV_VEVENT, CALDAV_VTODO);

            $ret = array();
            $ret[0] = array(
                CALDAV_ID           => CALDAV_CALENDARID_DEF,
                CALDAV_URI          => "$dg_collection",
                CALDAV_PRINCIPALURI => "$dg_resource",
                '{' . CalDAV\Plugin::NS_CALENDARSERVER . '}getctag' => "$ctag",
                '{' . CalDAV\Plugin::NS_CALDAV . '}supported-calendar-component-set' => new Property\SupportedCalendarComponentSet($components),
                           );
        /* iPhone ���� */
        } else if ($access_type == IPHONE) {

            /* �����ե��륿 */
            $filter = "(&(" . OBJECTCLASS . "=" .  OBJNAME_CALCOLLECTION . ")(" .
                      CALACTIVE . "=" . COLLECTION_ACTIVE . "))";

             /* °��̾ */
             $attrs = array(CALCOLLECTION, CALCTAG, COLLECTIONNUMBER,
                            COLLECTIONDESCRIPTION, CALAUTHORITYDEF, 
                            CALAUTHORITYORDER, CALAUTHORITYARTICLE);

            /* LDAP���饳�쥯������������ */
            $ret = get_collection_principals($dg_resource, $filter, $attrs, $data);
            /* �������쥯����󤬤ʤ��ä��Ȥ� */
            if ($ret == FUNC_FALSE) {
                $dg_log_msg = "Cannot Find Active Collection.(resource:" .
                              $dg_resource . ")";
                result_log($dg_log_msg);
                return array();
            /* ���쥯��������μ����˼��Ԥ����Ȥ� */
            } else if ($ret != FUNC_TRUE) {
                result_log($dg_log_msg);
                return array();
            }

            $ret = array();
            foreach($data as $one_data) {

                /* ������ѿ��˳�Ǽ */
                $collection_name = $one_data[CALCOLLECTION][0];
                $ctag            = $one_data[CALCTAG][0];
                $cnumber         = $one_data[COLLECTIONNUMBER][0];
                $cdescription    = $one_data[COLLECTIONDESCRIPTION][0];

                /* ������������������� */
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
        /* ���쥯�����ǡ�����Ǽ */
        $ldap_collection_data = $data;
        return $ret;
    }

    /*********************************************************
     * createCalendar()
     *
     * ��������������
     *
     * [����]
     *       $principalUri  URI����(�꥽����̾)
     *       $calendarUri   URI����(���쥯�����̾)
     *       $properties    �ץ�ѥƥ�
     * [�֤���]
     *       TRUE           ����
     **********************************************************/
    public function createCalendar($principalUri,$calendarUri,array $properties)
    {
        return TRUE;
    }

    /*********************************************************
     * updateCalendar()
     *
     * �����������ѹ�
     *
     * [����]
     *       $calendarId    ��������ID
     *       $properties    �ץ�ѥƥ�
     * [�֤���]
     *       TRUE            ����
     **********************************************************/
    public function updateCalendar($calendarId, array $properties)
    {
        return TRUE;
    }

    /*********************************************************
     * deleteCalendar()
     *
     * ���������κ��
     *
     * [����]
     *       $calendarId    ��������ID
     * [�֤���]
     *       TRUE           ����
     **********************************************************/
    public function deleteCalendar($calendarId)
    {
        return TRUE;
    }

    /*********************************************************
     * getCalendarObjects()
     *
     * ������������α���(ʣ��)
     *
     * [����]
     *       $calendarId    ��������ID
     * [�֤���]
     *       $objects       ���֥������Ȥ�����
     *       (�������ʤ�)   �۾�(Exception�ǽ�λ)
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

        /* iPhone�ΤȤ��ϡ��ػߥ��쥯������̵�뤹�� */
        if ($access_type == IPHONE) {

            /* ���쥯����󸢸¼��� */
            $ret = check_collection_authority($calendarId, $colname, $dg_authority);
            if ($ret === FALSE) {
                result_log($dg_log_msg);
                throw new Exception("Cannot get collection authority." .
                                    "(resource:$dg_resource, " . 
                                    "collection:$colname)");
            }

            /* ���³�ǧ:�ɽ� or �ɤ߹��ߤΤߤ��ä���OK */
            if ($dg_authority != AUTHREADONLY && $dg_authority != AUTHREADWRITE) {
                result_log($dg_log_msg);
                throw new Exception("Not Permission." .
                                    "(resource:$dg_resource, " . 
                                    "collection:$colname)");
            }

            /* ���쥯�����̾ */
            $collection_name = $colname;
        }

        /* LDAP�������Υ꥽���������쥯������
           ���ƤΥ������������������� */
        $ret = search_all_calendar($dg_resource, $collection_name, $ldapdata);
        if ($ret === FALSE) {
            result_log($dg_log_msg);
            throw new Exception("Cannot get calendar objects." .
                                "(resource:$dg_resource, " .
                                "collection:$collection_name)");
        }

        /* ����������¸�ߤ��Ƥ�������ǧ */
        if (count($ldapdata) == 0) {
            /* �����������󤬰�Ĥ�ʤ� */
            return array();
        }

        /* �������뤿��η������Ѵ����� */
        $objects = createReturnCalendarObject($ldapdata, RETTYPE_MANY);

        return $objects;
    }

    /*********************************************************
     * getCalendarObject()
     *
     * ������������α���(ñ��)
     $*
     * [����]
     *       $calendarId    ��������ID
     *       $objectUri     �����������֥�������ID
     * [�֤���]
     *       $objects       ���֥������Ȥ�����
     *       (�������ʤ�)   �۾�(Exception�ǽ�λ)
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

        /* iPhone�ΤȤ��ϡ��ػߥ��쥯������̵�뤹�� */
        if ($access_type == IPHONE) {

            /* ���쥯����󸢸¼��� */
            $ret = check_collection_authority($calendarId, $colname, $dg_authority);
            if ($ret === FALSE) {
                result_log($dg_log_msg);
                throw new Exception("Cannot get collection authority." .
                                    "(resource:$dg_resource, " .
                                    "collection:$colname)");
            }

            /* ���³�ǧ */
            if ($dg_authority != AUTHREADONLY && $dg_authority != AUTHREADWRITE) {
                result_log($dg_log_msg);
                throw new Exception("Not Permission." .
                                    "(resource:$dg_resource, " .
                                    "collection:$colname)");
            }

            /* ���쥯�����̾ */
            $collection_name = $colname;
        }

        /* LDAP�������Υ꥽���������쥯������
           �������������������� */
        $ret = search_calendar($objectUri, $dg_resource,
                               $collection_name, $ldapdata);
        /* ��������������ļ������� */
        if ($ret === FALSE) {
            result_log($dg_log_msg);
            throw new Exception("Cannot get calendar object." .
                                "(resource:$dg_resource, " .
                                "collection:$collection_name)");
        }

        /* ����������¸�ߤ��Ƥ�������ǧ */
        if (count($ldapdata) == 0) {
            /* �����������󤬤ʤ� */
            return array();
        }

        /* ldapdata�����Ǥ��ɲä��� */
        $ldapdata[0][CALOBJURI][0] = $objectUri;

        /* �������뤿��η������Ѵ����� */
        $object = createReturnCalendarObject($ldapdata, RETTYPE_ONE);

        return $object;
    }

    /*********************************************************
     * createCalendarObject()
     *
     * ��������������ɲ�
     *
     * [����]
     *       $calendarId    ��������ID
     *       $objectUri     �����������֥�������ID
     *       $calendarData  ���������ǡ���
     * [�֤���]
     *       TRUE           ����
     *       (�������ʤ�)   �۾�(Exception�ǽ�λ)
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

        /* iPhone�ΤȤ��ϡ��ػߥ��쥯������̵�뤹�� */
        if ($access_type == IPHONE) {

            /* ���쥯����󸢸¼��� */
            $ret = check_collection_authority($calendarId, $colname, $tmp_authority);
            if ($ret === FALSE) {
                result_log($dg_log_msg);
                throw new Exception("Cannot get collection authority." .
                                    "(resource:$dg_resource, " .
                                    "collection:$colname)");
            }
            /* ���쥯�����̾ */
            $collection_name = $colname;

            /* ���쥯����󸢸� */
 	    $authority = $tmp_authority;
        }

        /* ���³�ǧ:�ɽ񤭤��ä���OK */
        if ($authority != AUTHREADWRITE) {
            $dg_log_msg = "Not permission.(resource:$dg_resource, " .
                          "collection:$collection_name)";
            result_log($dg_log_msg);
            throw new Exception($dg_log_msg);
        }

        /* °��̾(CTAG�Τ�) */
        $attrs = array(CALCTAG);

        /* ���쥯����������� */
        $ret = get_collection($dg_resource, $collection_name, $attrs, $data);
        if ($ret != FUNC_TRUE) {
            result_log($dg_log_msg);
            throw new Exception("Cannot get collection." .
                                "(resource:$dg_resource, " .
                                "collection:$collection_name)");
        }

        /* Ctag���ͤ��ݻ� */
        $ctag = $data[0][CALCTAG][0];
        
        /* LDAP����Ͽ��Ԥ� */
        /* URI���� */
        $caldata[CALOBJURI] = $objectUri;
        /* ���������ǡ��� */
        $caldata[CALOBJDATA] = $calendarData;
        /* �������� */
        $caldata[CALMODTIME] = time();
        /* ���֥������ȥ��饹 */
        $caldata[OBJECTCLASS] = OBJNAME_CALDATA;

        /* LDAP��ͽ�ꡦTODO���ɲ� */
        $ret = ldap_calendar_add($dg_resource, $collection_name,
                                 $objectUri, $caldata);
        if($ret === FALSE) {
            result_log($dg_log_msg);
            throw new Exception("Cannot add calendar data." .
                                "(resource:$dg_resource, " .
                                "collection:$collection_name");
        }

        /* ���������򹹿�������CTag�򥤥󥯥���Ȥ��� */
        $ctag = $ctag + 1;

        /* ���쥯������CTag����򹹿����� */
        $ret = ldap_collection_ctag_update($dg_resource, $collection_name, $ctag);
        if ($ret === FALSE) {
            /* CTag���󹹿����ԥ������ΰ����¸ */
            $tmp_log_msg = $dg_log_msg;
            /* ����� */
            $dg_log_msg = "";

            /* Ctag�ι����˼��Ԥ�����硢�ڤ��ᤷ��Ԥ� */
            /* ��Ͽ�������������ǡ����������� */
            $ret = ldap_calendar_del($dg_resource, $collection_name, $objectUri);
            if($ret === FALSE) {
                /* ���Ԥ��������礷�ƽ��Ϥ��� */
                $dg_log_msg = $tmp_log_msg . ", " . $dg_log_msg;
            } else {
                /* CTag���󹹿����ԤΥ��������Ϥ��� */
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
     * �����������֥��������ѹ�
     *
     * [����]
     *       $calendarId    ��������ID
     *       $objectUri     �����������֥�������ID
     *       $calendarData  ���������ǡ���
     * [�֤���]
     *       TRUE           ����
     *       (�������ʤ�)   �۾�(Exception�ǽ�λ)
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

        /* iPhone�ΤȤ��ϡ��ػߥ��쥯������̵�뤹�� */
        if ($access_type == IPHONE) {

            /* ���쥯����󸢸¼��� */
            $ret = check_collection_authority($calendarId, $colname, $tmp_authority);
            if ($ret === FALSE) {
                result_log($dg_log_msg);
                throw new Exception("Cannot get collection authority." .
                                    "(resource:$dg_resource, " .
                                    "collection:$colname)");
            }
            /* ���쥯�����̾ */
            $collection_name = $colname;

            /* ���쥯����󸢸� */
            $authority = $tmp_authority;
        }

        /* ���³�ǧ:�ɽ񤭤��ä���OK */
        if ($dg_authority != AUTHREADWRITE) {
            $dg_log_msg = "Not permission.(resource:$dg_resource," .
                          "collection:$collection_name)";
            result_log($dg_log_msg);
            throw new Exception($dg_log_msg);
        }

        /* °��̾(CTAG�Τ�) */
        $attrs = array(CALCTAG);

        /* ���쥯����������� */
        $ret = get_collection($dg_resource, $collection_name, $attrs, $data);
        if ($ret != FUNC_TRUE) {
            result_log($dg_log_msg);
            throw new Exception("Cannot get collection." .
                                "(resource:$dg_resource, " .
                                "collection:$collection_name)");
        }

        /* Ctag���ͤ��ݻ� */
        $ctag = $data[0][CALCTAG][0];

        /* LDAP���饫�������ǡ����ξ������ */
        /* �ڤ��ᤷ�Ѥξ��� */
        $ret = search_calendar($objectUri,
                               $dg_resource, $collection_name, $ldapdata);
        if ($ret === FALSE) {
            result_log($dg_log_msg);
            throw new Exception("Cannot get calendar data." .
                                "(resource:$dg_resource, " .
                                "collection:$collection_name, " .
                                          "uri:$objectUri)");
        }

        /* ����������¸�ߤ��Ƥ�������ǧ */
        if (count($ldapdata) == 0) {
            /* �����������󤬰�Ĥ�ʤ� */
            result_log($dg_log_msg);
            throw new Exception("Cannot found calendar data." .
                                "(resource:$dg_resource, " .
                                "collection:$collection_name, " .
                                          "uri:$objectUri)");
        }
        
        /* LDAP�ι�����Ԥ� */
        /* ���������ǡ��� */
        $caldata[CALOBJDATA] = $calendarData;
        /* �������� */
        $caldata[CALMODTIME] = time();

        /* LDAP��ͽ�ꡦTODO���ѹ� */
        $ret = ldap_calendar_mod($dg_resource, $collection_name,
                                     $objectUri, $caldata);
        if($ret === FALSE) {
            result_log($dg_log_msg);
            throw new Exception("Cannot mod calendar data." .
                                "(resource:$dg_resource, " .
                                "collection:$collection_name, " .
                                          "uri:$objectUri)");
        }

        /* ���������򹹿�������CTag�򥤥󥯥���Ȥ��� */
        $ctag = $ctag + 1;

        /* ���쥯������CTag����򹹿����� */
        $ret = ldap_collection_ctag_update($dg_resource, $collection_name, $ctag);
        if ($ret === FALSE) {
            /* CTag���󹹿����ԥ������ΰ����¸ */
            $tmp_log_msg = $dg_log_msg;
            /* ����� */
            $dg_log_msg = "";

            /* Ctag�ι����˼��Ԥ�����硢�ڤ��ᤷ��Ԥ� */
            $caldata = array();
            /* �ѹ����ξ����ľ�� */
            $caldata[CALOBJDATA] = $ldapdata[0][CALOBJDATA][0];
            /* �������� */
            $caldata[CALMODTIME] = $ldapdata[0][CALMODTIME][0];

            /* LDAP�Υ����������� */
            $ret = ldap_calendar_mod($dg_resource, $collection_name,
                                     $objectUri, $caldata);
            if($ret === FALSE) {
                /* ���Ԥ��������礷�ƽ��Ϥ��� */
                $dg_log_msg = $tmp_log_msg . ", " . $dg_log_msg;
            } else {
                /* CTag���󹹿����ԤΥ��������Ϥ��� */
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
     * �����������֥������Ⱥ��
     *
     * [����]
     *       $calendarId    ��������ID
     *       $objectUri     �����������֥�������ID
     * [�֤���]
     *       TRUE           ����
     *       FALSE          �۾�
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

        /* iPhone�ΤȤ��ϡ��ػߥ��쥯������̵�뤹�� */
        if ($access_type == IPHONE) {

            /* ���쥯����󸢸¼��� */
            $ret = check_collection_authority($calendarId, $colname, $tmp_authority);
            if ($ret === FALSE) {
                result_log($dg_log_msg);
                throw new Exception("Cannot get collection authority." .
                                    "(resource:$dg_resource, " .
                                    "collection:$colname)");
            }
            /* ���쥯�����̾ */
            $collection_name = $colname;

            /* ���쥯����󸢸� */
            $authority = $tmp_authority;
        }

        /* ���³�ǧ:�ɽ񤭤��ä���OK */
        if ($dg_authority != AUTHREADWRITE) {
            $dg_log_msg = "Not permission.(resource:$dg_resource," .
                          "collection:$collection_name)";
            result_log($dg_log_msg);
            throw new Exception($dg_log_msg);
        }

        /* °��̾(CTAG�Τ�) */
        $attrs = array(CALCTAG);

        /* ���쥯����������� */
        $ret = get_collection($dg_resource, $collection_name, $attrs, $data);
        if ($ret != FUNC_TRUE) {
            result_log($dg_log_msg);
            throw new Exception("Cannot get collection." .
                                "(resource:$dg_resource, " .
                                "collection:$collection_name)");
        }

        /* Ctag���ͤ��ݻ� */
        $ctag = $data[0][CALCTAG][0];

        /* LDAP���饫�������ǡ����ξ������ */
        /* �ڤ��ᤷ�Ѥξ��� */
        $ret = search_calendar($objectUri,
                               $dg_resource, $collection_name, $ldapdata);
        if ($ret === FALSE) {
            result_log($dg_log_msg);
            throw new Exception("Cannot get calendar data." .
                                "(resource:$dg_resource, " .
                                "collection:$collection_name, " .
                                          "uri:$objectUri)");
        }

        /* ����������¸�ߤ��Ƥ�������ǧ */
        if (count($ldapdata) == 0) {
            /* �����������󤬰�Ĥ�ʤ� */
            $dg_log_msg = "Cannot found calendar data." .
                          "(resource:$dg_resource, " .
                          "collection:$collection_name, " .
                          "uri:$objectUri)";
            result_log($dg_log_msg);
            /* ����ѤߤʤΤǡ�����������ʤ� */
            return TRUE;
        }
        
        /* LDAP�κ����Ԥ� */
        $ret = ldap_calendar_del($dg_resource, $collection_name, $objectUri);
        if($ret === FALSE) {
            result_log($dg_log_msg);
            throw new Exception("Cannot del calendar data." .
                                "(resource:$dg_resource, " .
                                "collection:$collection_name, " .
                                          "uri:$objectUri)");
        }

        /* ���������򹹿�������CTag�򥤥󥯥���Ȥ��� */
        $ctag = $ctag + 1;

        /* ���쥯������Ctag����򹹿����� */
        $ret = ldap_collection_ctag_update($dg_resource, $collection_name, $ctag);
        if ($ret === FALSE) {
            /* CTag���󹹿����ԥ������ΰ����¸ */
            $tmp_log_msg = $dg_log_msg;
            /* ����� */
            $dg_log_msg = "";

            /* Ctag�ι����˼��Ԥ�����硢�ڤ��ᤷ��Ԥ� */
            $caldata = array();
            /* ������ξ������Ͽ���� */
            /* URI���� */
            $caldata[CALOBJURI] = $objectUri;
            /* ���������ǡ��� */
            $caldata[CALOBJDATA] = $ldapdata[0][CALOBJDATA][0];
            /* �������� */
            $caldata[CALMODTIME] = $ldapdata[0][CALMODTIME][0];
            /* ���֥������ȥ��饹 */
            $caldata[OBJECTCLASS] = OBJNAME_CALDATA;

            /* LDAP���ɲ� */
            $ret = ldap_calendar_add($dg_resource, $collection_name,
                                     $objectUri, $caldata);
            if($ret === FALSE) {
                /* ���Ԥ��������礷�ƽ��Ϥ��� */
                $dg_log_msg = $tmp_log_msg . ", " . $dg_log_msg;
            } else {
                /* CTag���󹹿����ԤΥ��������Ϥ��� */
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
     * ���󥹥ȥ饯��
     *
     * [����]
     *       �ʤ�
     * [�֤���]
     *       �ʤ�
     **********************************************************/
    public function __construct($id) {
        $this->ldapid = $id;
    }

    /*********************************************************
     * __destruct()
     *
     * �ǥ��ȥ饯��
     *
     * [����]
     *       �ʤ�
     * [�֤���]
     *       �ʤ�
     **********************************************************/
    public function __destruct() {
        ldap_unbind($this->ldapid);
    }
}

/*********************************************************
 * Sabre_DAVACL_IPrincipalBackend_DGLDAP
 *
 * LDAP���������ѤΥץ�󥷥ѥ�ΥХå������
 * (Sabre\DAVACL\PrincipalBackend\AbstractBackend��Ѿ����ƺ���)
 *
 * [����]
 *       �ʤ�
 **********************************************************/
class Sabre_DAVACL_IPrincipalBackend_DGLDAP extends PrincipalBackend\AbstractBackend {

    /*********************************************************
     * getPrincipalsByPrefix()
     *
     * �ץ�ե��å������������
     *
     * [����]
     *       $prefixPath  �ץ�ե��å���
     * [�֤���]
     *       (��������)   ����
     **********************************************************/
    function getPrincipalsByPrefix($prefixPath)
    {
        $tmp[] = array();
        return $tmp;
    }

    /*********************************************************
     * getPrincipalByPath()
     *
     * �ץ�󥷥ѥ�Υѥ����������
     *
     * [����]
     *       $path        �ѥ�
     * [�֤���]
     *       (����)       ����
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
     * ���С��Υ��롼�פ��������
     *
     * [����]
     *       $principal   �ץ�󥷥ѥ�
     * [�֤���]
     *       (����)       ����
     **********************************************************/
    function getGroupMembership($principal)
    {
        return array();
    }

    /*********************************************************
     * getGroupMemberSet()
     *
     * �ץ�󥷥ѥ�Υ��С����롼�פ����
     *
     * [����]
     *       $principal   �ץ�󥷥ѥ�
     * [�֤���]
     *       �ʤ�
     **********************************************************/
    function getGroupMemberSet($principal)
    {
    }

    /*********************************************************
     * setGroupMemberSet()
     *
     * �ץ�󥷥ѥ�Υ��С����롼�פ�����
     *
     * [����]
     *       $principal   �ץ�󥷥ѥ�
     *       $members     ���С�
     * [�֤���]
     *       �ʤ�
     **********************************************************/
    function setGroupMemberSet($principal, array $members)
    {
    }

    /*********************************************************
     * updatePrincipal()
     *
     * �ץ�󥷥ѥ����򹹿�����
     *
     * [����]
     *       $principal   �ץ�󥷥ѥ�
     *       $members     ���С�
     * [�֤���]
     *       TRUE           ����
     **********************************************************/
    function updatePrincipal($path, $mutations)
    {
        return TRUE;
    }

    /*********************************************************
     * searchPrincipals()
     *
     * �������Ϥ��줿����ɽ��̾orMailAddress�ˤǥץ�󥷥ѥ�򸡺�����
     *
     * [����]
     *       $principal   �ץ�󥷥ѥ�
     *       $members     ���С�
     * [�֤���]
     *       TRUE           ����
     **********************************************************/
     function searchPrincipals($prefixPath, array $searchProperties)
     {
        return TRUE;
     }
}

/*********************************************************
 * Ldap_Auth
 *
 * LDAP���������ѤΥץ�󥷥ѥ�ΥХå������
 *
 * [����]
 *       �ʤ�
 **********************************************************/
class Ldap_Auth extends AbstractBasic {

    /* �����󤷤ƥ桼��ID���ݻ������ѿ�*/
    protected $currentUser;
    protected $user_info;

    /*********************************************************
     * __construct()
     *
     * ���󥹥ȥ饯��
     *
     * [����]
     *       �ʤ�
     * [�֤���]
     *       �ʤ�
     **********************************************************/
    public function __construct($userid, $passwd) {
        $this->currentUser = "";
        $this->user_info = array($userid, $passwd);
    }

    /*********************************************************
     * authenticate()
     *
     * Auth�����Ф���³���Ƹ��ߤΥ桼����ǧ��
     *
     * [����]
     *       $server
     *       $realm
     * [�֤���]
     *       TRUE           ����(ǧ������)
     *       (ǧ�ڼ���)     �۾�(Exception�ǽ�λ)
     **********************************************************/
    public function authenticate(DAV\Server $server, $realm) {

        $auth = new HTTP\BasicAuth();

        /* �桼��ID�ȥѥ���ɤ����d*
        if (($this->user_info[0] == "") || ($this->user_info[1] == "")) {
            $auth->requireLogin();
            throw new DAV\Exception\No$dg_ldapidtAuthenticated('No basic authentication headers were found');
        }

        /* �桼��ǧ��*/
        if ($this->validateUserPass($this->user_info[0], $this->user_info[1]) === FALSE) {
            $auth->requireLogin();
            throw new DAV\Exception\NotAuthenticated('Incorrect username');
        }

        /* �����ȥ桼���ݻ�*/
        $this->currentUser = $this->user_info[0];
        return TRUE;

    }

    /*********************************************************
     * validateUserPass()
     *
     * Auth�����Ф���³���Ƹ��ߤΥ桼����ǧ��
     *
     * [����]
     *       $userid        BASIC�桼��ID
     *       $password      BASIC�ѥ����
     * [�֤���]
     *       TRUE           ����(ǧ������)
     *       FALSE          �۾�(ǧ�ڼ���)
     **********************************************************/
    protected function validateUserPass($userid, $password){
        return ldap_bind_user($userid, $password);
    }

}

?>
