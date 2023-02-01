<?php


namespace App\Repositories\Interfaces;


interface IReplyRepository
{
    function createFromDashBoard($request);
    function createFromMobile($request);
}
