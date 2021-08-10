<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Traits\ApiResponse;

use Illuminate\Http\Request;
use App\Http\Requests\Promotions\PromotionHelpStoreRequest;
use App\Http\Requests\Promotions\PromotionHelpDonationRequest;



use App\Models\PromotionHelp;
use App\Http\Services\PromotionHelpService;
use App\Http\Resources\PromotionHelpResource;

class PromotionHelpController extends Controller
{
    use ApiResponse;

    protected $PromotionHelpService;

    public function __construct(PromotionHelpService $PromotionHelpService)
    {
        $this->PromotionHelpService = $PromotionHelpService;
    }

    
    /**
     * Display a publishering of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $data = $request->all();
        $result = $this->PromotionHelpService->getAll($data);
        
         
            
        if (isset($result[0]) && ($result[0] instanceof PromotionHelp)) {
            $result = PromotionHelpResource::collection($result);
        }

        return $this->successResponse($result);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  PromotionHelpStoreRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(PromotionHelpStoreRequest $request)
    {
        $data = $request->only([ 'amount', 'title','isbn','publisher','price','year', 'quantity', 'user_id' ]);

        $result = $this->PromotionHelpService->storePromotionHelp($data);


        if ($result instanceof PromotionHelp) {
            $result = new PromotionHelpResource($result);
        }



        return $this->successResponse($result);
    }

    /**
     * Display the specified resource.
     *
     * @param  integer  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $result = $this->PromotionHelpService->showPromotionHelp($id);

        if ($result instanceof PromotionHelp) {
            $result = new PromotionHelpResource($result);
        }

        return $this->successResponse($result);
    }

    /**
     * Make donation to the specified resource in storage.
     *
     * @param  PromotionHelpDonationRequestt  $request
     * @return \Illuminate\Http\Response
     */
    public function donation(PromotionHelpDonationRequest $request, $id)
    {
        $data = $request->only(['user_id','amount']);

        $result = $this->PromotionHelpService->donationPromotionHelp($data, $id);

        if ($result instanceof Book) {
            $result = new BookResource($result);
        }

        return $this->successResponse($result);
    }
}
