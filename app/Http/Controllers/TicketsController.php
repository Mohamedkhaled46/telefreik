<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateTicketRequest;
use App\Services\TicketService;
use Illuminate\Http\Request;

class TicketsController extends Controller
{
    protected $ticketService;
    public function __construct(TicketService $ticketService)
    {
        $this->ticketService = $ticketService;
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return response($this->ticketService->filter(), 200);
    }


    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        return response($this->ticketService->show($id), 200);
    }


    public function changeStatus($id)
    {
        return response($this->ticketService->changeStatus($id), 200);
    }

    public function create(CreateTicketRequest $request)
    {
        $ticket =  $this->ticketService->create($request);
        if ($ticket) {
            return sendResponse($ticket, 'Your Ticket Created successfully.');
        } else {
            return sendError('Error while try to create ticket', [], 500);
        }
    }

    public function getAllForCustomer(Request $request)
    {
      $tickets =  $this->ticketService->getAllForCustomer($request);
      if($tickets){
          return sendResponse($tickets, 'Your Tickets Retrieved successfully.');
      } else{
          return sendError('Error while try to retrieve tickets', [], 500);
      }
    }

    public function showForMobile($id)
    {
        $ticket = $this->ticketService->showForMobile($id);
        if($ticket){
            return sendResponse($ticket, 'Your Ticket Retrieved successfully.');
        } else{
            return sendError('Error while try to retrieve ticket', [], 500);
        }
    }

}
