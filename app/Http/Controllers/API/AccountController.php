<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Resources\Account\BankAccountCollection;
use App\Http\Resources\Account\BankAccountResource;
use App\Models\BankAccount;
use Illuminate\Http\Request;

class AccountController extends Controller
{
    public function __construct(){
        $this->middleware('auth:api')->except('index', 'show');
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return new BankAccountCollection(BankAccount::with('organization')->latest()->paginate(10));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'account_name'    => 'required|unique:bank_accounts',
            'account_no'    => 'required|integer|unique:bank_accounts',
            'branch'          => 'required',
            'account_type'  => 'required',
            'swift_code'  => 'required|integer|unique:bank_accounts',
            'route_no'  => 'required',
        ]);

        $account = new BankAccount;
        $account->financialorganization_id = $request->organization;
        $account->account_name = $request->account_name;
        $account->account_no = $request->account_no;
        $account->branch = $request->branch;
        $account->account_type = $request->account_type;
        $account->swift_code = $request->swift_code;
        $account->route_no = $request->route_no;

        $account->save();

        return new BankAccountResource($account);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        return new BankAccountResource(BankAccount::findOrFail($id));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'account_name'    => 'required|unique:bank_accounts,account_name,'.$id,
            'account_no'    => 'required|integer|unique:bank_accounts,account_no,'.$id,
            'branch'          => 'required',
            'account_type'  => 'required',
            'swift_code'  => 'required|integer|unique:bank_accounts,swift_code,'.$id,
            'route_no'  => 'required',
        ]);

        $account = BankAccount::findOrFail($id);
        $account->financialorganization_id = $request->organization;
        $account->account_name = $request->account_name;
        $account->account_no = $request->account_no;
        $account->branch = $request->branch;
        $account->account_type = $request->account_type;
        $account->swift_code = $request->swift_code;
        $account->route_no = $request->route_no;

        $account->save();

        return new BankAccountResource($account);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $accounts = BankAccount::findOrFail($id);
        $accounts->delete();
        return new BankAccountResource($accounts);
    }
}
