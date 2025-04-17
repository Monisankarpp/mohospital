@extends('layouts.doctor-dashboard')
@section('title', 'Prescription')

@section('dashboard-content')
    <div class="container-fluid py-4 ps-lg-5" style="margin-left: 250px; max-width: calc(100% - 250px);">
        <div class="d-flex flex-column flex-sm-row align-items-center justify-content-between mb-4 gap-3">
            <div>
                <h3 class="h4 fw-semibold text-dark mb-2" style="color: #2c3e50;">Create New Prescription</h3>
                <p class="text-muted small mb-0" style="color: #7f8c8d;">Carefully document your patient's treatment plan</p>
            </div>
            <div class="d-flex align-items-center gap-2">
                <span class="badge rounded-pill px-3 py-2" style="background-color: #e8f4fc; color: #3498db;">
                    <i class="fas fa-prescription-bottle-alt me-2"></i>Medical Record
                </span>
            </div>
        </div>

        {{-- Prescription Form --}}
        <div class="card shadow-sm rounded-4 border-0" style="background-color: #f8fafc;">
            <div class="card-body p-4 p-lg-5">
                <form action="{{ route('doctor.prescription.store') }}" method="POST" enctype="multipart/form-data"
                    class="needs-validation" novalidate>
                    @csrf

                    {{-- Patient Selection with Search --}}
                    <div class="mb-4">
                        <label for="patient_id" class="form-label fw-medium" style="color: #2c3e50;">
                            <i class="fas fa-user-injured me-2" style="color: #e74c3c;"></i>
                            Select Patient
                        </label>
                        <div class="input-group">
                            <span class="input-group-text bg-white border-end-0">
                                <i class="fas fa-search text-muted"></i>
                            </span>
                            <select name="patient_id" id="patient_id" class="form-select select2" required
                                style="border-left: 0; padding-left: 0;">
                                <option value="" disabled selected>Search patient by name or ID</option>
                                @foreach ($patients as $patient)
                                    <option value="{{ $patient->id }}">{{ $patient->name }} ({{ $patient->id }})
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-text text-muted small">Begin typing to find your patient</div>
                    </div>

                    {{-- Prescription Notes with Text Editor --}}
                    <div class="mb-4">
                        <label for="editor" class="form-label fw-medium" style="color: #2c3e50;">
                            <i class="fas fa-file-medical me-2" style="color: #27ae60;"></i>
                            Prescription Details
                        </label>

                        {{-- Toolbar --}}
                        <div id="editor-toolbar" class="border rounded-top-3 p-2 bg-white">
                            <div class="btn-group btn-group-sm" role="group">
                                <button type="button" class="btn btn-outline-secondary" data-command="bold" title="Bold">
                                    <i class="fas fa-bold"></i>
                                </button>
                                <button type="button" class="btn btn-outline-secondary" data-command="italic"
                                    title="Italic">
                                    <i class="fas fa-italic"></i>
                                </button>
                                <button type="button" class="btn btn-outline-secondary" data-command="insertUnorderedList"
                                    title="Bullet List">
                                    <i class="fas fa-list-ul"></i>
                                </button>
                                <button type="button" class="btn btn-outline-secondary" data-command="insertOrderedList"
                                    title="Numbered List">
                                    <i class="fas fa-list-ol"></i>
                                </button>
                                <button type="button" class="btn btn-outline-secondary" data-command="createLink"
                                    title="Add Link">
                                    <i class="fas fa-link"></i>
                                </button>
                            </div>
                        </div>

                        {{-- Editable Content Area --}}
                        <div id="editor" class="form-control prescription-editor border-top-0 rounded-bottom-3"
                            contenteditable="true"
                            placeholder="Enter each medicine in format: Name | Dosage | Frequency | Duration">
                        </div>

                        {{-- Hidden Fields --}}
                        <textarea name="notes" id="notes" class="d-none" required></textarea>
                        <textarea name="medications" id="medications" class="d-none"></textarea>

                        {{-- Helper and Character Count --}}
                        <div class="d-flex justify-content-between mt-1">
                            <div class="form-text text-muted small">
                                Format: <strong>Paracetamol 500mg | 1 tablet | Every 6 hours | 3 days</strong><br>
                                Add one medicine per line.
                            </div>
                            <div id="charCount" class="text-muted small">0/2000 characters</div>
                        </div>
                    </div>

                    {{-- File Upload --}}
                    <div class="mb-4">
                        <label for="file" class="form-label fw-medium" style="color: #2c3e50;">
                            <i class="fas fa-file-upload me-2" style="color: #9b59b6;"></i>
                            Attach Supporting Documents
                        </label>
                        <div class="file-upload-wrapper position-relative">
                            <input type="file" name="file" id="file" class="form-control d-none"
                                accept=".pdf,.jpg,.png,.jpeg">

                            <div class="border rounded-3 p-3 text-center bg-white upload-area" style="cursor: pointer;"
                                id="uploadArea">
                                <div id="uploadPlaceholder"
                                    class="d-flex flex-column align-items-center justify-content-center"
                                    style="min-height: 150px;">
                                    <div class="upload-icon mb-3">
                                        <i class="fas fa-cloud-upload-alt fa-3x" style="color: #95a5a6;"></i>
                                    </div>
                                    <p class="mb-1 fw-medium">Drag & drop files or click to browse</p>
                                    <p class="small text-muted mb-0">PDF, JPG, or PNG (Max 2MB)</p>
                                </div>
                                <div id="filePreview" class="d-none flex-column align-items-center justify-content-center"
                                    style="min-height: 150px;">
                                    <div class="position-relative mb-3">
                                        <i class="fas fa-file-alt fa-3x" style="color: #3498db;"></i>
                                        <div class="progress position-absolute w-100"
                                            style="bottom: -10px; height: 4px; display: none;">
                                            <div id="uploadProgress"
                                                class="progress-bar progress-bar-striped progress-bar-animated"
                                                role="progressbar" style="width: 0%"></div>
                                        </div>
                                    </div>
                                    <p class="mb-1 fw-medium" id="fileName"></p>
                                    <p class="small text-muted mb-2" id="fileSize"></p>
                                    <button type="button" class="btn btn-sm btn-outline-danger mt-2"
                                        onclick="removeFile()">
                                        <i class="fas fa-times me-1"></i> Remove
                                    </button>
                                </div>
                            </div>
                            <div class="position-absolute top-0 start-0 w-100 h-100 d-flex align-items-center justify-content-center d-none"
                                id="uploadAnimation">
                                <div class="spinner-border text-primary" role="status">
                                    <span class="visually-hidden">Uploading...</span>
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- Action Buttons --}}
                    <div class="d-flex justify-content-between align-items-center pt-3 border-top">
                        <button type="button" class="btn btn-outline-secondary rounded-3 px-4" id="saveDraftBtn">
                            <i class="fas fa-save me-2"></i> Save Draft
                        </button>
                        <div>
                            <button type="reset" class="btn btn-light rounded-3 px-4 me-2" onclick="resetForm()">
                                <i class="fas fa-eraser me-2"></i> Clear
                            </button>
                            <button type="submit" class="btn btn-primary rounded-3 px-4"
                                style="background-color: #2980b9; border-color: #2980b9;">
                                <i class="fas fa-paper-plane me-2"></i> Submit Prescription
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <style>
        .select2-container--default .select2-selection--single {
            height: 45px;
            border-radius: 0 8px 8px 0 !important;
            border-left: 0 !important;
        }

        .select2-container--default .select2-selection--single .select2-selection__rendered {
            line-height: 45px;
        }

        .select2-container--default .select2-selection--single .select2-selection__arrow {
            height: 45px;
        }

        .prescription-editor {
            min-height: 200px;
            padding: 12px;
            overflow-y: auto;
            background-color: white;
        }

        .file-upload-wrapper {
            border-radius: 8px;
            transition: all 0.3s;
        }

        .upload-area {
            transition: all 0.3s;
            border: 2px dashed #dfe6e9;
        }

        .upload-area:hover,
        .upload-area.dragover {
            border-color: #3498db;
            background-color: #f0f8ff;
        }

        #editor-toolbar {
            border-bottom: 1px solid #dfe6e9;
        }

        #editor:focus {
            outline: none;
            box-shadow: 0 0 0 2px rgba(52, 152, 219, 0.25);
        }

        .upload-icon {
            transition: transform 0.3s;
        }

        .upload-area:hover .upload-icon {
            transform: translateY(-5px);
        }
    </style>

@endsection

@section('scripts')
    <script>
        document.querySelectorAll('#editor-toolbar button').forEach(button => {
            button.addEventListener('click', function() {
                const command = this.getAttribute('data-command');
                document.execCommand(command, false, null);
                document.getElementById('editor').focus();
            });
        });

        document.getElementById('editor').addEventListener('input', function() {
            document.getElementById('notes').value = this.innerHTML;
            updateCharCount();
        });

        function updateCharCount() {
            const text = document.getElementById('editor').textContent;
            const charCount = text.length;
            document.getElementById('charCount').textContent = `${charCount}/2000 characters`;
        }

        const uploadArea = document.getElementById('uploadArea');
        const fileInput = document.getElementById('file');
        const uploadAnimation = document.getElementById('uploadAnimation');

        uploadArea.addEventListener('click', () => fileInput.click());

        uploadArea.addEventListener('dragover', (e) => {
            e.preventDefault();
            uploadArea.classList.add('dragover');
        });

        uploadArea.addEventListener('dragleave', () => {
            uploadArea.classList.remove('dragover');
        });

        uploadArea.addEventListener('drop', (e) => {
            e.preventDefault();
            uploadArea.classList.remove('dragover');
            if (e.dataTransfer.files.length) {
                fileInput.files = e.dataTransfer.files;
                handleFileUpload();
            }
        });

        fileInput.addEventListener('change', handleFileUpload);

        function handleFileUpload() {
            if (fileInput.files && fileInput.files[0]) {
                const file = fileInput.files[0];
                const fileSize = (file.size / (1024 * 1024)).toFixed(2); // MB

                if (fileSize > 2) {
                    alert('File size exceeds 2MB limit');
                    return;
                }

                // Show preview
                document.getElementById('uploadPlaceholder').classList.add('d-none');
                document.getElementById('filePreview').classList.remove('d-none');
                document.getElementById('fileName').textContent = file.name;
                document.getElementById('fileSize').textContent = `${fileSize} MB`;

                // Simulate upload progress 
                uploadAnimation.classList.remove('d-none');
                const progressBar = document.querySelector('.progress');
                progressBar.style.display = 'block';

                let progress = 0;
                const interval = setInterval(() => {
                    progress += 5;
                    document.getElementById('uploadProgress').style.width = `${progress}%`;

                    if (progress >= 100) {
                        clearInterval(interval);
                        uploadAnimation.classList.add('d-none');
                        progressBar.style.display = 'none';
                    }
                }, 100);
            }
        }

        function removeFile() {
            fileInput.value = '';
            document.getElementById('filePreview').classList.add('d-none');
            document.getElementById('uploadPlaceholder').classList.remove('d-none');
            uploadAnimation.classList.add('d-none');
            document.querySelector('.progress').style.display = 'none';
        }

        function resetForm() {
            document.getElementById('editor').innerHTML = '';
            document.getElementById('notes').value = '';
            updateCharCount();
            removeFile();
        }


        // This is for Draft the notes

        const formFields = {
            patient: document.getElementById('patient_id'),
            notesEditor: document.getElementById('editor'),
            notesTextarea: document.getElementById('notes')
        };

        const DRAFT_KEY = 'prescriptionDraft';

        // Save draft to localStorage
        document.getElementById('saveDraftBtn').addEventListener('click', function() {
            const draft = {
                patient_id: formFields.patient.value,
                notes: formFields.notesEditor.innerHTML,
                timestamp: new Date().toISOString()
            };

            localStorage.setItem(DRAFT_KEY, JSON.stringify(draft));
            alert('Draft saved locally!');
        });

        // Load draft from localStorage on page load
        window.addEventListener('DOMContentLoaded', function() {
            const savedDraft = localStorage.getItem(DRAFT_KEY);
            if (savedDraft) {
                const draft = JSON.parse(savedDraft);

                if (draft.patient_id) {
                    formFields.patient.value = draft.patient_id;
                }
                if (draft.notes) {
                    formFields.notesEditor.innerHTML = draft.notes;
                    formFields.notesTextarea.value = draft.notes;
                    updateCharCount();
                }

                console.log('Loaded saved draft:', draft);
            }
        });

        //Clear draft on successful submit
        document.querySelector('form').addEventListener('submit', function() {
            localStorage.removeItem(DRAFT_KEY);
        });

        // Add auto-save every 30s
        setInterval(() => {
            const draft = {
                patient_id: formFields.patient.value,
                notes: formFields.notesEditor.innerHTML,
                timestamp: new Date().toISOString()
            };
            localStorage.setItem(DRAFT_KEY, JSON.stringify(draft));
            console.log('Auto-saved draft');
        }, 30000);


        // demo
        document.addEventListener('DOMContentLoaded', function() {
            const editor = document.getElementById('editor');
            const medicationsField = document.getElementById('medications');
            const notesField = document.getElementById('notes');
            const charCount = document.getElementById('charCount');
            const toolbarButtons = document.querySelectorAll('[data-command]');

            // Toolbar functionality
            toolbarButtons.forEach(button => {
                button.addEventListener('click', function() {
                    const command = button.getAttribute('data-command');
                    if (command === 'createLink') {
                        const url = prompt('Enter the link here: ', 'http://');
                        if (url) document.execCommand(command, false, url);
                    } else {
                        document.execCommand(command, false, null);
                    }
                });
            });

            // Update hidden fields before form submission
            const form = editor.closest('form');
            form.addEventListener('submit', function(e) {
                // Capture raw HTML for notes
                notesField.value = editor.innerHTML.trim();

                // Parse into structured JSON array
                const lines = editor.innerText.trim().split('\n');
                const parsed = [];

                lines.forEach(line => {
                    const parts = line.split('|').map(p => p.trim());
                    if (parts.length >= 4) {
                        parsed.push({
                            name: parts[0],
                            dosage: parts[1],
                            frequency: parts[2],
                            duration: parseInt(parts[3]) || 0,
                            composition: null // optional, could be added later
                        });
                    }
                });

                medicationsField.value = JSON.stringify(parsed);
            });

            // Char count
            editor.addEventListener('input', function() {
                charCount.textContent = `${editor.innerText.length}/2000 characters`;
            });
        });
    </script>

@endsection
