<?php
namespace App\Services;

use App\Models\Ticket;
use App\Repositories\Interfaces\IFaqRepository;
use App\Repositories\Interfaces\ITicketRepository;


class FaqService
{
    protected $faqRepository;
    public function __construct(IFaqRepository $faqRepository) {
        $this->faqRepository = $faqRepository;
    }

    public function filter()
    {
        return $this->faqRepository->filter();
    }

    public function create($data)
    {
        return $this->faqRepository->create($data);
    }

    public function update( $request,$faq)
    {
        return $this->faqRepository->update($request,$faq);
    }

    public function delete($id)
    {
        return $this->faqRepository->delete($id);
    }

}
