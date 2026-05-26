@extends('layouts.admin')

@section('content')
    <style>
        body { font-family: 'Inter', sans-serif; background-color: #f8f9fa; color: #333; margin: 0; }
        .main { margin-left: 260px; padding: 30px; }
        .enrollment-paper { background: white; box-shadow: 0 10px 30px rgba(0,0,0,0.05); max-width: 900px; margin: 0 auto; border-radius: 15px; overflow: hidden; border: 1px solid #eef2f6; }
        .form-header-main { background-color: #0d6efd; color: white; padding: 25px; text-align: center; }
        .form-body { padding: 40px; }
        .section-header { color: #0d6efd; font-weight: 700; border-bottom: 2px solid #0d6efd; padding-bottom: 5px; margin-bottom: 25px; margin-top: 10px; font-size: 1.1rem; text-transform: uppercase; letter-spacing: 0.5px; }
        .reg-label { font-size: 0.75rem; font-weight: 700; color: #555; margin-bottom: 6px; display: block; text-transform: uppercase; }
        .form-control, .form-select { border: 1px solid #ced4da; border-radius: 6px; padding: 10px 15px; font-size: 0.9rem; background-color: #fcfcfc; }
        
        .photo-space { border: 2px dashed #dee2e6; width: 120px; height: 140px; display: flex; flex-direction: column; align-items: center; justify-content: center; cursor: pointer; transition: 0.2s; background: #f8f9fa; border-radius: 10px; margin: 0 auto; position: relative; overflow: hidden; }
        .photo-space:hover { background: #eef2f6; border-color: #0d6efd; }
        .photo-preview-img { width: 100%; height: 100%; object-fit: cover; border-radius: 10px; }

        .submit-bar { background: #f8f9fa; padding: 20px 40px; border-top: 1px solid #eef2f6; text-align: right; display: flex; justify-content: flex-end; gap: 15px; }
        .btn-edu { background-color: #0d6efd; color: white; padding: 12px 35px; font-weight: 700; border-radius: 8px; border: none; transition: 0.3s; }
        .btn-edu:hover { background-color: #004494; transform: translateY(-2px); }
    </style>
</head>
<body>


    <div class="main">
        <div class="topbar d-flex justify-content-between align-items-center mb-4">
            <div class="d-flex align-items-center gap-3">
                <button class="menu-toggle d-lg-none" id="toggleBtn"><i class="bi bi-list fs-4"></i></button>
                <h4 class="mb-0 fw-bold">Edit Student</h4>
            </div>
        </div>

        <div class="mb-4">
            <a href="{{ route('admin.students.index') }}" class="text-decoration-none small text-muted"><i class="bi bi-arrow-left"></i> Back to Student List</a>
        </div>

        @if ($errors->any())
            <div class="alert alert-danger mx-auto mb-4" style="max-width: 900px;">
                <ul class="mb-0">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <div class="enrollment-paper">
            <div class="form-header-main">
                <h4 class="mb-0 fw-bold">Student Profile Edit</h4>
                <p class="mb-0 small opacity-75">Student ID: {{ $student->student_no }}</p>
            </div>

          <form action="{{ route('admin.students.update', $student->id) }}" method="POST" enctype="multipart/form-data">
    @csrf
    @method('PUT')

                <input type="hidden" name="student_no" value="{{ $student->student_no }}">

                <div class="form-body">
                    <div class="row">
                        <div class="col-md-9">
                            <div class="section-header">Student Information</div>
                            <div class="row g-3">
                                
                                <div class="col-md-6">
                                    <label class="reg-label">First Name</label>
                                    @php
                                        // အကယ်၍ database ထဲမှာ first_name သီးသန့်ရှိရင် ယူမယ်။ မရှိရင် တိုင်ပတ်မသွားအောင် name ထဲက ဖြတ်ယူမယ်
                                        $fullNameClean = trim($student->name);
                                        $firstNameParts = explode(' ', $fullNameClean);
                                        $firstNameFallback = $firstNameParts[0] ?? '';
                                    @endphp
                                    <input type="text" name="first_name" class="form-control" 
                                           value="{{ old('first_name', $student->first_name ?? $firstNameFallback) }}" required>
                                </div>
                                            
                                <div class="col-md-6">
                                    <label class="reg-label">Last Name</label>
                                    @php
                                        // နာမည်ထဲမှာ space ပါမှ ကျန်တဲ့အပိုင်းကို last_name အဖြစ် ယူမယ်၊ မဟုတ်ရင် empty ပြထားမယ်
                                        $nameParts = explode(' ', trim($student->name));
                                        $lastNameFallback = count($nameParts) > 1 ? implode(' ', array_slice($nameParts, 1)) : '';
                                    @endphp
                                    <input type="text" name="last_name" class="form-control" 
                                           value="{{ old('last_name', $student->last_name ?? $lastNameFallback) }}">
                                </div>

                                <div class="col-md-6">
                                    <label class="reg-label">Date of Birth</label>
                                    <input type="date" name="dob" class="form-control" value="{{ old('dob', $student->dob) }}">
                                </div>

                                <div class="col-md-6">
    <label class="reg-label">Gender</label>
    <div class="pt-2">
        <div class="form-check form-check-inline">
            <input class="form-check-input" type="radio" name="gender" id="m" value="Male" 
                {{ strtolower(old('gender', $student->gender ?? '')) == 'male' ? 'checked' : '' }}>
            <label class="form-check-label small fw-bold" for="m">Male</label>
        </div>
        <div class="form-check form-check-inline">
            <input class="form-check-input" type="radio" name="gender" id="f" value="Female" 
                {{ strtolower(old('gender', $student->gender ?? '')) == 'female' ? 'checked' : '' }}>
            <label class="form-check-label small fw-bold" for="f">Female</label>
        </div>
    </div>
</div>
                            </div>
                        </div>

                        <div class="col-md-3 text-center">
                            <label class="reg-label">Student Photo</label>
                            <div class="photo-space" id="photo-dropzone" onclick="document.getElementById('file-input').click()">
                                @if($student->photo && \Storage::disk('public')->exists($student->photo))
                                    <img id="photo-preview" src="{{ asset('storage/' . $student->photo) }}" class="photo-preview-img">
                                    <i class="bi bi-camera fs-2 text-muted" id="upload-icon" style="display: none;"></i>
                                    <span class="small text-muted" id="upload-text" style="display: none;">Change Photo</span>
                                @else
                                    <img id="photo-preview" class="photo-preview-img" style="display: none;">
                                    <i class="bi bi-camera fs-2 text-muted" id="upload-icon"></i>
                                    <span class="small text-muted" id="upload-text">Upload Photo</span>
                                @endif
                                <input type="file" name="photo" id="file-input" hidden accept="image/*">
                            </div>
                        </div>
                    </div>

                    <div class="row mt-3">
                        <div class="col-md-6">
                            <label class="reg-label">Contact Number</label>
                            <input type="text" name="phone" class="form-control" value="{{ old('phone', $student->phone) }}" placeholder="Phone Number">
                        </div>
                        <div class="col-md-6">
                            <label class="reg-label">Email Address</label>
                            <input type="email" name="email" class="form-control" value="{{ old('email', $student->email) }}" required>
                        </div>
                        <div class="col-12 mt-3">
                            <label class="reg-label">Home Address</label>
                            <input type="text" name="address" class="form-control" value="{{ old('address', $student->address) }}">
                        </div>
                    </div>

                    <div class="section-header mt-5">Parent / Guardian Information</div>
                    <div class="row g-3">
                        <div class="col-md-8">
                            <label class="reg-label">Guardian Full Name</label>
                            <input type="text" name="guardian_name" class="form-control" value="{{ old('guardian_name', $student->guardian_name) }}">
                        </div>
                        <div class="col-md-4">
                            <label class="reg-label">Relationship</label>
                            <input type="text" name="relationship" class="form-control" value="{{ old('relationship', $student->relationship) }}">
                        </div>
                        <div class="col-md-6">
                            <label class="reg-label">Guardian Contact</label>
                            <input type="text" name="guardian_phone" class="form-control" value="{{ old('guardian_phone', $student->guardian_phone) }}">
                        </div>
                        <div class="col-md-6">
                            <label class="reg-label">Guardian Email</label>
                            <input type="email" name="guardian_email" class="form-control" value="{{ old('guardian_email', $student->guardian_email) }}">
                        </div>
                    </div>

                    <div class="section-header mt-5">Academic Information</div>
                    <div class="row g-3">
                        <div class="col-md-6">
                            <label class="reg-label">Grade Level</label>
                            <select name="grade" class="form-select" required>
                                <option value="Grade 9" {{ old('grade', $student->grade) == 'Grade 9' ? 'selected' : '' }}>Grade 9</option>
                                <option value="Grade 10" {{ old('grade', $student->grade) == 'Grade 10' ? 'selected' : '' }}>Grade 10</option>
                                <option value="Grade 11" {{ old('grade', $student->grade) == 'Grade 11' ? 'selected' : '' }}>Grade 11</option>
                                <option value="Grade 12" {{ old('grade', $student->grade) == 'Grade 12' ? 'selected' : '' }}>Grade 12</option>
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label class="reg-label">Assign Class Room</label>
                            <select name="class_id" class="form-select">
                                <option value="">Select Class</option>
                                @foreach($classes as $class)
                                    <option value="{{ $class->id }}" {{ (old('class_id') ?? ($student->classes->first()->id ?? '')) == $class->id ? 'selected' : '' }}>
                                        {{ $class->class_name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label class="reg-label">Previous School</label>
                            <input type="text" name="previous_school" class="form-control" value="{{ old('previous_school', $student->previous_school) }}">
                        </div>
                        <div class="col-md-6">
                            <label class="reg-label">Account Status</label>
                            <select name="status" class="form-select">
                                <option value="active" {{ old('status', $student->status) == 'active' ? 'selected' : '' }}>Active</option>
                                <option value="pending" {{ old('status', $student->status) == 'pending' ? 'selected' : '' }}>Pending</option>
                                <option value="inactive" {{ old('status', $student->status) == 'inactive' ? 'selected' : '' }}>Inactive</option>
                            </select>
                        </div>
                    </div>
                </div>

                <div class="submit-bar">
                    <a href="{{ route('admin.students.index') }}" class="btn btn-light fw-bold border px-4">Cancel</a>
                    <button type="submit" class="btn btn-edu px-4 text-white">Update Student Profile</button>
                </div>
            </form>
        </div>
    </div>

    <script>
        // Photo Live Preview Script
        document.getElementById('file-input').onchange = function (evt) {
            const [file] = this.files;
            if (file) {
                const preview = document.getElementById('photo-preview');
                const icon = document.getElementById('upload-icon');
                const text = document.getElementById('upload-text');
                
                preview.src = URL.createObjectURL(file);
                preview.style.display = 'block';
                icon.style.display = 'none';
                text.style.display = 'none';
            }
        };
    </script>
</body>
</html>