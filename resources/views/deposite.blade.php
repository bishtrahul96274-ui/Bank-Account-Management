@include('nav')

<div class="row justify-content-center">
    <div class="col-12 col-md-8 col-lg-6">
        <div class="card page-card p-4 shadow-sm">
            <div class="d-flex align-items-start justify-content-between">
                <div>
                    <h2 class="fw-bold mb-1 text-success">💰 Deposit Money</h2>
                    <p class="text-muted mb-3">Instantly add funds — choose a quick amount or enter a custom value.</p>
                </div>
                <div class="text-end">
                    <small class="text-secondary">Current balance</small>
                    <div id="available-balance" class="fw-semibold fs-5">—</div>
                </div>
            </div>

            @if(session('success'))
                <div class="alert alert-success mt-3">{{ session('success') }}</div>
            @endif
            @if(session('error'))
                <div class="alert alert-danger mt-3">{{ session('error') }}</div>
            @endif

            <form id="deposit-form" action="/account/deposit" method="post" class="row g-3 mt-2">
                @csrf
                <div class="col-12">
                    <label class="form-label">Account Number</label>
                    <input id="acno" type="text" name="acno" placeholder="ACC00000001" class="form-control" required>
                </div>

                <div class="col-12">
                    <label class="form-label">Quick Amounts</label>
                    <div class="d-flex gap-2">
                        <button type="button" class="btn btn-outline-secondary quick-amt">100</button>
                        <button type="button" class="btn btn-outline-secondary quick-amt">500</button>
                        <button type="button" class="btn btn-outline-secondary quick-amt">1000</button>
                        <button type="button" class="btn btn-outline-secondary quick-amt">5000</button>
                    </div>
                </div>

                <div class="col-12">
                    <label class="form-label">Deposit Amount</label>
                    <div class="input-group">
                        <span class="input-group-text">RS</span>
                        <input id="amount" type="number" step="0.01" name="amount" placeholder="0.00" class="form-control" required>
                    </div>
                </div>

                <div class="col-12 col-md-8">
                    <label class="form-label">PIN</label>
                    <input id="pin" type="password" name="pin" placeholder="Enter PIN" class="form-control" required>
                </div>

                <div class="col-12 col-md-4 d-flex align-items-end">
                    <button id="preview-btn" type="button" class="btn btn-outline-primary w-100">Preview</button>
                </div>

                <div class="col-12">
                    <label class="form-label">Note (optional)</label>
                    <input type="text" name="description" placeholder="Reason or note" class="form-control">
                </div>

                <div class="col-12">
                    <button id="submit-btn" type="submit" class="btn btn-success btn-brand w-100">Deposit Funds</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function () {
    const quickBtns = document.querySelectorAll('.quick-amt');
    const amountInput = document.getElementById('amount');
    const acnoInput = document.getElementById('acno');
    const previewBtn = document.getElementById('preview-btn');
    const availableBalanceEl = document.getElementById('available-balance');

    quickBtns.forEach(btn => btn.addEventListener('click', function () {
        amountInput.value = this.textContent.trim();
    }));

    previewBtn.addEventListener('click', function () {
        const acno = acnoInput.value.trim();
        const amount = parseFloat(amountInput.value);
        if (!acno) { alert('Please enter account number.'); acnoInput.focus(); return; }
        if (!amount || amount <= 0) { alert('Enter a valid deposit amount.'); amountInput.focus(); return; }
        if (!confirm('Confirm deposit of $' + amount.toFixed(2) + ' to ' + acno + '?')) return;
        alert('Preview OK — submit to complete.');
    });

    acnoInput.addEventListener('blur', function () {
        const acno = this.value.trim();
        if (!acno) { availableBalanceEl.textContent = '—'; return; }
        fetch('/api/account/' + encodeURIComponent(acno) + '/balance')
            .then(r => { if (!r.ok) throw new Error('no'); return r.json(); })
            .then(data => {
                if (data && data.balance !== undefined) availableBalanceEl.textContent = '$' + parseFloat(data.balance).toFixed(2);
                else availableBalanceEl.textContent = '—';
            })
            .catch(()=>{ availableBalanceEl.textContent = '—'; });
    });
});
</script>

</body>
</html>