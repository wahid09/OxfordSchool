<?php

namespace App\Models;

use App\Models\BankAccount;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class FinancialOrganization extends Model
{
	use SoftDeletes;

	protected $table = "financial_organizations";

	protected $fillable = [
		'name', 'short_name', 'address'
	];

    public function accounts(){

    	return $this->hasMany(BankAccount::class);
    }
}
