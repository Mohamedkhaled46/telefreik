<?php


namespace App\Repositories;


use App\Models\Reply;
use App\Repositories\Interfaces\IReplyRepository;

class ReplyRepository implements IReplyRepository
{

    function createFromDashBoard($request)
    {
      return Reply::create($request->all());
    }

    function createFromMobile($request)
    {
        return Reply::create($request->all());
    }
}
