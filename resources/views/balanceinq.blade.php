@include('nav')

<div class="row justify-content-center">
    <div class="col-xl-10">
        <div class="card page-card p-4">
            <div class="d-flex flex-column flex-md-row align-items-center justify-content-between mb-4">
                <div>
                    <h2 class="fw-bold mb-1 text-info">📊 Balance Inquiry</h2>
                    <p class="text-secondary mb-0">Review current balances across all active accounts.</p>
                </div>
                <a href="/createac" class="btn btn-outline-primary btn-brand">Open new account</a>
            </div>

            @php $accounts = \App\Models\Account::all(); @endphp
            @if($accounts->isEmpty())
                <div class="alert alert-warning text-center">
                    <p>No accounts found. <a href="/createac">Create an account</a> first.</p>
                </div>
            @else
                <div class="row g-3">
                    @foreach($accounts as $account)
                        <div class="col-md-6 col-xl-4">
                            <div class="card h-100 border-0 shadow-sm p-4">
                                <div class="d-flex justify-content-between align-items-start mb-3">
                                    <div>
                                        <h5 class="mb-1">{{ $account->account_number }}</h5>
                                        <small class="text-muted">{{ ucfirst($account->account_type) }}</small>
                                    </div>
                                    <span class="badge bg-success badge-pill">{{ ucfirst($account->status) }}</span>
                                </div>
                                <div class="mt-4">
                                    <h3 class="fw-bold">₹{{ number_format($account->balance, 2) }}</h3>
                                    <p class="text-secondary mb-0">Available Balance</p>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            @endif
        </div>
    </div>
</div>
</body>
</html>