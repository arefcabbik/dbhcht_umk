@extends('layouts.admin')

@section('title', 'Manajemen Pengguna')

@section('content')
<style>
    /* Override modal backdrop */
    .modal-backdrop {
        opacity: 0.5 !important;
    }
    
    /* Override modal content */
    .modal-content {
        background-color: #ffffff !important;
    }

    /* Form controls */
    .form-control, .form-select {
        background-color: #ffffff !important;
        border: 1px solid #ced4da;
    }

    .form-control:focus, .form-select:focus {
        border-color: #80bdff;
        box-shadow: 0 0 0 0.2rem rgba(0,123,255,.25);
    }

    /* OPD Fields */
    .opd-fields .form-control:disabled,
    .opd-fields-edit .form-control:disabled {
        background-color: #f8f9fa !important;
    }

    .opd-fields .form-control:not(:disabled),
    .opd-fields-edit .form-control:not(:disabled) {
        background-color: #ffffff !important;
    }

    /* Style for required fields */
    .text-danger {
        color: #dc3545 !important;
    }

    /* Override input styles */
    .form-control, .form-select {
        background-color: #ffffff !important;
        border: 1px solid #ced4da;
    }

    .form-control:focus, .form-select:focus {
        border-color: #80bdff;
        box-shadow: 0 0 0 0.2rem rgba(0,123,255,.25);
    }

    /* Required field indicator */
    .required-field::after {
        content: " *";
        color: #dc3545;
    }

    /* Error state */
    .is-invalid {
        border-color: #dc3545 !important;
        padding-right: calc(1.5em + 0.75rem) !important;
        background-image: url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 12 12' width='12' height='12' fill='none' stroke='%23dc3545'%3e%3ccircle cx='6' cy='6' r='4.5'/%3e%3cpath stroke-linejoin='round' d='M5.8 3.6h.4L6 6.5z'/%3e%3ccircle cx='6' cy='8.2' r='.6' fill='%23dc3545' stroke='none'/%3e%3c/svg%3e") !important;
        background-repeat: no-repeat !important;
        background-position: right calc(0.375em + 0.1875rem) center !important;
        background-size: calc(0.75em + 0.375rem) calc(0.75em + 0.375rem) !important;
    }

    .invalid-feedback {
        display: block;
        color: #dc3545;
        font-size: 0.875em;
        margin-top: 0.25rem;
    }
</style>

<div class="container-fluid">
    <!-- Header -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h4 class="mb-0">Manajemen Pengguna</h4>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
                    <li class="breadcrumb-item active">Manajemen Pengguna</li>
                </ol>
            </nav>
        </div>
        <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addUserModal">
            <i class="fas fa-plus me-2"></i>Tambah Pengguna
        </button>
    </div>

    <!-- Alert Success -->
    @if(session('success'))
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        {{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
    @endif

    <!-- Alert Error -->
    @if($errors->any())
    <div class="alert alert-danger alert-dismissible fade show" role="alert">
        <ul class="mb-0">
            @foreach($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
    @endif

    <!-- Table Card -->
    <div class="card">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Nama</th>
                            <th>Username</th>
                            <th>Email</th>
                            <th>Level</th>
                            <th>OPD</th>
                            <th>Status</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($users as $index => $user)
                        <tr>
                            <td>{{ $index + 1 }}</td>
                            <td>{{ $user->name }}</td>
                            <td>{{ $user->username }}</td>
                            <td>{{ $user->email }}</td>
                            <td>
                                <span class="badge {{ $user->level == 'admin' ? 'bg-danger' : 'bg-primary' }}">
                                    {{ ucfirst($user->level) }}
                                </span>
                            </td>
                            <td>{{ $user->pd->nama_dinas ?? '-' }}</td>
                            <td>
                                <span class="badge {{ $user->aktif ? 'bg-success' : 'bg-secondary' }}">
                                    {{ $user->aktif ? 'Aktif' : 'Non-aktif' }}
                                </span>
                            </td>
                            <td>
                                <button class="btn btn-sm btn-warning me-1" data-bs-toggle="modal" data-bs-target="#editModal{{ $user->id }}">
                                    <i class="fas fa-edit"></i>
                                </button>
                                <form action="{{ route('admin.users.destroy', $user->id) }}" method="POST" class="d-inline" data-delete>
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-danger">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </form>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="8" class="text-center">Tidak ada data pengguna</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<!-- Add User Modal -->
<div class="modal fade" id="addUserModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Tambah Pengguna</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form action="{{ route('admin.users.store') }}" method="POST" id="addUserForm">
                @csrf
                <div class="modal-body">
                    <!-- Basic User Fields -->
                    <div class="basic-fields">
                        <div class="mb-3">
                            <label class="form-label">Nama <span class="text-danger">*</span></label>
                            <input type="text" class="form-control @error('name') is-invalid @enderror" 
                                   name="name" value="{{ old('name') }}" required>
                            @error('name')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Username <span class="text-danger">*</span></label>
                            <input type="text" class="form-control @error('username') is-invalid @enderror" 
                                   name="username" value="{{ old('username') }}" required>
                            @error('username')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Email <span class="text-danger">*</span></label>
                            <input type="email" class="form-control @error('email') is-invalid @enderror" 
                                   name="email" value="{{ old('email') }}" required>
                            @error('email')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Password <span class="text-danger">*</span></label>
                            <input type="password" class="form-control @error('password') is-invalid @enderror" 
                                   name="password" required minlength="6">
                            <small class="text-muted">Minimal 6 karakter</small>
                            @error('password')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Level <span class="text-danger">*</span></label>
                            <select class="form-select @error('level') is-invalid @enderror" 
                                    name="level" id="levelSelect" required>
                                <option value="">Pilih Level</option>
                                <option value="admin" {{ old('level') == 'admin' ? 'selected' : '' }}>Admin</option>
                                <option value="opd" {{ old('level') == 'opd' ? 'selected' : '' }}>OPD</option>
                            </select>
                            @error('level')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <hr>
                    <!-- OPD Fields -->
                    <div class="opd-fields">
                        <h6 class="mb-3">Data OPD</h6>
                        <div class="mb-3">
                            <label class="form-label">Nama Dinas <span class="text-danger opd-required d-none">*</span></label>
                            <input type="text" class="form-control opd-input @error('nama_dinas') is-invalid @enderror" 
                                   name="nama_dinas" value="{{ old('nama_dinas') }}">
                            @error('nama_dinas')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Singkatan <span class="text-danger opd-required d-none">*</span></label>
                            <input type="text" class="form-control opd-input @error('singkatan') is-invalid @enderror" 
                                   name="singkatan" value="{{ old('singkatan') }}">
                            @error('singkatan')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Alamat <span class="text-danger opd-required d-none">*</span></label>
                            <textarea class="form-control opd-input @error('alamat') is-invalid @enderror" 
                                      name="alamat" rows="2">{{ old('alamat') }}</textarea>
                            @error('alamat')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Telepon <span class="text-danger opd-required d-none">*</span></label>
                            <input type="text" class="form-control opd-input @error('telepon') is-invalid @enderror" 
                                   name="telepon" value="{{ old('telepon') }}">
                            @error('telepon')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="mb-3">
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" name="aktif" value="1" 
                                   id="aktifAdd" checked>
                            <label class="form-check-label" for="aktifAdd">
                                Aktif
                            </label>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary">Simpan</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Edit Modal -->
@foreach($users as $user)
<div class="modal fade" id="editModal{{ $user->id }}" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Edit Pengguna</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form action="{{ route('admin.users.update', $user->id) }}" method="POST">
                @csrf
                @method('PUT')
                <div class="modal-body">
                    <!-- Basic User Fields -->
                    <div class="basic-fields">
                        <div class="mb-3">
                            <label class="form-label">Nama <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" name="name" value="{{ $user->name }}" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Username <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" name="username" value="{{ $user->username }}" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Email <span class="text-danger">*</span></label>
                            <input type="email" class="form-control" name="email" value="{{ $user->email }}" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Password Baru</label>
                            <input type="password" class="form-control" name="password" minlength="6">
                            <small class="text-muted">Minimal 6 karakter. Kosongkan jika tidak ingin mengubah password.</small>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Level <span class="text-danger">*</span></label>
                            <select class="form-select edit-level-select" name="level" required data-user-id="{{ $user->id }}">
                                <option value="admin" {{ $user->level == 'admin' ? 'selected' : '' }}>Admin</option>
                                <option value="opd" {{ $user->level == 'opd' ? 'selected' : '' }}>OPD</option>
                            </select>
                        </div>
                    </div>

                    <hr>
                    <!-- OPD Fields -->
                    <div class="opd-fields-edit" id="opdFields{{ $user->id }}">
                        <h6 class="mb-3">Data OPD</h6>
                        <div class="mb-3">
                            <label class="form-label">Nama Dinas <span class="text-danger opd-required-edit {{ $user->level != 'opd' ? 'd-none' : '' }}">*</span></label>
                            <input type="text" class="form-control opd-input-edit" name="nama_dinas" 
                                   value="{{ $user->pd->nama_dinas ?? '' }}" 
                                   {{ $user->level != 'opd' ? 'disabled' : '' }}>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Singkatan <span class="text-danger opd-required-edit {{ $user->level != 'opd' ? 'd-none' : '' }}">*</span></label>
                            <input type="text" class="form-control opd-input-edit" name="singkatan" 
                                   value="{{ $user->pd->singkatan ?? '' }}"
                                   {{ $user->level != 'opd' ? 'disabled' : '' }}>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Alamat <span class="text-danger opd-required-edit {{ $user->level != 'opd' ? 'd-none' : '' }}">*</span></label>
                            <textarea class="form-control opd-input-edit" name="alamat" rows="2"
                                      {{ $user->level != 'opd' ? 'disabled' : '' }}>{{ $user->pd->alamat ?? '' }}</textarea>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Telepon <span class="text-danger opd-required-edit {{ $user->level != 'opd' ? 'd-none' : '' }}">*</span></label>
                            <input type="text" class="form-control opd-input-edit" name="telepon" 
                                   value="{{ $user->pd->telepon ?? '' }}"
                                   {{ $user->level != 'opd' ? 'disabled' : '' }}>
                        </div>
                    </div>

                    <div class="mb-3">
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" name="aktif" value="1" 
                                   id="aktif{{ $user->id }}" {{ $user->aktif ? 'checked' : '' }}>
                            <label class="form-check-label" for="aktif{{ $user->id }}">
                                Aktif
                            </label>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endforeach

@push('scripts')
<script>
    $(document).ready(function() {
        // DataTable initialization
        $('.table').DataTable({
            language: {
                url: '//cdn.datatables.net/plug-ins/1.10.24/i18n/Indonesian.json'
            },
            responsive: true,
            pageLength: 10,
            order: [[0, 'asc']]
        });

        // Initialize modals
        $('.modal').on('show.bs.modal', function () {
            const modal = $(this);
            const levelSelect = modal.find('.edit-level-select, #levelSelect');
            const form = modal.find('form');
            
            // Hanya reset form jika ini adalah modal tambah user
            if (modal.attr('id') === 'addUserModal') {
                form[0].reset();
            }
            
            modal.find('.is-invalid').removeClass('is-invalid');
            modal.find('.invalid-feedback').hide();
            
            // Set initial state
            setTimeout(() => {
                if (modal.attr('id') === 'addUserModal') {
                    const isOpd = levelSelect.val() === 'opd';
                    const container = modal.find('.opd-fields');
                    toggleOpdFields(isOpd, container);
                } else {
                    const isOpd = levelSelect.val() === 'opd';
                    const userId = levelSelect.data('user-id');
                    const container = $(`#opdFields${userId}`);
                    toggleOpdFields(isOpd, container);
                }
            }, 100);
        });

        // Function to enable/disable OPD fields
        function toggleOpdFields(isOpd, container) {
            const opdInputs = container.find('.opd-input, .opd-input-edit');
            const opdRequired = container.find('.opd-required, .opd-required-edit');
            
            opdInputs.prop('disabled', !isOpd);
            opdInputs.prop('required', isOpd);
            
            if (isOpd) {
                opdInputs.css({
                    'background-color': '#ffffff',
                    'cursor': 'text',
                    'pointer-events': 'auto',
                    'opacity': '1'
                });
                opdRequired.removeClass('d-none');
                container.find('.form-label').addClass('required-field');
            } else {
                opdInputs.css({
                    'background-color': '#f8f9fa',
                    'cursor': 'not-allowed',
                    'pointer-events': 'none',
                    'opacity': '0.7'
                }).val('');
                opdRequired.addClass('d-none');
                container.find('.form-label').removeClass('required-field');
                opdInputs.removeClass('is-invalid');
                container.find('.invalid-feedback').hide();
            }
        }

        // Initialize OPD fields state on page load
        const initialLevel = $('#levelSelect').val();
        toggleOpdFields(initialLevel === 'opd', $('.opd-fields'));

        // Handle level select change
        $('#levelSelect').on('change', function() {
            const isOpd = $(this).val() === 'opd';
            const container = $('.opd-fields');
            toggleOpdFields(isOpd, container);
        });

        // Handle level select change in edit modal
        $('.edit-level-select').on('change', function() {
            const isOpd = $(this).val() === 'opd';
            const userId = $(this).data('user-id');
            const container = $(`#opdFields${userId}`);
            toggleOpdFields(isOpd, container);
        });

        // Form validation
        $('#addUserForm').on('submit', function(e) {
            const level = $('#levelSelect').val();
            let hasError = false;
            
            // Reset previous errors
            $(this).find('.is-invalid').removeClass('is-invalid');
            $(this).find('.invalid-feedback').hide();
            
            if (level === 'opd') {
                const fields = {
                    'nama_dinas': 'Nama Dinas',
                    'singkatan': 'Singkatan',
                    'alamat': 'Alamat',
                    'telepon': 'Telepon'
                };
                
                Object.keys(fields).forEach(field => {
                    const input = $(this).find(`[name="${field}"]`);
                    if (!input.val().trim()) {
                        input.addClass('is-invalid');
                        input.siblings('.invalid-feedback').show();
                        hasError = true;
                    }
                });
                
                if (hasError) {
                    e.preventDefault();
                    Swal.fire({
                        icon: 'error',
                        title: 'Error!',
                        text: 'Mohon lengkapi semua field OPD yang wajib diisi!'
                    });
                }
            }
        });

        // Show success message
        @if(session('success'))
            Swal.fire({
                icon: 'success',
                title: 'Berhasil!',
                text: "{{ session('success') }}",
                timer: 3000,
                showConfirmButton: false
            });
        @endif

        // Show error message with field highlighting
        @if($errors->any())
            const errors = @json($errors->messages());
            Object.keys(errors).forEach(field => {
                const input = $(`[name="${field}"]`);
                input.addClass('is-invalid');
                input.siblings('.invalid-feedback').text(errors[field][0]).show();
            });
            
            Swal.fire({
                icon: 'error',
                title: 'Error!',
                html: `@foreach($errors->all() as $error)
                        <p class="mb-0">{{ $error }}</p>
                      @endforeach`,
            });
            $('#addUserModal').modal('show');
        @endif

        // Delete confirmation
        $('form[data-delete]').on('submit', function(e) {
            e.preventDefault();
            const form = $(this);
            
            Swal.fire({
                title: 'Apakah Anda yakin?',
                text: "Data yang dihapus tidak dapat dikembalikan!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#dc3545',
                cancelButtonColor: '#6c757d',
                confirmButtonText: 'Ya, hapus!',
                cancelButtonText: 'Batal'
            }).then((result) => {
                if (result.isConfirmed) {
                    form.off('submit').submit();
                }
            });
        });
    });
</script>
@endpush
@endsection
