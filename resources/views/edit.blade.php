@include('nav')

<div class="row justify-content-center">
    <div class="col-md-6">
        <div class="card page-card p-4">
            <h3 class="fw-bold mb-3">Edit Student</h3>
            <p class="text-secondary mb-4">Update the student record details in a clean and modern form.</p>

            @if ($errors->any())
                <div class="alert alert-danger">
                    <ul class="mb-0">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form action="/edit/{{ $student->id }}" method="post" class="row g-3">
                @csrf
                <div class="col-12">
                    <label class="form-label">Name</label>
                    <input type="text" name="name" class="form-control" value="{{ old('name', $student->name) }}">
                </div>
                <div class="col-12">
                    <label class="form-label">Course</label>
                    <input type="text" name="course" class="form-control" value="{{ old('course', $student->course) }}">
                </div>
                <div class="col-12">
                    <button type="submit" class="btn btn-primary btn-brand w-100">Update Student</button>
                </div>
            </form>
        </div>
    </div>
</div>
</body>
</html>
