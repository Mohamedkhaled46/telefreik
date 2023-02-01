<?php

namespace App\Http\Controllers;

use App\Http\Requests\AddReplyRequest;
use App\Services\ReplyService;
use Illuminate\Http\Request;

class ReplyController extends Controller
{
    protected $replyService;
    public function __construct(ReplyService $replyService)
    {
        $this->replyService = $replyService;
    }

    public function createFromDashBoard(AddReplyRequest $request)
    {
       $response =  $this->replyService->createFromDashBoard($request);
        if ($response) {
            return sendResponse($response, 'Reply successfully created.');
        } else {
            return sendError('Error while try to save reply', [], 500);
        }
    }

    public function createFromMobile(AddReplyRequest $request)
    {
        $response =  $this->replyService->createFromMobile($request);
        if ($response) {
            return sendResponse($response, 'Reply successfully created.');
        } else {
            return sendError('Error while try to save reply', [], 500);
        }
    }
}
