<?php


namespace App\Models;


use App\Libraries\Common\DBMessage;
use App\Libraries\Error\Exception\CustomException;
use App\Libraries\Logs\LogUtil;
use App\Libraries\Objects\Models\User\UserInfo;
use App\Libraries\Utils\TextUtils;
use App\Libraries\Utils\Utils;
use CodeIgniter\Model;

class UserModel extends Model
{
    public function getUserInfo($name, $phone, $role): ?UserInfo
    {
        $query = "
            SELECT idx,
                name,
                phone,
                role,
                is_push_agree,
                created_at
            FROM user
            WHERE name = {$this->db->escape($name)}
                AND phone = {$this->db->escape($phone)}
                AND role = {$this->db->escape($role)}";

        return Utils::checkResult($query, DBMessage::DB_SELECT_ROW, UserInfo::class);
    }
    public function getUserInfoWithToken($token): ?UserInfo
    {
        $query = "
            SELECT us.idx,
		       us.name,
		       us.phone,
		       us.role,
		       us.is_push_agree,
		       us.user_type,
		       us.created_at,
		       at.token
            FROM auth_token AS at
            LEFT JOIN user AS us ON at.user_idx = us.idx
            WHERE at.token = {$this->db->escape($token)}
                AND DATE_FORMAT(at.expire_date, '%Y-%m-%d %H:%i:%s') >= NOW()";

        return Utils::checkResult($query, DBMessage::DB_SELECT_ROW, UserInfo::class);
    }

    public function getUserToken($name, $phone, $role)
    {
        $query = "
            SELECT at.token 
            FROM auth_token AS at
            LEFT JOIN user AS mb ON at.user_idx = mb.idx
            WHERE mb.name = {$this->db->escape($name)}
                AND mb.phone = {$this->db->escape($phone)}
                AND mb.role = {$this->db->escape($role)}
                AND DATE_FORMAT(at.expire_date, '%Y-%m-%d %H:%i:%s') >= NOW()";

        return Utils::checkResult($query, DBMessage::DB_SELECT_ROW)->token;
    }

    public function insertUser($name, $phone, $role, $isPushAgree)
    {
        $query = "
            INSERT INTO user
            SET 
                name = {$this->db->escape($name)},
                phone = {$this->db->escape($phone)},
                role = {$this->db->escape($role)},
                is_push_agree = {$this->db->escape($isPushAgree)}";

        return Utils::checkResult($query, DBMessage::DB_INSERT_ID);
    }

    public function insertToken($token, $userIdx)
    {
        $query = "
            INSERT INTO auth_token
            SET 
                token = {$this->db->escape($token)},
                user_idx = {$this->db->escape($userIdx)}";

        return Utils::checkResult($query, DBMessage::DB_INSERT_ID);
    }

    public function modifyUser($userIdx, $name, $phone, $role) {
        $query = "
            UPDATE user SET
                name = {$this->db->escape($name)},
                phone = {$this->db->escape($phone)},
                role = {$this->db->escape($role)}
            WHERE
                idx = {$this->db->escape($userIdx)}";

        return Utils::checkResult($query, DBMessage::DB_UPDATE);
    }

    public function modifyRelInviteCodeUser($userIdx, $name, $role) {
        $query = "
            UPDATE rel_invite_code_user SET
                name = {$this->db->escape($name)},
                role = {$this->db->escape($role)}
            WHERE
                idx = {$this->db->escape($userIdx)}";

        return Utils::checkResult($query, DBMessage::DB_UPDATE);
    }

    public function deleteUser($userIdx) {
        $query = "
            DELETE FROM user
            WHERE
                idx = {$this->db->escape($userIdx)}";

        return Utils::checkResult($query, DBMessage::DB_DELETE);
    }
}