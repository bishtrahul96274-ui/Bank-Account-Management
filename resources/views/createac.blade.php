@include('nav')

<div class="row justify-content-center">
    <div class="col-xl-8 col-lg-9">
        <div class="card page-card p-4">
            <div class="d-flex flex-column flex-md-row align-items-center justify-content-between mb-4">
                <div>
                    <h2 class="fw-bold mb-1">🧾 Create Your Account</h2>
                    <p class="text-secondary mb-0">Start banking quickly with a secure account setup.</p>
                </div>
            </div>

            @if ($errors->any())
                <div class="alert alert-danger">
                    <ul class="mb-0">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            @if(session('success'))
                <div class="alert alert-success">{{ session('success') }}</div>
            @endif

            @if(session('error'))
                <div class="alert alert-danger">{{ session('error') }}</div>
            @endif

            <form action="/account/create" method="post" class="row g-3">
                @csrf

                <div class="col-md-6">
                    <label class="form-label">Customer Name</label>
                    <input type="text" name="name" value="{{ old('name') }}" class="form-control" placeholder="Enter full name" required>
                </div>

                <div class="col-md-6">
                    <label class="form-label">Father's Name</label>
                    <input type="text" name="father_name" value="{{ old('father_name') }}" class="form-control" placeholder="Enter father's name" required>
                </div>

                <div class="col-md-6">
                    <label class="form-label">Email Address</label>
                    <input type="email" name="email" value="{{ old('email') }}" class="form-control" placeholder="Enter email address" required>
                </div>

                <div class="col-md-6">
                    <label class="form-label">Phone Number</label>
                    <input type="text" name="phone" value="{{ old('phone') }}" class="form-control" placeholder="Enter phone number" required>
                </div>

                <div class="col-md-4">
                    <label class="form-label">Account Type</label>
                    <select name="type" class="form-select" required>
                        <option value="savings" {{ old('type') == 'savings' ? 'selected' : '' }}>Savings</option>
                        <option value="checking" {{ old('type') == 'checking' ? 'selected' : '' }}>Checking</option>
                        <option value="business" {{ old('type') == 'business' ? 'selected' : '' }}>Business</option>
                    </select>
                </div>

                <div class="col-md-4">
                    <label class="form-label">Gender</label>
                    <select name="gender" class="form-select">
                        <option value="male">Male</option>
                        <option value="female">Female</option>
                    </select>
                </div>

                <div class="col-md-4">
                    <label class="form-label">Country</label>
                    <input type="text" name="country" value="{{ old('country') }}" class="form-control" placeholder="Country" required>
                </div>

                <div class="col-md-4">
                    <label class="form-label">State</label>
                    <input type="text" name="state" value="{{ old('state') }}" class="form-control" placeholder="State" required>
                </div>

                <div class="col-md-4">
                    <label class="form-label">City</label>
                    <input type="text" name="City" value="{{ old('City') }}" class="form-control" placeholder="City" required>
                </div>

                <div class="col-md-4">
                    <label class="form-label">Initial Deposit</label>
                    <input type="number" step="0.01" name="amount" value="{{ old('amount') }}" class="form-control" placeholder="Amount" required>
                </div>

                <div class="col-md-6">
                    <label class="form-label">Account PIN</label>
                    <input type="password" name="pin" class="form-control" placeholder="4-digit PIN" required>
                </div>

                <div class="col-12">
                    <button type="submit" class="btn btn-success btn-brand w-100">✅ Create Account</button>
                </div>
            </form>
        </div>
    </div>
</div>
</body>
</html>