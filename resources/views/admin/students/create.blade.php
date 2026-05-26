@extends('layouts.admin')

@section('content')

    <style>
        :root{
            --edu-blue:#0d6efd;
            --bg-body:#f4f7fb;
            --text-main:#2c3e50;
        }

        body{
            font-family:'Inter',sans-serif;
            background:var(--bg-body);
            color:var(--text-main);
            margin:0;
        }

        .main{
            margin-left:260px;
            padding:30px;
        }

        .enrollment-paper{
            background:#fff;
            max-width:950px;
            margin:auto;
            border-radius:18px;
            overflow:hidden;
            border:1px solid #edf1f5;
            box-shadow:0 15px 40px rgba(0,0,0,0.05);
        }

        .form-header-main{
            background:linear-gradient(135deg,#0d6efd,#0047b3);
            color:#fff;
            padding:30px;
            text-align:center;
        }

        .form-header-main h4{
            margin:0;
            font-weight:700;
            letter-spacing:1px;
        }

        .form-body{
            padding:40px;
        }

        .section-header{
            font-size:1rem;
            font-weight:700;
            color:var(--edu-blue);
            margin-bottom:25px;
            margin-top:15px;
            border-bottom:2px solid var(--edu-blue);
            padding-bottom:8px;
            text-transform:uppercase;
            letter-spacing:0.5px;
        }

        .student-block {
            background: #fdfdfe;
            border: 1px solid #e9ecef;
            padding: 25px;
            border-radius: 12px;
            margin-bottom: 30px;
            position: relative;
        }

        .reg-label{
            font-size:0.78rem;
            font-weight:700;
            margin-bottom:7px;
            text-transform:uppercase;
            display:block;
        }

        .form-control,
        .form-select{
            border-radius:10px;
            padding:12px 15px;
            border:1px solid #d7dde5;
            font-size:0.92rem;
            background:#fcfcfc;
        }

        .form-control:focus,
        .form-select:focus{
            border-color:#0d6efd;
            box-shadow:0 0 0 3px rgba(13,110,253,0.10);
        }

        .photo-space{
            width:140px;
            height:170px;
            border:2px dashed #ced4da;
            border-radius:15px;
            display:flex;
            align-items:center;
            justify-content:center;
            flex-direction:column;
            margin:auto;
            cursor:pointer;
            transition:0.3s;
            background:#f8f9fa;
            overflow:hidden;
        }

        .photo-space:hover{
            border-color:#0d6efd;
            background:#eef5ff;
        }

        .photo-preview-img{
            width:100%;
            height:100%;
            object-fit:cover;
            display:none;
        }

        .submit-bar{
            background:#f8fafc;
            border-top:1px solid #edf1f5;
            padding:25px 40px;
            display:flex;
            justify-content:space-between;
            align-items:center;
            gap:15px;
            flex-wrap:wrap;
        }

        .btn-edu{
            background:#0d6efd;
            color:#fff;
            border:none;
            border-radius:10px;
            padding:12px 30px;
            font-weight:700;
            transition:0.3s;
        }
        .btn-edu:hover{
            background:#0047b3;
            transform:translateY(-2px);
        }

        .alert ul{
            margin-bottom:0;
        }

        @media(max-width:991px){
            .main{
                margin-left:0;
                padding:20px;
            }

            .form-body{
                padding:25px;
            }

            .submit-bar{
                flex-direction:column;
                align-items:stretch;
            }

            .submit-bar .btn{
                width:100%;
            }
        }
    </style>
</head>

<body>

  

    <div class="my-4">
        <a href="{{ Route::has('admin.students.index') ? route('admin.students.index') : '/admin/students' }}" class="text-decoration-none small text-muted">
            <i class="bi bi-arrow-left"></i> Back to Student List
        </a>
    </div>

    @if(session('success'))
        <div class="alert alert-success mx-auto mb-4" style="max-width:950px;">
            {{ session('success') }}
        </div>
    @endif

    <div class="enrollment-paper">
        <div class="form-header-main">
            <h4>STUDENT ENROLLMENT FORM</h4>
        </div>

        <form action="{{ route('admin.students.store') }}" method="POST" enctype="multipart/form-data">
            @csrf

            <div class="form-body">

                @if ($errors->any())
                    <div class="alert alert-danger mb-4">
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <div class="section-header">
                    Parent / Guardian Information
                </div>
                <div class="row g-3 mb-4">
                    <div class="col-md-8">
                        <label class="reg-label">Guardian Full Name</label>
                        <input type="text" name="guardian_name" class="form-control" value="{{ old('guardian_name') }}" required>
                    </div>

                    <div class="col-md-4">
                        <label class="reg-label">Relationship</label>
                        <input type="text" name="relationship" class="form-control" value="{{ old('relationship') }}">
                    </div>

                    <div class="col-md-6">
                        <label class="reg-label">Guardian Phone</label>
                        <input type="text" name="guardian_phone" class="form-control" value="{{ old('guardian_phone') }}" required>
                    </div>

                    <div class="col-md-6">
                        <label class="reg-label">Guardian Email</label>
                        <input type="email" name="guardian_email" class="form-control" value="{{ old('guardian_email') }}" required>
                    </div>
                </div>


                <div id="students-container">
                    
                    <div class="student-block" data-index="0">
                        <div class="section-header d-flex justify-content-between align-items-center">
                            <span class="student-title">Student #1 Information</span>
                            <button type="button" class="btn btn-danger btn-sm remove-student-btn d-none" onclick="removeStudentBlock(this)">
                                <i class="bi bi-trash"></i> Remove
                            </button>
                        </div>

                        <div class="row">
                            <div class="col-lg-9">
                                <div class="row g-3">
                                    <div class="col-md-6">
                                        <label class="reg-label">First Name</label>
                                        <input type="text" name="students[0][first_name]" class="form-control" required placeholder="First Name">
                                    </div>

                                    <div class="col-md-6">
                                        <label class="reg-label">Last Name</label>
                                        <input type="text" name="students[0][last_name]" class="form-control" required placeholder="Last Name">
                                    </div>

                                    <div class="col-md-6">
                                        <label class="reg-label">Date of Birth</label>
                                        <input type="date" name="students[0][dob]" class="form-control">
                                    </div>

                                    <div class="col-md-6">
                                        <label class="reg-label">Gender</label>
                                        <div class="pt-2">
                                            <div class="form-check form-check-inline">
                                                <input class="form-check-input" type="radio" name="students[0][gender]" value="Male" checked>
                                                <label class="form-check-label">Male</label>
                                            </div>
                                            <div class="form-check form-check-inline">
                                                <input class="form-check-input" type="radio" name="students[0][gender]" value="Female">
                                                <label class="form-check-label">Female</label>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-3 text-center mt-4 mt-lg-0">
                                <label class="reg-label">Student Photo</label>
                                <div class="photo-space" onclick="triggerPhotoUpload(this)">
                                    <i class="bi bi-camera fs-1 text-muted upload-icon"></i>
                                    <span class="small text-muted upload-text">Upload Photo</span>
                                    <img class="photo-preview-img">
                                    <input type="file" name="students[0][photo]" class="photo-file-input" hidden accept="image/*" onchange="previewStudentPhoto(this)">
                                </div>
                            </div>
                        </div>

                        <div class="row g-3 mt-2">
                            <div class="col-md-6">
                                <label class="reg-label">Phone Number</label>
                                <input type="text" name="students[0][phone]" class="form-control" placeholder="09xxxxxxxxx">
                            </div>

                            <div class="col-md-6">
                                <label class="reg-label">Email Address (System Login)</label>
                                <input type="email" name="students[0][email]" class="form-control" required placeholder="student@example.com">
                            </div>

                            <div class="col-12">
                                <label class="reg-label">Home Address</label>
                                <textarea name="students[0][address]" rows="2" class="form-control" placeholder="Enter full address"></textarea>
                            </div>
                        </div>

                        <div class="row g-3 mt-2">
                            <div class="col-md-6">
                                <label class="reg-label">Select Class / Section</label>
                                <select name="students[0][class_id]" class="form-select class-dropdown" required>
                                    <option value="">-- Choose Class --</option>
                                    @foreach($classes as $class)
                                        <option value="{{ $class->id }}">
                                            {{ $class->class_name }} @if($class->section) ({{ $class->section }}) @endif
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="col-md-6">
                                <label class="reg-label">Previous School</label>
                                <input type="text" name="students[0][previous_school]" class="form-control" placeholder="School Name">
                            </div>
                        </div>

                        <div class="row g-3 mt-2">
                            <div class="col-md-6">
                                <label class="reg-label">Student Number</label>
                                <input type="text" name="students[0][student_no]" class="form-control" placeholder="Auto generated if blank">
                            </div>

                            <div class="col-md-6">
                                <label class="reg-label">Password</label>
                                <input type="password" name="students[0][password]" class="form-control" required placeholder="Minimum 6 characters">
                            </div>
                        </div>
                    </div>

                </div> 
                
                <div class="text-end mb-4">
                    <button type="button" class="btn btn-outline-primary fw-bold" id="add-student-btn">
                        <i class="bi bi-plus-circle-fill me-2"></i> Add Next Student (Bulk Enrollment)
                    </button>
                </div>
                
                <div class="p-3 rounded" style="background:#fff8e1;border-left:5px solid #ffc107;">
                    <p class="mb-0 small fw-bold text-dark">
                        <i class="bi bi-info-circle-fill me-2"></i> I confirm that all information provided is accurate.
                    </p>
                </div>

            </div>

            <div class="submit-bar">
                <button type="button" class="btn btn-light border fw-bold px-4">
                    Save Draft
                </button>

                <button type="submit" class="btn btn-edu">
                    Confirm & Enroll All Students
                </button>
            </div>

        </form>
    </div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

<script>
    // Dynamic Student Count Mapping
    let studentIndex = 0;

    // Photo Box Trigger Click
    function triggerPhotoUpload(element) {
        element.querySelector('.photo-file-input').click();
    }

    // Dynamic Photo Preview Function
    function previewStudentPhoto(input) {
        const [file] = input.files;
        if (file) {
            const block = input.closest('.photo-space');
            const preview = block.querySelector('.photo-preview-img');
            
            preview.src = URL.createObjectURL(file);
            preview.style.display = 'block';
            
            block.querySelector('.upload-icon').style.display = 'none';
            block.querySelector('.upload-text').style.display = 'none';
        }
    }

    // Add Next Student Event Listener
    document.getElementById('add-student-btn').addEventListener('click', () => {
        studentIndex++;
        
        const container = document.getElementById('students-container');
        
        // Dynamic options extraction using the first dropdown's content
        const masterSelect = document.querySelector('.class-dropdown');
        const optionsHtml = masterSelect ? masterSelect.innerHTML : '<option value="">-- Choose Class --</option>';
        
        // Dynamic HTML Block String Template
        const studentBlockHTML = `
        <div class="student-block" data-index="${studentIndex}">
            <div class="section-header d-flex justify-content-between align-items-center">
                <span class="student-title">Student #${studentIndex + 1} Information</span>
                <button type="button" class="btn btn-danger btn-sm remove-student-btn" onclick="removeStudentBlock(this)">
                    <i class="bi bi-trash"></i> Remove
                </button>
            </div>

            <div class="row">
                <div class="col-lg-9">
                    <div class="row g-3">
                        <div class="col-md-6">
                            <label class="reg-label">First Name</label>
                            <input type="text" name="students[${studentIndex}][first_name]" class="form-control" required placeholder="First Name">
                        </div>

                        <div class="col-md-6">
                            <label class="reg-label">Last Name</label>
                            <input type="text" name="students[${studentIndex}][last_name]" class="form-control" required placeholder="Last Name">
                        </div>

                        <div class="col-md-6">
                            <label class="reg-label">Date of Birth</label>
                            <input type="date" name="students[${studentIndex}][dob]" class="form-control">
                        </div>
                        <div class="col-md-6">
                            <label class="reg-label">Gender</label>
                            <div class="pt-2">
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" name="students[${studentIndex}][gender]" value="Male" checked>
                                    <label class="form-check-label">Male</label>
                                </div>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" name="students[${studentIndex}][gender]" value="Female">
                                    <label class="form-check-label">Female</label>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-lg-3 text-center mt-4 mt-lg-0">
                    <label class="reg-label">Student Photo</label>
                    <div class="photo-space" onclick="triggerPhotoUpload(this)">
                        <i class="bi bi-camera fs-1 text-muted upload-icon"></i>
                        <span class="small text-muted upload-text">Upload Photo</span>
                        <img class="photo-preview-img">
                        <input type="file" name="students[${studentIndex}][photo]" class="photo-file-input" hidden accept="image/*" onchange="previewStudentPhoto(this)">
                    </div>
                </div>
            </div>

            <div class="row g-3 mt-2">
                <div class="col-md-6">
                    <label class="reg-label">Phone Number</label>
                    <input type="text" name="students[${studentIndex}][phone]" class="form-control" placeholder="09xxxxxxxxx">
                </div>

                <div class="col-md-6">
                    <label class="reg-label">Email Address (System Login)</label>
                    <input type="email" name="students[${studentIndex}][email]" class="form-control" required placeholder="student@example.com">
                </div>

                <div class="col-12">
                    <label class="reg-label">Home Address</label>
                    <textarea name="students[${studentIndex}][address]" rows="2" class="form-control" placeholder="Enter full address"></textarea>
                </div>
            </div>

            <div class="row g-3 mt-2">
                <div class="col-md-6">
                    <label class="reg-label">Select Class / Section</label>
                    <select name="students[${studentIndex}][class_id]" class="form-select class-dropdown" required>
                        ${optionsHtml}
                    </select>
                </div>

                <div class="col-md-6">
                    <label class="reg-label">Previous School</label>
                    <input type="text" name="students[${studentIndex}][previous_school]" class="form-control" placeholder="School Name">
                </div>
            </div>

            <div class="row g-3 mt-2">
                <div class="col-md-6">
                    <label class="reg-label">Student Number</label>
                    <input type="text" name="students[${studentIndex}][student_no]" class="form-control" placeholder="Auto generated if blank">
                </div>
                <div class="col-md-6">
                    <label class="reg-label">Password</label>
                    <input type="password" name="students[${studentIndex}][password]" class="form-control" required placeholder="Minimum 6 characters">
                </div>
            </div>
        </div>
        `;
        
        container.insertAdjacentHTML('beforeend', studentBlockHTML);
        updateRemoveButtonsVisibility();
    });

    // Remove Student Block Function
    function removeStudentBlock(button) {
        const block = button.closest('.student-block');
        block.remove();
        reIndexStudentBlocks();
        updateRemoveButtonsVisibility();
    }

    // Real-time Dynamic Array Index Alignment
    function reIndexStudentBlocks() {
        const blocks = document.querySelectorAll('#students-container .student-block');
        studentIndex = blocks.length - 1;

        blocks.forEach((block, idx) => {
            block.setAttribute('data-index', idx);
            block.querySelector('.student-title').textContent = `Student #${idx + 1} Information`;
            
            // Re-indexing standard input fields, dropdowns, and textareas
            block.querySelectorAll('[name]').forEach(input => {
                const nameAttr = input.getAttribute('name');
                if (nameAttr && nameAttr.startsWith('students[')) {
                    const updatedName = nameAttr.replace(/students\[\d+\]/, `students[${idx}]`);
                    input.setAttribute('name', updatedName);
                }
            });
        });
    }

    // Toggle logic to prevent deleting Student #1 if it's the only one left
    function updateRemoveButtonsVisibility() {
        const blocks = document.querySelectorAll('#students-container .student-block');
        if (blocks.length === 1) {
            blocks[0].querySelector('.remove-student-btn').classList.add('d-none');
        } else {
            blocks.forEach(block => {
                block.querySelector('.remove-student-btn').classList.remove('d-none');
            });
        }
    }
</script>

</body>
</html>
@endsection