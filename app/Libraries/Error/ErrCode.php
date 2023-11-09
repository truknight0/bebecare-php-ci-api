<?php

namespace App\Libraries\Error;

class ErrCode
{

    # http 규격에 따른 성공과 실패
    const SUCCESS = 200;

    const ERR_FAIL = 400;

    const ERR_MSG_INVALID_PARAMETER = 9000;

    const ERR_PROCESS_USER_AUTH = 9100;

    const ERR_PROCESS_USER_LEVEL = 9900;

    // 데이터베이스 관련 실패 코드
    const ERR_DB_NODATA = 1000;
    const ERR_DB_DUPLICATION_DATA = 1001;
    const ERR_DB_UPDATE_DATA = 1002;
    const ERR_DB_DELETE_DATA = 1003;
    const ERR_DB_INSERT_DATA = 1004;
    const ERR_DB_EXIST_DATA = 1005;
    const ERR_DB_LOCK = 1100;

    // 로그인 관련 실패 코드
    const ERR_LOGIN_NOTHING_TOKEN = 2000;
    const ERR_LOGIN_UNAUTHORIZED_TOKEN = 2001;

    // 초대
    const ERR_INVITE_CODE = 3000;
    const ERR_INVITE_CODE_MAKER_JOIN = 3001;

    public static function StrRetCode($code): string
    {
        switch ($code) {

            case self::SUCCESS:
                return "success";
            case self::ERR_FAIL:
                return "api system error";
            case self::ERR_MSG_INVALID_PARAMETER:
                return "필수 입력항목이 누락되었습니다.";
            case self::ERR_PROCESS_USER_AUTH:
                return "올바르지 않은 접근이거나 권한이 없습니다.";
            case self::ERR_PROCESS_USER_LEVEL:
                return "실행 권한이 없습니다.";
            case self::ERR_LOGIN_NOTHING_TOKEN:
                return "인증값이 존재하지 않습니다.";
            case self::ERR_LOGIN_UNAUTHORIZED_TOKEN:
                return "사용자 인증이 유효하지 않습니다.";
            case self::ERR_DB_NODATA:
                return "데이터가 존재하지 않습니다.";
            case self::ERR_DB_DUPLICATION_DATA:
                return "ERR_DB_DUPLICATION_DATA";
            case self::ERR_DB_UPDATE_DATA:
                return "ERR_DB_UPDATE_DATA";
            case self::ERR_DB_DELETE_DATA:
                return "ERR_DB_DELETE_DATA";
            case self::ERR_DB_INSERT_DATA:
                return "ERR_DB_INSERT_DATA";
            case self::ERR_DB_EXIST_DATA:
                return "ERR_DB_EXIST_DATA";
            case self::ERR_INVITE_CODE:
                return "올바르지 않은 초대코드 입니다.";
            case self::ERR_INVITE_CODE_MAKER_JOIN:
                return "초대코드 생성자는 초대코드로 가입할 수 없습니다.";
            default:
                return "api system error";
        }

        return '';
    }

    public static function setRetCode($code, $message = null): array
    {
        return array(
            'code' => $code,
            'message' => self::StrRetCode($code)
        );
    }
}