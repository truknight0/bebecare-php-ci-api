<?php

namespace App\Models;

use App\Libraries\Common\DBMessage;
use App\Libraries\Objects\Models\Invite\InviteCodeInfo;
use App\Libraries\Utils\Utils;
use CodeIgniter\Model;

class InviteModel extends Model
{
    public function getInviteCodeInfoWithUserIdx($userIdx): ?InviteCodeInfo
    {
        $query = "
            SELECT ric.invite_code,
		       ric.user_idx,
		       us.name
            FROM rel_invite_code_user AS ric
            LEFT JOIN user AS us ON ric.user_idx = us.idx
            WHERE us.idx = {$this->db->escape($userIdx)}";

        return Utils::checkResult($query, DBMessage::DB_SELECT_ROW, InviteCodeInfo::class);
    }

    public function getUserListWithInviteCode($token, $inviteCode) {
        $query = "
            SELECT us.idx,
                us.name,
                us.phone,
                us.role,
                us.user_type,
                IF (at.token = {$this->db->escape($token)}, true, false) AS is_mine
            FROM rel_invite_code_user AS ric
            LEFT JOIN user AS us ON ric.user_idx = us.idx
            LEFT JOIN auth_token AS at ON at.user_idx = us.idx
            WHERE ric.invite_code = {$this->db->escape($inviteCode)}";

        return Utils::checkResult($query, DBMessage::DB_SELECT);
    }
}