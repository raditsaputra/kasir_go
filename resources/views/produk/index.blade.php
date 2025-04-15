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
    
    .blue-btn {
        background-color: var(--dark-blue);
        color: white;
        border: none;
        font-weight: 500;
        transition: all 0.3s ease;
    }
    
    .blue-btn:hover {
        background-color: #193666;
        color: white;
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
    }
    
    .blue-table {
        border-radius: 0.5rem;
        overflow: hidden;
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.05);
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
        margin-bottom: 0.5rem;
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
    
    .alert-danger {
        background-color: #f8d7da;
        border-color: #dc3545;
        color: #721c24;
        border-left: 4px solid #dc3545;
    }
    
    .product-img {
        width: 80px;
        height: 80px;
        object-fit: cover;
        border-radius: 0.25rem;
        border: 1px solid #e5e7eb;
        padding: 3px;
        background: white;
    }
    
    .status-badge {
        padding: 0.35em 0.65em;
        font-size: 0.75em;
        font-weight: 500;
        border-radius: 0.25rem;
    }
    
    .status-tersedia {
        background-color: var(--gold);
        color: var(--dark-blue);
    }
    
    .status-habis {
        background-color: #dc3545;
        color: white;
    }
    
    .input-group-text {
        background-color: var(--dark-blue);
        color: white;
        border: 1px solid var(--dark-blue);
    }
</style>
@endpush

@section('content')
<div class="main-content">
    <div class="page-header">
        <h2 class="m-0 fs-3">Daftar Produk</h2>
    </div>

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <i class="bi bi-check-circle-fill me-2"></i>
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    @if(session('error'))
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <i class="bi bi-exclamation-circle-fill me-2"></i>
            {{ session('error') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <div class="d-flex justify-content-between align-items-center mb-4">
        <span class="text-muted">Total Produk: {{ count($produks) }}</span>
        @if(auth()->user()->role === 'admin')
            <button class="btn gold-btn d-flex align-items-center" data-bs-toggle="modal" data-bs-target="#addProductModal">
                <i class="bi bi-plus-circle me-2"></i> Tambah Produk
            </button>
        @endif
    </div>

    <div class="card blue-table">
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table mb-0">
                    <thead>
                        <tr>
                            <th width="60">No</th>
                            <th width="100">Gambar</th>
                            <th>Nama Produk</th>
                            <th>Harga</th>
                            <th>Stok</th>
                            <th>Status</th>
                            @if(auth()->user()->role === 'admin')
                                <th width="150">Aksi</th>
                            @endif
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($produks as $index => $produk)
                            <tr>
                                <td>{{ $index + 1 }}</td>
                                <td>
                                    <img class="product-img" src="{{ $produk->gambar ? asset('/storage/' . $produk->gambar) : asset('images/default.jpg') }}" 
                                         alt="{{ $produk->nama_produk }}">
                                </td>
                                <td>{{ $produk->nama_produk }}</td>
                                <td>Rp {{ number_format($produk->harga, 0, ',', '.') }}</td>
                                <td>{{ $produk->stok }}</td>
                                <td>
                                    <span class="status-badge {{ $produk->status == 'tersedia' ? 'status-tersedia' : 'status-habis' }}">
                                        {{ ucfirst($produk->status) }}
                                    </span>
                                </td>
                                @if(auth()->user()->role === 'admin')
                                    <td>
                                        <button class="btn action-btn edit-btn" data-bs-toggle="modal" data-bs-target="#editProductModal"
                                            data-id="{{ $produk->produk_id }}"
                                            data-nama="{{ $produk->nama_produk }}"
                                            data-harga="{{ $produk->harga }}"
                                            data-stok="{{ $produk->stok }}"
                                            data-status="{{ $produk->status }}"
                                            data-gambar="{{ $produk->gambar }}">
                                            <box-icon type='solid' name='edit-alt'></box-icon>
                                        </button>

                                        <form action="{{ route('produk.destroy', $produk->produk_id) }}" method="POST" class="d-inline" onsubmit="return confirm('Yakin ingin menghapus produk ini?');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn action-btn delete-btn">
                                            <box-icon name='trash'></box-icon>
                                            </button>
                                        </form>
                                    </td>
                                @endif
                            </tr>
                        @empty
                            <tr>
                                <td colspan="{{ auth()->user()->role === 'admin' ? '7' : '6' }}" class="text-center py-4">Belum ada data produk</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<!-- Modal Tambah Produk -->
<div class="modal fade" id="addProductModal" tabindex="-1" aria-labelledby="addProductModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <form action="{{ route('produk.store') }}" method="POST" enctype="multipart/form-data" class="modal-content">
            @csrf
            <div class="modal-header">
                <h5 class="modal-title">Tambah Produk</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="mb-3">
                    <label class="form-label">Nama Produk</label>
                    <input type="text" name="nama_produk" class="form-control" required>
                </div>
                <div class="mb-3">
                    <label class="form-label">Harga</label>
                    <div class="input-group">
                        <span class="input-group-text">Rp</span>
                        <input type="number" name="harga" step="0.01" class="form-control" required>
                    </div>
                </div>
                <div class="mb-3">
                    <label class="form-label">Stok</label>
                    <input type="number" name="stok" class="form-control" required>
                </div>
                <div class="mb-3">
                    <label class="form-label">Gambar</label>
                    <input type="file" name="gambar" class="form-control">
                </div>
                <div class="mb-3">
                    <label class="form-label">Status</label>
                    <select name="status" class="form-select" required>
                        <option value="tersedia">Tersedia</option>
                        <option value="habis">Habis</option>
                    </select>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                <button type="submit" class="btn gold-btn">Simpan</button>
            </div>
        </form>
    </div>
</div>

<!-- Modal Edit Produk -->
<div class="modal fade" id="editProductModal" tabindex="-1" aria-labelledby="editProductModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <form action="" method="POST" enctype="multipart/form-data" class="modal-content" id="editProductForm">
            @csrf
            @method('PUT')
            <div class="modal-header">
                <h5 class="modal-title">Edit Produk</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="mb-3">
                    <label class="form-label">Nama Produk</label>
                    <input type="text" name="nama_produk" id="edit_nama_produk" class="form-control" required>
                </div>
                <div class="mb-3">
                    <label class="form-label">Harga</label>
                    <div class="input-group">
                        <span class="input-group-text">Rp</span>
                        <input type="number" name="harga" id="edit_harga" step="0.01" class="form-control" required>
                    </div>
                </div>
                <div class="mb-3">
                    <label class="form-label">Stok</label>
                    <input type="number" name="stok" id="edit_stok" class="form-control" required>
                </div>
                <div class="mb-3">
                    <label class="form-label">Gambar</label>
                    <input type="file" name="gambar" class="form-control">
                    <small class="text-muted">Kosongkan jika tidak ingin mengganti gambar</small>
                </div>
                <div class="mb-3">
                    <label class="form-label">Status</label>
                    <select name="status" id="edit_status" class="form-select" required>
                        <option value="tersedia">Tersedia</option>
                        <option value="habis">Habis</option>
                    </select>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                <button type="submit" class="btn gold-btn">Simpan Perubahan</button>
            </div>
        </form>
    </div>
</div>

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function () {
    const editModal = document.getElementById('editProductModal');

    editModal.addEventListener('show.bs.modal', function (event) {
        const button = event.relatedTarget;
        const id = button.getAttribute('data-id');
        const nama = button.getAttribute('data-nama');
        const harga = button.getAttribute('data-harga');
        const stok = button.getAttribute('data-stok');
        const status = button.getAttribute('data-status');

        document.getElementById('edit_nama_produk').value = nama;
        document.getElementById('edit_harga').value = harga;
        document.getElementById('edit_stok').value = stok;
        
        // Correctly set the status dropdown value
        const statusSelect = document.getElementById('edit_status');
        for (let i = 0; i < statusSelect.options.length; i++) {
            if (statusSelect.options[i].value === status) {
                statusSelect.options[i].selected = true;
                break;
            }
        }

        const form = document.getElementById('editProductForm');
        form.action = "{{ url('produk') }}/" + id;
    });
});
</script>
@endpush
@endsection