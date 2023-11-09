<?php

namespace App\Models;

use App\Libraries\Common\DBMessage;
use App\Libraries\Utils\Utils;
use CodeIgniter\Model;

class ChildrenModel extends Model
{
    public function getUserChildrenList($userIdx)
    {
        $query = "
            SELECT cr.idx,
                cr.name,
                DATE_FORMAT(cr.birthday, '%Y-%m-%d') as birthday,
                cr.gender,
                cr.tall,
                cr.weight,
                cr.head_size,
                cr.image_url
            FROM rel_parent_children AS rpc
            LEFT JOIN children AS cr ON rpc.children_idx = cr.idx
            WHERE rpc.user_idx = {$this->db->escape($userIdx)}
            ORDER BY idx ASC";

        return Utils::checkResult($query, DBMessage::DB_SELECT);
    }
}