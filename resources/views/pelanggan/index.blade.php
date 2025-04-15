@extends('layout.app')

@push('styles')
<style>
    :root {
        --dark-blue: #0f2444;
        --gold: #d4af37;
        --light-gold: #f5e7b2;
        --gold-hover: #e9c767;
    }
    
    .page-header {
        background-color: var(--dark-blue);
        color: white;
        padding: 1.5rem 2rem;
        border-radius: 0.5rem;
        margin-bottom: 1.5rem;
        box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        position: relative;
        overflow: hidden;
    }
    
    .page-header::after {
        content: '';
        position: absolute;
        bottom: 0;
        left: 0;
        right: 0;
        height: 3px;
        background: var(--gold);
    }
    
    .gold-btn {
        background-color: var(--gold);
        color: var(--dark-blue);
        border: none;
        font-weight: 600;
        padding: 0.5rem 1.25rem;
        transition: all 0.3s ease;
    }
    
    .gold-btn:hover {
        background-color: var(--gold-hover);
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        transform: translateY(-1px);
    }
    
    .blue-table {
        border-radius: 0.5rem;
        overflow: hidden;
        box-shadow: 0 4px 6px rgba(0, 0, 0, 0.05);
    }
    
    .blue-table thead {
        background-color: var(--dark-blue);
        color: white;
    }
    
    .blue-table th {
        font-weight: 500;
        padding: 1rem;
        border: none;
    }
    
    .blue-table tbody tr {
        transition: all 0.2s ease;
    }
    
    .blue-table tbody tr:hover {
        background-color: var(--light-gold);
    }
    
    .blue-table td {
        padding: 1rem;
        vertical-align: middle;
        border-bottom: 1px solid #e5e7eb;
    }
    
    .action-btn {
        padding: 0.35rem 0.75rem;
        font-size: 0.875rem;
        border-radius: 0.25rem;
        margin-right: 0.25rem;
    }
    
    .edit-btn {
        background-color: var(--gold);
        color: var(--dark-blue);
        border: none;
    }
    
    .edit-btn:hover {
        background-color: var(--gold-hover);
        color: var(--dark-blue);
    }
    
    .delete-btn {
        background-color: #dc3545;
        color: white;
        border: none;
    }
    
    .modal-header {
        background-color: var(--dark-blue);
        color: white;
        border-bottom: 3px solid var(--gold);
    }
    
    .modal-title {
        font-weight: 600;
    }
    
    .form-label {
        color: var(--dark-blue);
        font-weight: 500;
    }
    
    .form-control:focus {
        border-color: var(--gold);
        box-shadow: 0 0 0 0.25rem rgba(212, 175, 55, 0.25);
    }
    
    .alert-success {
        background-color: #dff0d8;
        border-color: var(--gold);
        color: var(--dark-blue);
        border-left: 4px solid var(--gold);
    }
    
    .btn-close {
        color: white;
    }
</style>
@endpush

@section('content')
<div class="main-content">
    <div class="page-header">
        <h2 class="m-0 fs-3">Daftar Member</h2>
    </div>

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <i class="bi bi-check-circle-fill me-2"></i>
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <div class="d-flex justify-content-between align-items-center mb-4">
        <span class="text-muted">Total Pelanggan: {{ count($pelanggans) }}</span>
        <!-- Button to trigger modal -->
        <button type="button" class="btn gold-btn d-flex align-items-center" data-bs-toggle="modal" data-bs-target="#createPelangganModal">
            <i class="bi bi-plus-circle me-2"></i> Tambah Pelanggan
        </button>
    </div>

    <!-- Table for Customers -->
    <div class="card blue-table">
        <div class="card-body p-0">
            <table class="table mb-0">
                <thead>
                    <tr>
                        <th scope="col" width="70">No</th>
                        <th scope="col">Nama Member</th>
                        <th scope="col">Alamat</th>
                        <th scope="col">Nomor Telepon</th>
                        <th scope="col" width="150">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($pelanggans as $pelanggan)
                    <tr>
                        <th scope="row">{{ $pelanggan->PelangganID }}</th>
                        <td>{{ $pelanggan->NamaPelanggan ?? '-' }}</td>
                        <td>{{ $pelanggan->Alamat ?? '-' }}</td>
                        <td>{{ $pelanggan->NomerTelpon ?? '-' }}</td>
                        <td>
                            <button type="button" 
                                class="btn action-btn edit-btn edit-pelanggan-btn" 
                                data-id="{{ $pelanggan->PelangganID }}"
                                data-name="{{ $pelanggan->NamaPelanggan }}"
                                data-alamat="{{ $pelanggan->Alamat }}"
                                data-telpon="{{ $pelanggan->NomerTelpon }}">
                                <box-icon type='solid' name='edit-alt'></box-icon>
                            </button>
                            <form action="{{ route('pelanggan.destroy', $pelanggan->PelangganID) }}" method="POST" style="display:inline;">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn action-btn delete-btn" onclick="return confirm('Anda yakin ingin menghapus pelanggan ini?')">
                                <box-icon name='trash'></box-icon>
                                </button>
                            </form>
                        </td>
                    </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="text-center py-4">Belum ada data pelanggan</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <!-- Modal for creating a new Pelanggan -->
    <div class="modal fade" id="createPelangganModal" tabindex="-1" aria-labelledby="createPelangganModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="createPelangganModalLabel">Tambah Pelanggan</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form action="{{ route('pelanggan.store') }}" method="POST">
                    @csrf
                    <div class="modal-body">
                        <div class="mb-3">
                            <label for="NamaPelanggan" class="form-label">Nama Pelanggan</label>
                            <input type="text" class="form-control" id="NamaPelanggan" name="NamaPelanggan" required>
                        </div>
                        <div class="mb-3">
                            <label for="Alamat" class="form-label">Alamat</label>
                            <textarea class="form-control" id="Alamat" name="Alamat" rows="3"></textarea>
                        </div>
                        <div class="mb-3">
                            <label for="NomerTelpon" class="form-label">Nomor Telepon</label>
                            <input type="text" class="form-control" id="NomerTelpon" name="NomerTelpon">
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                        <button type="submit" class="btn gold-btn">Simpan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- eedit -->

<!-- Modal for editing a Pelanggan -->
<div class="modal fade" id="editPelangganModal" tabindex="-1" aria-labelledby="editPelangganModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editPelangganModalLabel">Edit Member</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="editPelangganForm" method="POST">
                @csrf
                @method('PUT')
                <input type="hidden" id="editPelangganId" name="PelangganID">
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="editNamaPelanggan" class="form-label">Nama Member</label>
                        <input type="text" class="form-control" id="editNamaPelanggan" name="NamaPelanggan" required>
                        <div class="invalid-feedback" id="editNamaPelangganFeedback"></div>
                    </div>
                    <div class="mb-3">
                        <label for="editAlamat" class="form-label">Alamat</label>
                        <textarea class="form-control" id="editAlamat" name="Alamat" rows="3"></textarea>
                        <div class="invalid-feedback" id="editAlamatFeedback"></div>
                    </div>
                    <div class="mb-3">
                        <label for="editNomerTelpon" class="form-label">Nomor Telepon</label>
                        <input type="text" class="form-control" id="editNomerTelpon" name="NomerTelpon">
                        <div class="invalid-feedback" id="editNomerTelponFeedback"></div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                    <button type="submit" class="btn gold-btn">Simpan Perubahan</button>
                </div>
            </form>
        </div>
    </div>
</div>


<script src="https://unpkg.com/boxicons@2.1.4/dist/boxicons.js"></script>
@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Get the edit modal element
        const editModal = new bootstrap.Modal(document.getElementById('editPelangganModal'));
        
        // Add event listeners to all edit buttons
        document.querySelectorAll('.edit-pelanggan-btn').forEach(button => {
            button.addEventListener('click', function() {
                // Get data from button attributes
                const id = this.getAttribute('data-id');
                const name = this.getAttribute('data-name');
                const alamat = this.getAttribute('data-alamat');
                const telpon = this.getAttribute('data-telpon');
                
                // Set form action URL
                const form = document.getElementById('editPelangganForm');
                form.action = `/pelanggan/${id}`;
                
                // Populate form fields
                document.getElementById('editPelangganId').value = id;
                document.getElementById('editNamaPelanggan').value = name;
                document.getElementById('editAlamat').value = alamat || '';
                document.getElementById('editNomerTelpon').value = telpon || '';
                
                // Clear any previous validation errors
                clearValidationErrors();
                
                // Show the modal
                editModal.show();
            });
        });
        
        // Handle form submission with AJAX (optional)
        document.getElementById('editPelangganForm').addEventListener('submit', function(e) {
            e.preventDefault();
            
            const form = this;
            const formData = new FormData(form);
            
            fetch(form.action, {
                method: 'POST',
                body: formData,
                headers: {
                    'X-Requested-With': 'XMLHttpRequest'
                }
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    // Success! Close modal and refresh page
                    editModal.hide();
                    showToast('Member berhasil diperbarui!', 'success');
                    
                    // Reload the page after a brief delay
                    setTimeout(() => {
                        window.location.reload();
                    }, 1000);
                } else if (data.errors) {
                    // Handle validation errors
                    displayValidationErrors(data.errors);
                }
            })
            .catch(error => {
                console.error('Error:', error);
                showToast('Terjadi kesalahan. Silakan coba lagi.', 'error');
            });
        });
        
        // Helper function to clear validation errors
        function clearValidationErrors() {
            document.querySelectorAll('.is-invalid').forEach(el => {
                el.classList.remove('is-invalid');
            });
            
            document.querySelectorAll('.invalid-feedback').forEach(el => {
                el.textContent = '';
            });
        }
        
        // Helper function to display validation errors
        function displayValidationErrors(errors) {
            Object.keys(errors).forEach(field => {
                const inputField = document.getElementById('edit' + field.charAt(0).toUpperCase() + field.slice(1));
                const feedbackElement = document.getElementById('edit' + field.charAt(0).toUpperCase() + field.slice(1) + 'Feedback');
                
                if (inputField && feedbackElement) {
                    inputField.classList.add('is-invalid');
                    feedbackElement.textContent = errors[field][0];
                }
            });
        }
        
        // Helper function to show toast notifications
        function showToast(message, type = 'info') {
            // If you have a toast component
            // Here you could trigger a toast notification if you have one
            // For this example, we'll create a simple alert
            alert(message);
        }
    });
</script>
@endpush
@endsection