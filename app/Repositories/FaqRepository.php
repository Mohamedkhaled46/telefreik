<?php 
namespace App\Repositories;

use App\Models\Faq;
use App\User;
use App\Models\Ticket;
use App\Repositories\Interfaces\IFaqRepository;
use App\Repositories\Interfaces\ITicketRepository;
use Carbon\Carbon;

class FaqRepository implements IFaqRepository
{
    public $faq;
    public function __construct(Faq $faq)
    {
        $this->faq = $faq;
    }




    public function filter()
    {
        return $this->faq->paginate(10);
    }

    function create($data){
        return $this->faq->create($data);
    }

    public function update($request , $faq)
    {
        return  $faq->update($request->all());
        
    }


    public function delete($id)
    {
        return $this->faq->findOrFail($id)->delete();
    }

}