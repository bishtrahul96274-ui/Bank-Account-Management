@include('nav')

<div class="row g-4">
    <div class="col-xl-8">
        <div class="card page-card p-4">
            <div class="d-flex flex-column flex-md-row align-items-start align-items-md-center justify-content-between mb-4">
                <div>
                    <h2 class="fw-bold mb-1 text-primary">📘 Account Summary</h2>
                    <p class="text-secondary mb-0">Review your accounts and recent activity in one clean dashboard.</p>
                </div>
                <a href="/createac" class="btn btn-outline-primary btn-brand">Open New Account</a>
            </div>

            @php
                $records = $accounts ?? $data ?? collect();
            @endphp

            @if($records->isEmpty())
                <div class="alert alert-warning text-center">
                    <p>No accounts found. <a href="/createac">Create an account</a> first.</p>
                </div>
            @else
                <div class="table-responsive">
                    <table class="table align-middle mb-0">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Account</th>
                                <th>Name</th>
                                <th>Email</th>
                                <th>Phone</th>
                                <th>Type</th>
                                <th>Balance</th>
                                <th>Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($records as $d)
                                <tr>
                                    <td>{{ $d->id }}</td>
                                    <td>{{ $d->acno ?? $d->account_number ?? 'N/A' }}</td>
                                    <td>{{ $d->name ?? ($d->user->name ?? 'N/A') }}</td>
                                    <td>{{ $d->email ?? ($d->user->email ?? 'N/A') }}</td>
                                    <td>{{ $d->phone ?? ($d->user->mobile ?? 'N/A') }}</td>
                                    <td>{{ $d->type ?? $d->account_type ?? 'N/A' }}</td>
                                    <td class="text-success">₹{{ number_format($d->balance ?? 0, 2) }}</td>
                                    <td>{{ ucfirst($d->status ?? 'N/A') }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @endif
        </div>
    </div>

    <div class="col-xl-4">
        <div class="card page-card p-4 h-100">
            <h4 class="fw-bold mb-3">Recent Transactions</h4>
            @php $transactions = $transactions ?? collect(); @endphp
            @if($transactions->isEmpty())
                <div class="alert alert-info mb-0">
                    No transactions available yet.
                </div>
            @else
                <div class="table-responsive">
                    <table class="table table-borderless mb-0">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Account</th>
                                <th>Type</th>
                                <th>Amount</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($transactions as $transaction)
                                <tr>
                                    <td>{{ $transaction->id }}</td>
                                    <td>{{ $transaction->acno ?? 'N/A' }}</td>
                                    <td>{{ ucfirst($transaction->type ?? $transaction->ttype ?? 'N/A') }}</td>
                                    <td>₹{{ number_format($transaction->amount ?? 0, 2) }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @endif
        </div>
    </div>
</div>
</body>
</html>