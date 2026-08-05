@include('nav')

<div class="row justify-content-center">
    <div class="col-md-8 col-lg-7">
        <div class="card page-card p-4">
            <h2 class="fw-bold mb-3 text-info">💳 Transfer Funds</h2>
            <p class="text-secondary mb-4">Securely move money between accounts with confidence.</p>

            @if(session('success'))
                <div class="alert alert-success">{{ session('success') }}</div>
            @endif
            @if(session('error'))
                <div class="alert alert-danger">{{ session('error') }}</div>
            @endif

            <form action="/account/transfer" method="post" class="row g-3">
                @csrf
                <div class="col-md-6">
                    <label class="form-label">From Account</label>
                    <input type="text" name="fromac" placeholder="ACC00000001" class="form-control" required>
                </div>
                <div class="col-md-6">
                    <label class="form-label">To Account</label>
                    <input type="text" name="toac" placeholder="ACC00000002" class="form-control" required>
                </div>
                <div class="col-12">
                    <label class="form-label">Amount</label>
                    <input type="number" step="0.01" name="amount" placeholder="Enter amount" class="form-control" required>
                </div>
                <div class="col-12">
                    <label class="form-label">Source Account PIN</label>
                    <input type="password" name="pin" placeholder="Enter PIN" class="form-control" required>
                </div>
                <div class="col-12">
                    <button type="submit" class="btn btn-info btn-brand w-100">Transfer Now</button>
                </div>
            </form>
        </div>
    </div>
</div>
</body>
</html>