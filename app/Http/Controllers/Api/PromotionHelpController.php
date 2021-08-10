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
    * Listado de promociones de ayuda
    * [Obtener listado de promociones de ayuda]
    * @authenticated
    * @group  Promociones
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
    * Crear  promoción
    * [Creación de promoción de ayuda por parte de autor para publicar su libro a futuro]
    * @group  Promociones
    * @authenticated
    * @bodyParam  title Título del libro
    * @bodyParam isbn  ISBN
    * @bodyParam publisher Editor
    * @bodyParam price Precio
    * @bodyParam year Año de Publicación
    * @bodyParam quantity Existencias
    * @bodyParam  amount Cantidad a recaudar
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
    * Donar
    * [Un lector hace un donación a una promoción de ayuda a las nuevas ideas]
    * @group  Promociones
    * @authenticated
    * @urlParam  id Id de la promoción
    * @bodyParam  amount Cantidad a donar
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
