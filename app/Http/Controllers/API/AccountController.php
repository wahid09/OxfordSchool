<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Resources\Account\BankAccountCollection;
use App\Http\Resources\Account\BankAccountResource;
use App\Models\BankAccount;
use Illuminate\Http\Request;

class AccountController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return new BankAccountCollection(BankAccount::with('organization')->latest()->paginate(12));
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
            'account_name'    => 'required',
            //'account_no'    => 'required|integer',
            //'branch'          => 'required',
            //'account_type'  => 'required',
            //'swift_code'  => 'required|integer',
            //'route_no'  => 'required',
        ]);

        $account = new BankAccount;
        $account->account_name = $request->account_name;

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
        //
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
