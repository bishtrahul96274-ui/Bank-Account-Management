<?php

namespace App\Http\Controllers;

use App\Models\Account;
use App\Models\Transaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Throwable;

class First extends Controller
{
    public function home()
    {
        try {
            DB::connection()->getPdo();
        } catch (\Throwable $e) {
            return view('home')->with('db_warning', 'Database is not ready yet.');
        }

        return view('home');
    }

    public function about()
    {
        return view('about');
    }

    public function contact()
    {
        return view('contact');
    }

    public function acsummury()
    {
        $accounts = Account::all();
        $transactions = Transaction::latest('id')->limit(20)->get();

        return view('acsummury', [
            'accounts' => $accounts,
            'data' => $accounts,
            'transactions' => $transactions,
        ]);
    }

    // Create Account
    public function createac(Request $req)
    {
        if($req->submit)
        {
            $count = DB::table('account')->count();

            $ac = "SBI" . ($count + 101);

            DB::table('account')->insert([
                'acno'    => $ac,
                'pin'     => $req->pin,
                'name'    => $req->name,
                'fname'   => $req->fname,
                'email'   => $req->email,
                'phno'    => $req->phno,
                'gender'  => $req->gender,
                'country' => $req->country,
                'state'   => $req->state,
                'city'    => $req->city,
                'amount'  => $req->amount
            ]);

            return view('createac', [
                'msg' => "✅ Account Created Successfully",
                'ac'  => $ac
            ]);
        }

        return view('createac');
    }

    // Deposit
    public function deposit(Request $req)
    {
        if($req->submit)
        {
            $acno = $req->acno;
            $amt  = $req->amount;

            DB::update(
                "update account set amount = amount + ? where acno=?",
                [$amt,$acno]
            );

            return view('deposite',[
                'msg'=>"✅ Amount Deposited Successfully"
            ]);
        }

        return view('deposite');
    }

    // Withdraw
    public function withdraw(Request $req)
    {
        if($req->submit)
        {
            $acno = $req->acno;
            $amt  = $req->amount;

            $rs = DB::select(
                "select amount from account where acno=?",
                [$acno]
            );

            if($rs && $rs[0]->amount >= $amt)
            {
                DB::update(
                    "update account set amount = amount - ? where acno=?",
                    [$amt,$acno]
                );

                return view('withdraw',[
                    'msg'=>"✅ Amount Withdraw Successfully"
                ]);
            }

            return view('withdraw',[
                'msg'=>"❌ Insufficient Balance"
            ]);
        }

        return view('withdraw');
    }

    // Fund Transfer
    public function fundtransfer(Request $req)
    {
        if($req->submit)
        {
            $from = $req->fromac;
            $to   = $req->toac;
            $amt  = $req->amount;

            $rs = DB::select(
                "select amount from account where acno=?",
                [$from]
            );

            if($rs && $rs[0]->amount >= $amt)
            {
                DB::update(
                    "update account set amount = amount - ? where acno=?",
                    [$amt,$from]
                );

                DB::update(
                    "update account set amount = amount + ? where acno=?",
                    [$amt,$to]
                );

                return view('fundtransfer',[
                    'msg'=>"✅ Fund Transfer Successfully"
                ]);
            }

            return view('fundtransfer',[
                'msg'=>"❌ Insufficient Balance"
            ]);
        }

        return view('fundtransfer');
    }

    // Pin Change
    public function pinchange(Request $req)
    {
        if($req->submit)
        {
            DB::update(
                "update account set pin=? where acno=?",
                [$req->newpin,$req->acno]
            );

            return view('pinchange',[
                'msg'=>"✅ PIN Changed Successfully"
            ]);
        }

        return view('pinchange');
    }

    // Balance Inquiry
    public function balanceinq(Request $req)
    {
        if($req->submit)
        {
            $rs = DB::select(
                "select * from account where acno=?",
                [$req->acno]
            );

            return view('balanceinq',[
                'data'=>$rs
            ]);
        }

        return view('balanceinq');
    }

    // Account Summary
    public function acsummary()
    {
        $rs = DB::select("select * from account");

        return view('acsummary',[
            'data'=>$rs
        ]);
    }
}