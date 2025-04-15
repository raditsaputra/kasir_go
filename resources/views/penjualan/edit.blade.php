@extends('layout.app')

@section('content')
<div class="main-content">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <div class="d-flex justify-content-between align-items-center">
                        <h5 class="mb-0">Edit Transaksi #{{ $penjualan->kode_transaksi }}</h5>
                        <a href="{{ route('penjualan.index') }}" class="btn btn-sm btn-secondary">Kembali</a>
                    </div>
                </div>

                <div class="card-body">
                    @if (session('error'))
                        <div class="alert alert-danger">
                            {{ session('error') }}
                        </div>
                    @endif

                    <form action="{{ route('penjualan.update', $penjualan->penjualan_id) }}" method="POST" id="penjualanForm">
                        @csrf
                        @method('PUT')
                        
                        <div class="row mb-3">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="tanggal_penjualan">Tanggal Penjualan</label>
                                    <input type="date" name="tanggal_penjualan" id="tanggal_penjualan" class="form-control @error('tanggal_penjualan') is-invalid @enderror" value="{{ old('tanggal_penjualan', $penjualan->tanggal_penjualan) }}" required>
                                    @error('tanggal_penjualan')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="Peran">Peran</label>
                                    <select name="Peran" id="peranSelect" class="form-control @error('Peran') is-invalid @enderror" required>
                                        <option value="">Pilih Peran</option>
                                        <option value="Pelanggan" {{ old('Peran', $penjualan->Peran) == 'Pelanggan' ? 'selected' : '' }}>Pelanggan</option>
                                        <option value="Member" {{ old('Peran', $penjualan->Peran) == 'Member' ? 'selected' : '' }}>Member</option>
                                    </select>
                                    @error('Peran')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div id="pelangganIdField" class="{{ old('Peran', $penjualan->Peran) == 'Member' ? '' : 'hidden' }} mb-3">
                            <label class="block text-sm font-medium text-gray-700">Cari Member Berdasarkan No. Telepon</label>
                            <div class="relative">
                                <input type="text" 
                                    id="memberSearch" 
                                    placeholder="Masukkan nomor telepon member..."
                                    class="form-control">
                                <div id="searchResults" class="absolute z-10 w-full mt-1 bg-white shadow-lg rounded-md max-h-60 overflow-y-auto hidden"></div>
                            </div>
                            <div id="selectedMemberContainer" class="mt-2 {{ $penjualan->PelangganID ? '' : 'hidden' }}">
                                <label class="block text-sm font-medium text-gray-700">Member Terpilih</label>
                                <select name="PelangganID" id="selectedPelangganID" class="form-control @error('PelangganID') is-invalid @enderror" {{ old('Peran', $penjualan->Peran) == 'Member' ? 'required' : '' }}>
                                    <option value="">Pilih Member</option>
                                    @if($penjualan->PelangganID && $penjualan->pelanggan)
                                        <option value="{{ $penjualan->PelangganID }}" selected>
                                            {{ $penjualan->pelanggan->NamaPelanggan ?? 'Unknown' }} - {{ $penjualan->pelanggan->NomerTelpon ?? 'No Phone' }}
                                        </option>
                                    @endif
                                </select>
                                @error('PelangganID')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group mb-3">
                            <label>Produk</label>
                            <div class="table-responsive">
                                <table class="table table-bordered table-products">
                                    <thead>
                                        <tr>
                                            <th>Produk</th>
                                            <th width="150">Harga</th>
                                            <th width="100">Stok</th>
                                            <th width="100">Jumlah</th>
                                            <th width="200">Subtotal</th>
                                            <th width="50">Aksi</th>
                                        </tr>
                                    </thead>
                                    <tbody id="product_table">
                                        @foreach($penjualan->detailPenjualan as $index => $detail)
                                            <tr class="product-row">
                                                <td>
                                                    <select name="produk[]" class="form-control produk-select" required>
                                                        <option value="">Pilih Produk</option>
                                                        @foreach($produk as $p)
                                                            <option value="{{ $p->produk_id }}" 
                                                                data-harga="{{ $p->harga }}" 
                                                                data-stok="{{ $p->stok + ($detail->produk_id == $p->produk_id ? $detail->JumlahProduk : 0) }}"
                                                                {{ $detail->produk_id == $p->produk_id ? 'selected' : '' }}>
                                                                {{ $p->nama_produk }}
                                                            </option>
                                                        @endforeach
                                                    </select>
                                                </td>
                                                <td>
                                                    <input type="text" class="form-control harga-display" value="{{ number_format($detail->produk->harga, 0, ',', '.') }}" readonly>
                                                </td>
                                                <td>
                                                    <input type="text" class="form-control stok-display" value="{{ $detail->produk->stok + $detail->JumlahProduk }}" readonly>
                                                </td>
                                                <td>
                                                    <input type="number" name="jumlah_produk[]" class="form-control jumlah-produk" value="{{ $detail->JumlahProduk }}" min="1" required>
                                                </td>
                                                <td>
                                                    <input type="text" class="form-control subtotal-display" value="{{ number_format($detail->Subtotal, 0, ',', '.') }}" readonly>
                                                </td>
                                                <td>
                                                    <button type="button" class="btn btn-sm btn-danger remove-row">
                                                        <i class="fas fa-trash"></i>
                                                    </button>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                    <tfoot>
                                        <tr>
                                            <td colspan="6">
                                                <button type="button" class="btn btn-sm btn-success" id="add_product">
                                                    <i class="fas fa-plus"></i> Tambah Produk
                                                </button>
                                            </td>
                                        </tr>
                                    </tfoot>
                                </table>
                            </div>
                        </div>

                        <div class="row mb-3">
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="total_harga">Total Harga</label>
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text">Rp</span>
                                        </div>
                                        <input type="text" id="total_harga" class="form-control" value="{{ number_format($penjualan->total_harga, 0, ',', '.') }}" readonly>
                                        <input type="hidden" name="total_harga_numeric" id="total_harga_numeric" value="{{ $penjualan->total_harga }}">
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="uang_bayar">Uang Bayar</label>
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text">Rp</span>
                                        </div>
                                        <input type="text" name="uang_bayar_display" id="uang_bayar_display" class="form-control" value="{{ number_format($penjualan->uang_bayar, 0, ',', '.') }}" required>
                                        <input type="hidden" name="uang_bayar" id="uang_bayar" value="{{ $penjualan->uang_bayar }}">
                                    </div>
                                    @error('uang_bayar')
                                        <div class="text-danger">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="uang_kembali">Uang Kembali</label>
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text">Rp</span>
                                        </div>
                                        <input type="text" id="uang_kembali" class="form-control" value="{{ number_format($penjualan->uang_kembali, 0, ',', '.') }}" readonly>
                                        <input type="hidden" name="uang_kembali_numeric" id="uang_kembali_numeric" value="{{ $penjualan->uang_kembali }}">
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="form-group text-center mt-4">
                            <button type="submit" class="btn btn-primary px-5">Simpan Perubahan</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Template for new product row -->
<template id="product_row_template">
    <tr class="product-row">
        <td>
            <select name="produk[]" class="form-control produk-select" required>
                <option value="">Pilih Produk</option>
                @foreach($produk as $p)
                    <option value="{{ $p->produk_id }}" data-harga="{{ $p->harga }}" data-stok="{{ $p->stok }}">
                        {{ $p->nama_produk }}
                    </option>
                @endforeach
            </select>
        </td>
        <td>
            <input type="text" class="form-control harga-display" value="0" readonly>
        </td>
        <td>
            <input type="text" class="form-control stok-display" value="0" readonly>
        </td>
        <td>
            <input type="number" name="jumlah_produk[]" class="form-control jumlah-produk" value="1" min="1" required>
        </td>
        <td>
            <input type="text" class="form-control subtotal-display" value="0" readonly>
        </td>
        <td>
            <button type="button" class="btn btn-sm btn-danger remove-row">
                <i class="fas fa-trash"></i>
            </button>
        </td>
    </tr>
</template>
@endsection

@section('scripts')
<script>
    $(document).ready(function() {
        // Handle role selection
        $('#peranSelect').on('change', function() {
            if ($(this).val() === 'Member') {
                $('#pelangganIdField').removeClass('hidden');
                $('#selectedPelangganID').prop('required', true);
            } else {
                $('#pelangganIdField').addClass('hidden');
                $('#selectedPelangganID').prop('required', false);
            }
        });

        // Member search functionality
        $('#memberSearch').on('input', function() {
            const phoneNumber = $(this).val().trim();
            if (phoneNumber.length >= 3) {
                // Make AJAX request to search for members
                $.ajax({
                    url: '/search-members',
                    type: 'GET',
                    data: { phone: phoneNumber },
                    success: function(data) {
                        // Clear previous results
                        $('#searchResults').empty();
                        
                        if (data.length > 0) {
                            // Display search results
                            data.forEach(function(member) {
                                $('#searchResults').append(`
                                    <div class="p-2 hover:bg-gray-100 cursor-pointer member-item" 
                                         data-id="${member.PelangganID}" 
                                         data-name="${member.NamaPelanggan}"
                                         data-phone="${member.NomerTelpon}">
                                        <p class="font-medium">${member.NamaPelanggan}</p>
                                        <p class="text-sm text-gray-600">${member.NomerTelpon}</p>
                                    </div>
                                `);
                            });
                            
                            $('#searchResults').removeClass('hidden');
                            
                            // Handle member selection
                            $('.member-item').click(function() {
                                const id = $(this).data('id');
                                const name = $(this).data('name');
                                const phone = $(this).data('phone');
                                
                                // Update the selected member dropdown
                                $('#selectedPelangganID').empty().append(`
                                    <option value="${id}" selected>${name} - ${phone}</option>
                                `);
                                
                                // Show the selected member container
                                $('#selectedMemberContainer').removeClass('hidden');
                                
                                // Hide search results
                                $('#searchResults').addClass('hidden');
                                
                                // Clear search input
                                $('#memberSearch').val('');
                            });
                        } else {
                            $('#searchResults').append(`
                                <div class="p-2">
                                    <p class="text-sm text-gray-600">No members found</p>
                                </div>
                            `);
                            $('#searchResults').removeClass('hidden');
                        }
                    },
                    error: function() {
                        console.error('Error searching members');
                    }
                });
            } else {
                $('#searchResults').addClass('hidden');
            }
        });

        // Hide search results when clicking outside
        $(document).on('click', function(e) {
            if (!$(e.target).closest('#memberSearch, #searchResults').length) {
                $('#searchResults').addClass('hidden');
            }
        });

        // Format currency
        function formatCurrency(amount) {
            return new Intl.NumberFormat('id-ID').format(amount);
        }

        // Parse currency string to number
        function parseCurrency(value) {
            return parseFloat(value.replace(/\./g, '').replace(',', '.')) || 0;
        }

        // Add new product row
        $('#add_product').click(function() {
            var template = document.getElementById('product_row_template').content.cloneNode(true);
            $('#product_table').append(template);
            
            // Re-bind events to the new row
            bindProductEvents();
            calculateTotal();
        });

        // Remove product row
        function bindProductEvents() {
            // Remove row event
            $('.remove-row').off('click').on('click', function() {
                if ($('.product-row').length > 1) {
                    $(this).closest('tr').remove();
                    calculateTotal();
                } else {
                    alert('Minimal harus ada satu produk!');
                }
            });

            // Product selection event
            $('.produk-select').off('change').on('change', function() {
                var row = $(this).closest('tr');
                var selectedOption = $(this).find('option:selected');
                
                var harga = selectedOption.data('harga') || 0;
                var stok = selectedOption.data('stok') || 0;
                
                row.find('.harga-display').val(formatCurrency(harga));
                row.find('.stok-display').val(stok);
                
                // Reset jumlah to 1 when changing products
                row.find('.jumlah-produk').val(1);
                
                // Calculate subtotal
                calculateSubtotal(row);
                calculateTotal();
            });

            // Quantity change event
            $('.jumlah-produk').off('input').on('input', function() {
                var row = $(this).closest('tr');
                calculateSubtotal(row);
                calculateTotal();
            });
        }

        // Calculate subtotal for a row
        function calculateSubtotal(row) {
            var harga = parseCurrency(row.find('.harga-display').val());
            var jumlah = parseInt(row.find('.jumlah-produk').val()) || 0;
            var stok = parseInt(row.find('.stok-display').val()) || 0;
            
            // Validate quantity against stock
            if (jumlah > stok) {
                alert('Jumlah tidak boleh melebihi stok yang tersedia!');
                row.find('.jumlah-produk').val(stok);
                jumlah = stok;
            }
            
            var subtotal = harga * jumlah;
            row.find('.subtotal-display').val(formatCurrency(subtotal));
        }

        // Calculate total
        function calculateTotal() {
            var total = 0;
            $('.subtotal-display').each(function() {
                total += parseCurrency($(this).val());
            });
            
            $('#total_harga').val(formatCurrency(total));
            $('#total_harga_numeric').val(total);
            
            // Recalculate change
            calculateChange();
        }

        // Format payment input
        $('#uang_bayar_display').on('input', function() {
            var value = $(this).val().replace(/\D/g, '');
            $(this).val(formatCurrency(value));
            $('#uang_bayar').val(value);
            calculateChange();
        });

        // Calculate change
        function calculateChange() {
            var total = parseFloat($('#total_harga_numeric').val()) || 0;
            var bayar = parseFloat($('#uang_bayar').val()) || 0;
            var kembali = bayar - total;
            
            if (kembali < 0) {
                kembali = 0;
            }
            
            $('#uang_kembali').val(formatCurrency(kembali));
            $('#uang_kembali_numeric').val(kembali);
        }

        // Bind all events on page load
        bindProductEvents();
        
        // Form submission validation
        $('#penjualanForm').submit(function(e) {
            var total = parseFloat($('#total_harga_numeric').val()) || 0;
            var bayar = parseFloat($('#uang_bayar').val()) || 0;
            
            if (bayar < total) {
                e.preventDefault();
                alert('Uang bayar tidak mencukupi!');
                return false;
            }
            
            if ($('.product-row').length === 0) {
                e.preventDefault();
                alert('Minimal harus ada satu produk!');
                return false;
            }
            
            return true;
        });
    });
</script>
@endsection