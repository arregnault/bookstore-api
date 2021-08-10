<?php

namespace App\Http\Repositories;

use App\Models\PromotionHelp;

class PromotionHelpRepository
{

   /**
    * @var PromotionHelp
    */
    protected $promotionHelp;

    /**
     * PromotionHelpRepository constructor.
     *
     * @param PromotionHelp $promotionHelp
     */
    public function __construct(PromotionHelp $promotionHelp)
    {
        $this->promotionHelp = $promotionHelp;
    }

    /**
     * Get all records.
     *
     * @return Collection $records
     */
    public function getAll($data = [])
    {
        $records = $this->promotionHelp->get();
        return $records;
    }

    /**
     * Store PromotionHelp
     *
     * @param array $data
     * @return PromotionHelp $record
     */
    public function storePromotionHelp($data)
    {
        $record = $this->promotionHelp::create([
            'amount'              =>  $data['amount'],
            'book_id'             =>  $data['book_id'],
        ]);

        return $record;
    }


    /**
     * Show PromotionHelp
     *
     * @param integer $id
     * @return PromotionHelp
     */
    public function showPromotionHelp($id)
    {
        $record = $this->promotionHelp::findOrFail($id);

        return $record;
    }

    /**
     * Update PromotionHelp
     *
     * @param array $data
     * @param integer $id
     * @return PromotionHelp $record
     */
    public function updatePromotionHelp($data, $id)
    {
        $record = $this->promotionHelp::findOrFail($id);

        $record->update([
            'amount'              =>  $data['amount']     ?? $record->amount,
            'collected'           =>  $data['collected']  ?? $record->collected,
            'book_id'             =>  $data['book_id']    ?? $record->book_id,
        ]);

        return $record->fresh();
    }

    /**
     * Delete PromotionHelp
     *
     * @param integer $id
     * @return PromotionHelp $record
     */
    public function destroyPromotionHelp($id)
    {
        $record = $this->promotionHelp::findOrFail($id);

        $record->delete();
    }
}
