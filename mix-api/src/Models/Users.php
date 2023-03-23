<?php

namespace App\Models;

class Users extends Base
{
    protected $table = 'members';

    // 定义表主键
    protected $primaryKey = 'id';

    public function __construct()
    {
        parent::__construct();
    }

    /**
     * 根据账号获取用户信息
     * @param $account
     * @return array
     */
    public static function getMemByUser($account): array
    {
        $member = self::query()->where('account = ?', $account)->first();
        return $member ?: [];
    }

    /**
     * 根据邀请码获取用户信息
     * @param $invite_code
     * @return array
     */
    public static function getMemByCode($invite_code): array
    {
        return self::query()->where('invitation_code = ?', $invite_code)->first();
    }

}