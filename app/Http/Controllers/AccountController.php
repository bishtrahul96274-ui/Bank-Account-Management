<?php

namespace App\Http\Controllers;

use App\Models\Account;
use App\Models\Transaction;
use App\Models\User;
use Illuminate\Http\Request;

class AccountController extends Controller
{
    protected function resolveAccount($identifier)
    {
        if (is_numeric($identifier)) {
            return Account::find($identifier);
        }

        return Account::where('account_number', $identifier)->first();
    }

    public function createAccount(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email',
            'phone' => 'required|string|max:20',
            'amount' => 'required|numeric|min:0',
            'type' => 'required|in:savings,checking,business',
            'pin' => 'required|digits:4',
        ]);

        $user = User::firstOrCreate(
            ['email' => $validated['email']],
            [
                'name' => $validated['name'],
                'password' => bcrypt('password'),
                'mobile' => $validated['phone'],
            ]
        );

        if ($user->name !== $validated['name'] || $user->mobile !== $validated['phone']) {
            $user->fill([
                'name' => $validated['name'],
                'mobile' => $validated['phone'],
            ])->save();
        }

        $nextId = (Account::max('id') ?? 0) + 1;
        $accountNumber = 'ACC' . str_pad($nextId, 8, '0', STR_PAD_LEFT);

        $account = Account::create([
            'user_id' => $user->id,
            'account_number' => $accountNumber,
            'account_type' => $validated['type'],
            'balance' => $validated['amount'],
            'status' => 'active',
            'pin' => bcrypt($validated['pin']),
        ]);

        return back()->with('success', 'Account created successfully! Account Number: ' . $account->account_number);
    }

    public function deposit(Request $request)
    {
        $validated = $request->validate([
            'acno' => 'required_without:account_id',
            'account_id' => 'nullable',
            'amount' => 'required|numeric|min:0.01',
            'pin' => 'required|digits:4',
        ]);

        $account = $this->resolveAccount($validated['account_id'] ?? $validated['acno']);

        if (!$account) {
            return back()->with('error', 'Account not found');
        }

        if (!password_verify($validated['pin'], $account->pin)) {
            return back()->with('error', 'Invalid PIN');
        }

        $previousBalance = (float) $account->balance;
        $account->balance = $previousBalance + (float) $validated['amount'];
        $account->save();

        Transaction::create([
            'account_id' => $account->id,
            'type' => 'deposit',
            'amount' => $validated['amount'],
            'balance_before' => $previousBalance,
            'balance_after' => (float) $account->balance,
            'description' => 'Deposit',
        ]);

        return back()->with('success', 'Deposit successful!');
    }

    public function withdraw(Request $request)
    {
        $validated = $request->validate([
            'acno' => 'required_without:account_id',
            'account_id' => 'nullable',
            'amount' => 'required|numeric|min:0.01',
            'pin' => 'required|digits:4',
        ]);

        $account = $this->resolveAccount($validated['account_id'] ?? $validated['acno']);

        if (!$account) {
            return back()->with('error', 'Account not found');
        }

        if (!password_verify($validated['pin'], $account->pin)) {
            return back()->with('error', 'Invalid PIN');
        }

        if ((float) $account->balance < (float) $validated['amount']) {
            return back()->with('error', 'Insufficient balance');
        }

        $previousBalance = (float) $account->balance;
        $account->balance = $previousBalance - (float) $validated['amount'];
        $account->save();

        Transaction::create([
            'account_id' => $account->id,
            'type' => 'withdraw',
            'amount' => $validated['amount'],
            'balance_before' => $previousBalance,
            'balance_after' => (float) $account->balance,
            'description' => 'Withdrawal',
        ]);

        return back()->with('success', 'Withdrawal successful!');
    }

    public function transfer(Request $request)
    {
        $validated = $request->validate([
            'fromac' => 'required_without:from_account_id',
            'from_account_id' => 'nullable',
            'toac' => 'required_without:to_account_id',
            'to_account_id' => 'nullable',
            'amount' => 'required|numeric|min:0.01',
            'pin' => 'required|digits:4',
        ]);

        $fromAccount = $this->resolveAccount($validated['from_account_id'] ?? $validated['fromac']);
        $toAccount = $this->resolveAccount($validated['to_account_id'] ?? $validated['toac']);

        if (!$fromAccount || !$toAccount) {
            return back()->with('error', 'Account not found');
        }

        if ($fromAccount->acno === $toAccount->acno) {
            return back()->with('error', 'Cannot transfer to the same account');
        }

        if (!password_verify($validated['pin'], $fromAccount->pin)) {
            return back()->with('error', 'Invalid PIN');
        }

        if ((float) $fromAccount->balance < (float) $validated['amount']) {
            return back()->with('error', 'Insufficient balance');
        }

        $fromBalanceBefore = (float) $fromAccount->balance;
        $fromAccount->balance = $fromBalanceBefore - (float) $validated['amount'];
        $fromAccount->save();

        $toBalanceBefore = (float) $toAccount->balance;
        $toAccount->balance = $toBalanceBefore + (float) $validated['amount'];
        $toAccount->save();

        Transaction::create([
            'account_id' => $fromAccount->id,
            'type' => 'transfer',
            'amount' => $validated['amount'],
            'balance_before' => $fromBalanceBefore,
            'balance_after' => (float) $fromAccount->balance,
            'description' => 'Transfer to ' . $toAccount->acno,
        ]);

        Transaction::create([
            'account_id' => $toAccount->id,
            'type' => 'transfer',
            'amount' => $validated['amount'],
            'balance_before' => $toBalanceBefore,
            'balance_after' => (float) $toAccount->balance,
            'description' => 'Transfer from ' . $fromAccount->acno,
        ]);

        return back()->with('success', 'Transfer successful!');
    }

    public function changePin(Request $request)
    {
        $validated = $request->validate([
            'acno' => 'required_without:account_id',
            'account_id' => 'nullable',
            'oldpin' => 'required|digits:4',
            'newpin' => 'required|digits:4|different:oldpin',
            'confirm_pin' => 'required|same:newpin',
        ]);

        $account = $this->resolveAccount($validated['account_id'] ?? $validated['acno']);

        if (!$account) {
            return back()->with('error', 'Account not found');
        }

        if (!password_verify($validated['oldpin'], $account->pin)) {
            return back()->with('error', 'Old PIN is incorrect');
        }

        $account->pin = bcrypt($validated['newpin']);
        $account->save();

        return back()->with('success', 'PIN changed successfully!');
    }

    public function getAccountSummary($accountId)
    {
        $account = $this->resolveAccount($accountId);

        if (!$account) {
            abort(404);
        }

        $transactions = Transaction::where('account_id', $account->id)->orderBy('id', 'desc')->get();

        return view('acsummury', [
            'accounts' => collect([$account]),
            'data' => collect([$account]),
            'transactions' => $transactions,
        ]);
    }

    public function getBalance($accountId)
    {
        $account = $this->resolveAccount($accountId);

        if (!$account) {
            abort(404);
        }

        return back()->with('balance', 'Current Balance: ₹' . number_format($account->balance, 2));
    }

    public function transactionHistory($accountId)
    {
        $account = $this->resolveAccount($accountId);

        if (!$account) {
            abort(404);
        }

        $transactions = Transaction::where('account_id', $account->id)->orderBy('id', 'desc')->get();

        return view('acsummury', [
            'accounts' => collect([$account]),
            'data' => collect([$account]),
            'transactions' => $transactions,
        ]);
    }
}
