<?php

namespace App\Http\Controllers;

use App\Http\Requests\FaqRequest;
use App\Models\Faq;
use App\Services\FaqService;
use Illuminate\Http\Request;

class FaqsController extends Controller
{

    protected $faqService;
    public function __construct(FaqService $faqService) {
        $this->faqService = $faqService;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return response($this->faqService->filter(), 200);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(FaqRequest $request)
    {

        $faq = $this->faqService->create($request->all());
        return ($faq)?response(['message'=>'FAQ Created Successfully' ,'faq'=>$faq] ,201):response(['message'=>'Please try agin wrong'],500);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Faq $faq)
    {
        return response($faq);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(FaqRequest $request, Faq $faq)
    {
        $isUpdated = $this->faqService->update($request , $faq);
        return ($isUpdated)? response(['message' =>'The FAQ updated successfully' , 'faq'=>$faq->refresh()]):response(['message'=>'Please try agin wrong'] ,500);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $isDeleted =  $this->faqService->delete($id);
        return ($isDeleted)? response(['message' =>'The FAQ DELETED successfully' ]):response(['message'=>'Please try agin wrong'] ,500);
    }
}
