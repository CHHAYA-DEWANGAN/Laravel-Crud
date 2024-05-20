<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
Use App\LoanDetail;

class LoanDetailController extends Controller
{
    public function login(Request $request){

        $credentials=['username'=>$request['username'],'password'=>$request['password']];
        if(auth()->attempt($credentials))
        return redirect()->route('loan-details');
        else 
        return redirect()->back()->withErrors("invalid crendials");
    }

    public function loan(){
        $loanDetails = LoanDetail::all(); 
        return view('test.loan_details', compact('loanDetails'));
    }
}
