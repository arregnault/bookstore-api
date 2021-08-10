<?php

namespace App\Http\Services;

use Exception;
use InvalidArgumentException;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

use App\Http\Repositories\PromotionHelpRepository;
use App\Http\Repositories\BookRepository;
use App\Http\Repositories\UserRepository;
use App\Http\Repositories\PromotionHelpUserRepository;

use App\Events\NewIdeasPromotionEvent;

class PromotionHelpService
{
    /**
     * @var $PromotionHelpRepository
    */
    protected $PromotionHelpRepository;

    /**
     * @var $BookRepository
    */
    protected $BookRepository;

    /**
     * @var $UserRepository
    */
    protected $UserRepository;

    /**
     * @var $PromotionHelpUserRepository
    */
    protected $PromotionHelpUserRepository;



    /**
     * BookService constructor.
     *
     * @param PromotionHelpRepository $PromotionHelpRepository
     * @param BookRepository $BookRepository
     * @param UserRepository $UserRepository
     * @param PromotionHelpUserRepository $PromotionHelpUserRepository
     */
    public function __construct(PromotionHelpRepository $PromotionHelpRepository, BookRepository $BookRepository, UserRepository $UserRepository, PromotionHelpUserRepository $PromotionHelpUserRepository)
    {
        $this->PromotionHelpRepository = $PromotionHelpRepository;
        $this->BookRepository = $BookRepository;
        $this->UserRepository = $UserRepository;
        $this->PromotionHelpUserRepository = $PromotionHelpUserRepository;
    }

    /**
     * Get all PromotionHelp.
     *
     * @return Collection
     */
    public function getAll($data)
    {
        Log::info('Obtener listado de libros');
        return $this->PromotionHelpRepository->getAll($data);
    }

    /**
     * Store PromotionHelp
     * @param array $data
     * @return Model
     */
    public function storePromotionHelp($data)
    {
        $result = null;
        DB::beginTransaction();
        Log::info('Crear promoción ayuda a las nuevas ideas');
        try {
            $data['is_active'] = false;
            $book = $this->BookRepository->storeBook($data);
            $data['book_id']   = $book->id;
            $result   = $this->PromotionHelpRepository->storePromotionHelp($data);
        } catch (Exception $e) {
            DB::rollBack();
            Log::info($e->getMessage());

            throw new InvalidArgumentException($e->getMessage());
        }
        DB::commit();

        return $result;
    }

    /**
    * Show PromotionHelp
    *
    * @param array $data
    * @return Model
    */
    public function showPromotionHelp($id)
    {
        Log::info('Obtener promoción ayuda a las nuevas ideas');
        return $this->PromotionHelpRepository->showPromotionHelp($id);
    }

    /**
     * Make Donation
     *
     * @param array $data
     * @return Model
     */
    public function donationPromotionHelp($data, $id)
    {
        $result = null;
        DB::beginTransaction();
        Log::info('Realizar donación a promoción ayuda a las nuevas ideas');
        try {
            $promotion = $this->PromotionHelpRepository->showPromotionHelp($id);
            $collected =  $promotion->collected + $data['amount'];
            $is_active = $collected >= $promotion->amount ? true : false;

            if ($collected >= $promotion->amount) {
                throw new InvalidArgumentException('Esta promoción ya alcanzó su meta de recaudación.');
            } elseif (days_pass($promotion->created_at) > 60) {
                throw new InvalidArgumentException('Esta promoción ya alcanzó su fecha de vencimiento (60 días).');
            }

            $promotion = $this->PromotionHelpRepository->updatePromotionHelp([ 'collected' => $collected], $id);
            $book = $this->BookRepository->updateBook(['is_active' => $is_active], $promotion->book_id);
            
            $data['promotion_help_id'] = $id;
            $data['book_id'] = $book->id;
            $result = $this->PromotionHelpUserRepository->storePromotionHelpUser($data);
        } catch (Exception $e) {
            DB::rollBack();
            Log::info($e->getMessage());

            throw new InvalidArgumentException($e->getMessage());
        }
        DB::commit();

        return $result;
    }
}
