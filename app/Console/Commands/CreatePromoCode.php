<?php

namespace App\Console\Commands;

use App\Discount;
use App\PromoCode;
use Illuminate\Console\Command;

class CreatePromoCode extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'promo:create
                            {code : The unique code name}
                            {--max-uses=1 : The amount of times the code can be used}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create a new promotional code';

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
     * @return mixed
     */
    public function handle()
    {
        $codeName = $this->argument('code');
        // Name uniqueness
        if (PromoCode::findByName($codeName))
        {
            $this->error('This code name is already in use.');
            return;
        }
        // There should be some discounts available
        $discountNames = Discount::all()->map(function ($discount) {
            return $discount->name;
        });
        if ($discountNames->count() === 0)
        {
            $this->error('There is no discount available!');
            return;
        }

        $discount = Discount::findByName($this->choice('Which discount will the code apply?', $discountNames->all()));
        PromoCode::create([
            'name' => $codeName,
            'discount_id' => $discount->id,
            'max_uses' => $this->option('max-uses'),
            'begin_at' => now(),
            'end_at' => now()->addMonth(),
        ]);
        $this->line('Starting date set to today.');
        $this->line('Expiring date set to +1 month.');
        $this->info("Promotional code {$codeName} created successfully!");
    }
}
