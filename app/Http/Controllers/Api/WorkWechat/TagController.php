<?php

namespace App\Http\Controllers\Api\WorkWechat;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class TagController extends WechatBaseController
{
    protected $tag;

    public function __construct()
    {
        parent::__construct();
        $this->tag = $this->workWeChat->agent('contacts')->tag;
    }

    /**
     * add tag to contacts
     * @param Request $request
     * @return mixed
     */
    public function addTag(Request $request)
    {
        $tag_name = $request->tagname;
        $tag_id = $request->tagid;
        return $this->responseWeChat($this->tag->create($tag_name,$tag_id));
    }
    /**
     * update tag info
     * @param  Request $request 
     * @return JSON           
     */
    public function updateTag(Request $request)
    {
        $tag_name = $request->tagname;
        $tag_id = $request->tagid;
        return $this->responseWeChat($this->tag->update($tag_id,$tag_name));
    }

    public function deleteTagById($tag_id)
    {
        return $this->responseWeChat($this->tag->delete($tag_id));
    }

    public function getTagById($tag_id)
    {
        return $this->responseWeChat($this->tag->get($tag_id));
    }

    public function getTagList()
    {
        return $this->responseWeChat($this->tag->list());
    }

    public function getUsersByTag(Request $request)
    {
        return $this->responseWeChat($this->tag->get($request->tagid));
    }

    public function addUserToTag(Request $request)
    {
        $user_list = explode('|',$request->userlist);
        return $this->responseWeChat($this->tag->tagUsers($request->tagid,$user_list));
    }
    public function removeUserFromTag(Request $request)
    {
        $user_list = explode('|',$request->userlist);
        return $this->responseWeChat($this->tag->untagUsers((int)$request->tagid,$user_list));
    }

    public function getDepartmentsByTag(Request $request)
    {
        return $this->getUsersByTag($request);
    }

    public function addDepartmentToTag(Request $request)
    {
        $dept_list = explode('|',$request->partylist);
        return $this->responseWeChat($this->tag->tagDepartments($request->tagid,$dept_list));
    }
    public function removeDepartmentFromTag(Request $request)
    {
        $dept_list = explode('|',$request->partylist);
        return $this->responseWeChat($this->tag->untagDepartments((int)$request->tagid,$dept_list));
    }

}
