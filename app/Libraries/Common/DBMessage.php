<?php
namespace App\Libraries\Common;

class DBMessage
{
    # TYPE
    const DB_INSERT = 1;
    const DB_DELETE = 2;
    const DB_UPDATE = 3;
    const DB_SELECT = 4;
    const DB_COUNT = 5;
    const DB_SELECT_ROW = 6;
    const DB_INSERT_ID = 7;


# http 규격에 따른 성공과 실패
    const DB_SUCCESS = 1;
    const DB_FAIL    = 0;
}