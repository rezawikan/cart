<?php

namespace App\Models;

use App\Models\Cashflow;
use Illuminate\Database\Eloquent\Model;

class Cashflow extends Model
{
	/**
	 * The attributes that are mass assignable.
	 *
	 * @var array
	 */
	protected $fillable = [
			'type', 'amount',  'total', 'info'
	];


	/**
	 * Block comment
	 *
	 * @param type
	 * @return void
	 */
	public static function boot()
	{
			parent::boot();

			static::creating(function ($cashflow) {
					$latest = Cashflow::latest()->first();

					if ($cashflow->type == 'debit') {
							$total = (empty($latest) ? 0 : $latest->total) + $cashflow->amount;
					} else {
							$total = (empty($latest) ? 0 : $latest->total) - $cashflow->amount;
					}

					$cashflow->total = $total;
			});
	}
}
