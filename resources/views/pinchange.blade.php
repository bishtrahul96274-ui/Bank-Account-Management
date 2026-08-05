@include('nav')

<div class="row justify-content-center">
    <div class="col-md-7 col-lg-6">
        <div class="card page-card p-4">
            <h2 class="fw-bold mb-3 text-dark">🔐 Change PIN</h2>
            <p class="text-secondary mb-4">Update your account PIN quickly and securely.</p>

            @if(session('success'))
                <div class="alert alert-success">{{ session('success') }}</div>
            @endif
            @if(session('error'))
                <div class="alert alert-danger">{{ session('error') }}</div>
            @endif

            <form action="/account/change-pin" method="post" class="row g-3">
                @csrf
                <div class="col-12">
                    <label class="form-label">Account Number</label>
                    <input type="text" name="acno" class="form-control" placeholder="ACC00000001" required>
                </div>
                <div class="col-12">
                    <label class="form-label">Current PIN</label>
                    <input type="password" name="oldpin" class="form-control" placeholder="Old PIN" required>
                </div>
                <div class="col-12 col-md-6">
                    <label class="form-label">New PIN</label>
                    <input type="password" name="newpin" class="form-control" placeholder="New PIN" required>
                </div>
                <div class="col-12 col-md-6">
                    <label class="form-label">Confirm PIN</label>
                    <input type="password" name="confirm_pin" class="form-control" placeholder="Confirm New PIN" required>
                </div>
                <div class="col-12">
                    <button type="submit" class="btn btn-dark btn-brand w-100">Change PIN</button>
                </div>
            </form>
        </div>
    </div>
</div>
</body>
</html>