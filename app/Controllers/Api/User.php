<?php
namespace App\Controllers\Api;


use App\Controllers\BaseController;
use App\Libraries\Error\ErrCode;
use App\Libraries\Error\Exception\CustomException;
use App\Libraries\Objects\Param;
use App\Libraries\Objects\Protocols\AuthHeader;
use App\Libraries\Objects\Protocols\User\CheckUserDataResponse;
use App\Libraries\Objects\Protocols\User\GetUserInfoDataResponse;
use App\Libraries\Objects\Protocols\User\LoginDataResponse;
use App\Libraries\Objects\Protocols\User\LoginRequest;
use App\Libraries\Objects\Protocols\User\ModifyUserRequest;
use App\Libraries\Utils\TextUtils;
use App\Models\ChildrenModel;
use App\Models\InviteModel;
use App\Models\UserModel;

header('Access-Control-Allow-Origin: *');
header("Access-Control-Allow-Headers: *");
header("Access-Control-Allow-Methods: POST, GET, OPTIONS");

class User extends BaseController {
    /**
     * @throws CustomException
     */
    public function login() {
//        $header = Param::requestHeader(AuthHeader::class) ?? new AuthHeader();
        $request = Param::requestBody(LoginRequest::class) ?? new LoginRequest();

        $userModel = new UserModel();
        $childrenModel = new ChildrenModel();

        $token = '';
        $isFirstUser = true;
        $userIdx = 0;
        $childrenList = null;

        // 동일한 정보를 가진 유저가 있는지 확인
        $userInfo = $userModel->getUserInfo($request->getName(), $request->getPhone(), $request->getRole());
        if ($userInfo != null) {
            $token = $userModel->getUserToken($request->getName(), $request->getPhone(), $request->getRole());
            $isFirstUser = false;
            $userIdx = $userInfo->getIdx();
            // 기존 회원이면 아이들 정보 가져오기
            $childrenList = $childrenModel->getUserChildrenList($userIdx);
        } else {
            // 동일한 유저가 없으면 회원정보 저장하고 토큰 발급
            $userIdx = $userModel->insertUser($request->getName(), $request->getPhone(), $request->getRole(), 1);
            if ($userIdx == 0) {
                throw new CustomException(ErrCode::ERR_DB_INSERT_DATA);
            }
            $token = base64_encode(TextUtils::generateRandomString($request->getName() . $request->getPhone()));
            if (!$userModel->insertToken($token, $userIdx)) {
                throw new CustomException(ErrCode::ERR_DB_INSERT_DATA);
            }
        }

        $data = new LoginDataResponse();
        $data->setToken($token);
        $data->setIsFirstUser($isFirstUser);
        $data->setChildren($childrenList);

        $this->result->setData($data);
        echo Param::result($this->result);
    }

    /**
     * @throws CustomException
     */
    public function checkUser() {
        $header = Param::requestHeader(AuthHeader::class) ?? new AuthHeader();
        if (!$header->getUserToken()) {
            throw new CustomException(ErrCode::ERR_FAIL);
        }

        $userModel = new UserModel();
        $childrenModel = new ChildrenModel();

        $userInfo = $userModel->getUserInfoWithToken($header->getUserToken());
        if ($userInfo == null) {
            throw new CustomException(ErrCode::ERR_DB_NODATA);
        }
        $childrenList = $childrenModel->getUserChildrenList($userInfo->getIdx());

        $data = new CheckUserDataResponse();
        $data->setIdx($userInfo->getIdx());
        $data->setChildrenList($childrenList);

        $this->result->setData($data);
        echo Param::result($this->result);
    }

    /**
     * @throws CustomException
     */
    public function getUserInfo() {
        $header = Param::requestHeader(AuthHeader::class) ?? new AuthHeader();
        if (!$header->getUserToken()) {
            throw new CustomException(ErrCode::ERR_FAIL);
        }

        $userModel = new UserModel();
        $childrenModel = new ChildrenModel();
        $inviteModel = new InviteModel();

        $userInfo = $userModel->getUserInfoWithToken($header->getUserToken());
        if ($userInfo == null) {
            throw new CustomException(ErrCode::ERR_DB_NODATA);
        }
        $childrenList = $childrenModel->getUserChildrenList($userInfo->getIdx());
        $inviteCodeInfo = $inviteModel->getInviteCodeInfoWithUserIdx($userInfo->getIdx());
        if ($inviteCodeInfo != null) {
            $parentsList = $inviteModel->getUserListWithInviteCode($header->getUserToken(), $inviteCodeInfo->getInviteCode());
        }

        $data = new GetUserInfoDataResponse();
        $data->setIsFirstUser(false);
        $data->setToken($header->getUserToken());
        $data->setIdx($userInfo->getIdx());
        $data->setName($userInfo->getName());
        $data->setPhone($userInfo->getPhone());
        $data->setRole($userInfo->getRole());
        $data->setIsPushAgree($userInfo->getIsPushAgree());
        $data->setUserType($userInfo->getUserType());
        $data->setCreatedAt($userInfo->getCreatedAt());
        $data->setInviteCode(($inviteCodeInfo != null) ? $inviteCodeInfo->getInviteCode() : null);
        $data->setChildren($childrenList);
        $data->setParents(($inviteCodeInfo != null) ? $parentsList : null);

        $this->result->setData($data);
        echo Param::result($this->result);
    }

    /**
     * @throws CustomException
     */
    public function modifyUser() {
        $header = Param::requestHeader(AuthHeader::class) ?? new AuthHeader();
        if (!$header->getUserToken()) {
            throw new CustomException(ErrCode::ERR_FAIL);
        }
        $request = Param::requestBody(ModifyUserRequest::class) ?? new ModifyUserRequest();

        $userModel = new UserModel();

        if (!$userModel->modifyUser($request->getIdx(), $request->getName(), $request->getPhone(), $request->getRole())) {
            throw new CustomException(ErrCode::ERR_DB_UPDATE_DATA);
        }
        if (!$userModel->modifyRelInviteCodeUser($request->getIdx(), $request->getName(), $request->getRole())) {
            throw new CustomException(ErrCode::ERR_DB_UPDATE_DATA);
        }

        echo Param::result($this->result);
    }

    /**
     * @throws CustomException
     */
    public function deleteUser() {
        $header = Param::requestHeader(AuthHeader::class) ?? new AuthHeader();
        if (!$header->getUserToken()) {
            throw new CustomException(ErrCode::ERR_FAIL);
        }

        $userModel = new UserModel();

        $userInfo = $userModel->getUserInfoWithToken($header->getUserToken());
        if ($userInfo == null) {
            throw new CustomException(ErrCode::ERR_DB_NODATA);
        }

        if (!$userModel->deleteUser($userInfo->getIdx())) {
            throw new CustomException(ErrCode::ERR_DB_UPDATE_DATA);
        }

        echo Param::result($this->result);
    }
}