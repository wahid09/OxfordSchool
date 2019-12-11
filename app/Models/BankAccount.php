<?php

namespace App\Models;

use App\Models\FinancialOrganization;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class BankAccount extends Model
{
	use SoftDeletes;

	protected $fillable = [
		
	];
	
    public function organization(){

    	return $this->belongsTo(FinancialOrganization::class);
    }
}
