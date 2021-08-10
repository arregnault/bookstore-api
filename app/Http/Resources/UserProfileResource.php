<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class UserProfileResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'id'                => $this->id,
            'name'              => $this->name,
            'email'             => $this->email,
            'account_balance'   => $this->account_balance,
            'role'              => $this->role->name,
            'member_since'      => $this->created_at,
            'n_transactions'    => $this->transactions()->count(),
        ];
    }
}
