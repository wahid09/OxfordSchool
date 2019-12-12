<?php

namespace App\Models;

use App\Models\FinancialOrganization;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class BankAccount extends Model
{
	use SoftDeletes;

	protected $table = "bank_accounts";

	protected $fillable = [
		'financialorganization_id', 'store_id', 'account_name', 'account_no', 'branch', 'account_type', 'swift_code', 'route_no',
	];
	
    public function organization(){

    	return $this->belongsTo('App\Models\FinancialOrganization', 'financialorganization_id', 'id');
    }
}
