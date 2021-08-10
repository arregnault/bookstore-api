<?php

namespace App\Http\Repositories;

use App\Models\PromotionHelpUser;

class PromotionHelpUserRepository
{

   /**
    * @var PromotionHelpUser
    */
    protected $promotionHelpUser;

    /**
     * PromotionHelpUserRepository constructor.
     *
     * @param PromotionHelpUser $promotionHelpUser
     */
    public function __construct(PromotionHelpUser $promotionHelpUser)
    {
        $this->promotionHelpUser = $promotionHelpUser;
    }

    /**
     * Get all records.
     *
     * @return Collection $records
     */
    public function getAll()
    {
        $records = $this->promotionHelpUser->get();
        return $records;
    }

    /**
     * Store PromotionHelpUser
     *
     * @param array $data
     * @return PromotionHelpUser $record
     */
    public function storePromotionHelpUser($data)
    {
        $record = $this->promotionHelpUser::create([
            'amount'              =>  $data['amount'],
            'user_id'             =>  $data['user_id'],
            'promotion_help_id'   =>  $data['promotion_help_id'],
        ]);

        return $record;
    }


    /**
     * Show PromotionHelpUser
     *
     * @param integer $id
     * @return PromotionHelpUser
     */
    public function showPromotionHelpUser($id)
    {
        $record = $this->promotionHelpUser::findOrFail($id);

        return $record;
    }

    /**
     * Update PromotionHelpUser
     *
     * @param array $data
     * @param integer $id
     * @return PromotionHelpUser $record
     */
    public function updatePromotionHelpUser($data, $id)
    {
        $record = $this->promotionHelpUser::findOrFail($id);

        $record->update([
            'amount'              =>  $data['amount']               ?? $record->amount,
            'user_id'             =>  $data['user_id']              ?? $record->user_id,
            'promotion_help_id'   =>  $data['promotion_help_id']    ?? $record->promotion_help_id,
        ]);

        return $record->fresh();
    }

    /**
     * Delete PromotionHelpUser
     *
     * @param integer $id
     * @return PromotionHelpUser $record
     */
    public function destroyPromotionHelpUser($id)
    {
        $record = $this->promotionHelpUser::findOrFail($id);

        $record->delete();
    }
}
