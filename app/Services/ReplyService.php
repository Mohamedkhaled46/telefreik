<?php


namespace App\Services;


use App\Repositories\Interfaces\IReplyRepository;

class ReplyService
{
    protected $replyRepository;
    public function __construct(IReplyRepository $replyRepository)
    {
        $this->replyRepository = $replyRepository;
    }

    public function createFromDashBoard($request)
    {

        if ($request->has('file'))
        {
            $request->merge(['attachment'=>UploadService::uploadFile($request,'file','ticket_attachment')]);
        }
        return $this->replyRepository->createFromDashBoard($request);
    }

    public function createFromMobile($request)
    {

        if ($request->has('file'))
        {
            $request->merge(['attachment'=>UploadService::uploadFile($request,'file','ticket_attachment')]);
        }
        return $this->replyRepository->createFromMobile($request);
    }

}
