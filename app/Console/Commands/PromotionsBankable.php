<?php

namespace App\Console\Commands;

use Exception;
use InvalidArgumentException;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

use Illuminate\Console\Command;
use App\Events\NewIdeasPromotionEvent;
use App\Models\PromotionHelp;
use App\Models\PromotionHelpUser;
use App\Models\User;

class PromotionsBankable extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'promotions:bankable';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Revisa el periodo vigente de las promociones y autoriza a aquellas que lograron recaudar el 60% del monto solicitado en menos de 30 días para un posible financimiento por tienda';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        DB::beginTransaction();
        Log::info('Revisar promociones completadas en menois de 30 días');
        try {
            $days = 30;
            $progress = 60;
            $promotion_ids = PromotionHelp::cursor()->filter(function ($promotion) use ($days, $progress) {
                $collected = ($promotion->collected * 100) / $promotion->amount;
                return days_pass($promotion->created_at) < $days &&  $collected >= $progress;
            })->pluck('id');
            

            $promotions = PromotionHelp::whereIn('id', $promotion_ids)->update(['is_bankable' => true]);
            $promotions = PromotionHelp::with(['book.author'])->whereIn('id', $promotion_ids)->get();

            foreach ($promotions ?? [] as $key => $reservation) {
                $user_ids = PromotionHelpUser::where('promotion_help_id', $reservation)->pluck('user_id');
                $emails = User::whereIn('id', $user_ids)->pluck('email');

                event(new NewIdeasPromotionEvent($reservation['book']['author'], $emails));
            }
        } catch (Exception $e) {
            DB::rollBack();
            Log::info($e->getMessage());

            throw new InvalidArgumentException($e->getMessage());
        }
        DB::commit();
    }
}
