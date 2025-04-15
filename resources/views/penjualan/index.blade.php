@extends('layout.app')

@section('content')
<div class="main-content">
    <div class="bg-white rounded-lg shadow-lg overflow-hidden">
        <div class="p-6 flex justify-between items-center border-b">
            <h1 class="text-2xl font-semibold text-gray-800">Daftar Penjualan</h1>
            <button type="button" 
                    class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2"
                    onclick="showModal()">
                Tambah Penjualan
            </button>
        </div>

        <!-- Alert Messages -->
        @if(session('success'))
        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative m-4" role="alert">
            <span class="block sm:inline">{{ session('success') }}</span>
        </div>
        @endif

        @if($penjualan->isEmpty())
            <p class="text-gray-500">Tidak ada data penjualan dengan kode transaksi tersebut.</p>
        @endif


        @if(session('error'))
        <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative m-4" role="alert">
            <span class="block sm:inline">{{ session('error') }}</span>
        </div>
        @endif
        

        <form method="GET" action="{{ route('penjualan.index') }}" class="flex items-center space-x-2 mb-4">
            <input
                type="text"
                name="search"
                value="{{ request('search') }}"
                placeholder="Cari berdasarkan kode transaksi"
                class="px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring focus:border-blue-300"
            />
            <button
                type="submit"
                class="px-4 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700"
            >
                Cari
            </button>
        </form>

</form>

        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th scope="col" class="px-6 py-3 text-left t`ext-xs font-medium text-gray-500 uppercase tracking-wider">No</th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Kode Transaksi</th>  <!-- New column -->
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Tanggal Penjualan</th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Peran</th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Produk</th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Total Harga</th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Uang Bayar</th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Uang Kembali</th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Aksi</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @forelse($penjualan as $index => $item)
                    <tr>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                            {{ $index + 1 }}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                            {{ $item->kode_transaksi }}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                            {{ \Carbon\Carbon::parse($item->tanggal_penjualan)->format('d/m/Y H:i') }}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full 
                                {{ $item->Peran === 'Member' ? 'bg-green-100 text-green-800' : 'bg-blue-100 text-blue-800' }}">
                                {{ $item->Peran }}
                            </span>
                        </td>
                        <td class="px-6 py-4 text-sm text-gray-900">
                            <div class="space-y-1">
                                @if($item->detailPenjualan->isEmpty())
                                    <div class="text-red-500">Detail tidak ditemukan</div>
                                @else
                                    @foreach($item->detailPenjualan as $detail)
                                        <div>
                                            {{ optional($detail->produk)->nama_produk ?? 'Produk tidak ditemukan' }} 
                                            ({{ $detail->JumlahProduk }})
                                        </div>
                                    @endforeach
                                @endif
                            </div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                            Rp {{ number_format($item->total_harga, 0, ',', '.') }}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                            Rp {{ number_format($item->uang_bayar, 0, ',', '.') }}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                            Rp {{ number_format($item->uang_kembali, 0, ',', '.') }}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                            <div class="flex space-x-2">
                            <!-- Inside the actions column -->
                                <div class="relative inline-block text-left">
                                    <button type="button" 
                                            class="text-green-600 hover:text-green-900 px-2 py-1 bg-green-100 rounded-md"
                                            onclick="toggleDropdown({{ $item->penjualan_id }})">
                                        Struk
                                    </button>
                                    <div id="dropdown-{{ $item->penjualan_id }}" class="hidden absolute right-0 mt-2 w-48 rounded-md shadow-lg bg-white ring-1 ring-black ring-opacity-5 z-10">
                                        <div class="py-1">
                                            <a href="{{ route('penjualan.pdf', $item->penjualan_id) }}" 
                                            target="_blank"
                                            class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
                                                Preview Struk
                                            </a>
                                            <a href="{{ route('penjualan.downloadPdf', $item->penjualan_id) }}" 
                                            class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
                                                Download Struk
                                            </a>
                                        </div>
                                    </div>
                            </div>
                                <a href="{{ route('penjualan.edit', $item->penjualan_id) }}" 
                                class="text-yellow-600 hover:text-yellow-900">
                                    <span class="px-2 py-1 bg-yellow-100 rounded-md">Edit</span>
                                </a>
                                @auth
                                    @if (Auth::user()->role === 'admin')
                                        <form action="{{ route('penjualan.destroy', $item->penjualan_id) }}" 
                                            method="POST" 
                                            onsubmit="return confirm('Apakah Anda yakin ingin menghapus data ini?');"
                                            class="inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="text-red-600 hover:text-red-900">
                                                <span class="px-2 py-1 bg-red-100 rounded-md">Hapus</span>
                                            </button>
                                        </form>
                                    @endif
                                @endauth
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="8" class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 text-center">
                            Tidak ada data penjualan
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- Modal -->
<div id="createModal" 
     class="hidden fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full z-50">
    <div class="relative top-20 mx-auto p-5 border w-full max-w-4xl shadow-lg rounded-lg bg-white">
        <div class="flex justify-between items-center pb-3 border-b">
            <h3 class="text-xl font-semibold text-gray-900">Tambah Penjualan Baru</h3>
            <button onclick="hideModal()" 
                    class="text-gray-400 hover:text-gray-500 focus:outline-none">
                <span class="text-2xl">&times;</span>
            </button>
        </div>

        <form action="{{ route('penjualan.store') }}" method="POST" id="formPenjualan">
            @csrf
            <div class="space-y-6 py-4">
                <!-- Validation Errors -->
                <div id="validationErrors" class="hidden mb-4 p-4 bg-red-100 rounded-md border border-red-400 text-red-700">
                    <ul class="list-disc pl-5"></ul>
                </div>
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Tanggal Penjualan</label>
                        <input type="datetime-local" 
                               name="tanggal_penjualan" 
                               value="{{ now()->format('Y-m-d\TH:i') }}" 
                               class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500"
                               required>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Peran</label>
                        <select name="Peran" 
                                id="peranSelect"
                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500"
                                required>
                            <option value="">Pilih Peran</option>
                            <option value="Pelanggan">Pelanggan</option>
                            <option value="Member">Member</option>
                        </select>
                    </div>

                    <div id="pelangganIdField" class="hidden">
                        <label class="block text-sm font-medium text-gray-700">Cari Member Berdasarkan No. Telepon</label>
                        <div class="relative">
                            <input type="text" 
                                id="memberSearch" 
                                placeholder="Masukkan nomor telepon member..."
                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                            <div id="searchResults" class="absolute z-10 w-full mt-1 bg-white shadow-lg rounded-md max-h-60 overflow-y-auto hidden"></div>
                        </div>
                        <div id="selectedMemberContainer" class="mt-2 hidden">
                            <label class="block text-sm font-medium text-gray-700">Member Terpilih</label>
                            <select name="PelangganID" id="selectedPelangganID" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500" required>
                                <option value="">Pilih Member</option>
                            </select>
                        </div>
                    </div>
                </div>

                <div id="produkContainer" class="space-y-4">
                    <div class="produk-row grid grid-cols-12 gap-4 items-end">
                        <div class="col-span-5">
                            <label class="block text-sm font-medium text-gray-700">Produk</label>
                            <select name="produk[]" 
                                    class="produk-select mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500"
                                    required>
                                <option value="">Pilih Produk</option>
                                @foreach($produk as $p)
                                    <option value="{{ $p->produk_id }}" data-harga="{{ $p->harga }}">
                                        {{ $p->nama_produk }} - Rp {{ number_format($p->harga, 0, ',', '.') }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-span-3">
                            <label class="block text-sm font-medium text-gray-700">Jumlah</label>
                            <input type="number" 
                                   name="jumlah_produk[]" 
                                   value="1" 
                                   min="1" 
                                   class="jumlah-produk mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500"
                                   required>
                        </div>
                        <div class="col-span-3">
                            <label class="block text-sm font-medium text-gray-700">Subtotal</label>
                            <input type="text" 
                                   class="subtotal mt-1 block w-full rounded-md border-gray-300 bg-gray-50 shadow-sm"
                                   readonly>
                        </div>
                        <div class="col-span-1">
                            <button type="button" 
                                    class="delete-row w-full px-3 py-2 text-sm font-medium text-white bg-red-600 rounded-md hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-red-500 focus:ring-offset-2">
                                Hapus
                            </button>
                        </div>
                    </div>
                </div>

                <div class="mt-4">
                    <button type="button" 
                            id="tambahProduk"
                            class="px-4 py-2 text-sm font-medium text-white bg-green-600 rounded-md hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-green-500 focus:ring-offset-2">
                        Tambah Produk
                    </button>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Total Harga</label>
                        <input type="text" 
                               id="total_harga" 
                               name="total_harga"
                               class="mt-1 block w-full rounded-md border-gray-300 bg-gray-50 shadow-sm"
                               readonly>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Uang Bayar</label>
                        <input type="number" 
                               name="uang_bayar" 
                               id="uang_bayar"
                               class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500"
                               required>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Uang Kembali</label>
                        <input type="text" 
                               id="uang_kembali" 
                               name="uang_kembali"
                               class="mt-1 block w-full rounded-md border-gray-300 bg-gray-50 shadow-sm"
                               readonly>
                    </div>
                </div>
            </div>

            <div class="mt-6 flex justify-end space-x-3 border-t pt-4">
                <button type="button" 
                        onclick="hideModal()"
                        class="px-4 py-2 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-md hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                    Tutup
                </button>
                <button type="submit" 
                        class="px-4 py-2 text-sm font-medium text-white bg-blue-600 rounded-md hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                    Simpan Penjualan
                </button>
            </div>
        </form>
    </div>
</div>

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function () {
    const produkContainer = document.getElementById('produkContainer');
    const tambahProdukBtn = document.getElementById('tambahProduk');
    const uangBayarInput = document.getElementById('uang_bayar');
    const totalHargaInput = document.getElementById('total_harga');
    const uangKembaliInput = document.getElementById('uang_kembali');
    const peranSelect = document.getElementById('peranSelect');
    const pelangganIdField = document.getElementById('pelangganIdField');
    const validationErrors = document.getElementById('validationErrors');
    const validationErrorsList = validationErrors.querySelector('ul');

    // Tampilkan field ID Pelanggan jika yang dipilih adalah Member
    peranSelect.addEventListener('change', function() {
        if (this.value === 'Member') {
            pelangganIdField.classList.remove('hidden');
            document.querySelector('input[name="PelangganID"]').setAttribute('required', 'required');
        } else {
            pelangganIdField.classList.add('hidden');
            const pelangganIdInput = document.querySelector('input[name="PelangganID"]');
            pelangganIdInput.value = '';
            pelangganIdInput.removeAttribute('required');
        }
    });

    function formatRupiah(angka) {
        const numericValue = typeof angka === 'string' ? angka.replace(/[^\d]/g, '') : angka;
        return 'Rp ' + new Intl.NumberFormat('id-ID').format(numericValue);
    }

    function unformatRupiah(rupiah) {
        return parseFloat(rupiah.replace(/[^\d]/g, ''));
    }

    function hitungSubtotal(row) {
        const produkSelect = row.querySelector('.produk-select');
        const jumlahInput = row.querySelector('.jumlah-produk');
        const subtotalInput = row.querySelector('.subtotal');

        if (produkSelect.selectedIndex > 0) {
            const harga = parseFloat(produkSelect.options[produkSelect.selectedIndex].dataset.harga);
            const jumlah = parseInt(jumlahInput.value) || 0;
            const subtotal = harga * jumlah;
            subtotalInput.value = formatRupiah(subtotal);
            return subtotal;
        }
        subtotalInput.value = '';
        return 0;
    }

    function hitungTotal() {
        let total = 0;
        document.querySelectorAll('.produk-row').forEach(row => {
            total += hitungSubtotal(row);
        });

        totalHargaInput.value = formatRupiah(total);

        // Calculate Kembalian only if uangBayar has a value
        if (uangBayarInput.value) {
            const uangBayar = parseFloat(uangBayarInput.value) || 0;
            const kembalian = uangBayar - total;
            uangKembaliInput.value = formatRupiah(Math.max(0, kembalian));
        } else {
            uangKembaliInput.value = '';
        }
    }

    function tambahkanEventListenersBaru(row) {
        const produkSelect = row.querySelector('.produk-select');
        const jumlahInput = row.querySelector('.jumlah-produk');
        const deleteBtn = row.querySelector('.delete-row');

        produkSelect.addEventListener('change', () => hitungTotal());
        jumlahInput.addEventListener('input', () => hitungTotal());
        deleteBtn.addEventListener('click', () => {
            if (document.querySelectorAll('.produk-row').length > 1) {
                row.remove();
                hitungTotal();
            } else {
                alert('Minimal harus ada satu produk!');
            }
        });
    }

    tambahProdukBtn.addEventListener('click', function() {
        const newRow = produkContainer.querySelector('.produk-row').cloneNode(true);
        newRow.querySelectorAll('input').forEach(input => {
            if (input.type === 'number') input.value = 1;
            else input.value = '';
        });
        newRow.querySelector('select').selectedIndex = 0;
        produkContainer.appendChild(newRow);
        tambahkanEventListenersBaru(newRow);
    });

    // Add listeners to initial row
    document.querySelectorAll('.produk-row').forEach(row => {
        tambahkanEventListenersBaru(row);
    });

    uangBayarInput.addEventListener('input', hitungTotal);

    document.getElementById('formPenjualan').addEventListener('submit', function(e) {
    // Prevent default form submission
    e.preventDefault();
    
    // Reset validation errors
    validationErrors.classList.add('hidden');
    validationErrorsList.innerHTML = '';
    
    // Get total without currency formatting
    const totalString = totalHargaInput.value.replace(/[^\d]/g, '');
    const total = parseFloat(totalString);
    const uangBayar = parseFloat(uangBayarInput.value) || 0;
    
    // Client-side validation
    let isValid = true;
    let errorMessages = [];
    
    if (total === 0) {
        isValid = false;
        errorMessages.push('Pilih produk dan jumlah terlebih dahulu!');
    }
    
    if (uangBayar < total) {
        isValid = false;
        errorMessages.push('Uang bayar tidak mencukupi!');
    }
    
    // Check if any required product is not selected
    const produkSelects = document.querySelectorAll('.produk-select');
    produkSelects.forEach((select, index) => {
        if (!select.value) {
            isValid = false;
            errorMessages.push(`Produk pada baris ${index + 1} harus dipilih`);
        }
    });
    
    // Check if peran is member but PelangganID is empty
    if (peranSelect.value === 'Member') {
        // Fix: Get the correct element - it should be the select element
        const pelangganIdSelect = document.getElementById('selectedPelangganID');
        if (!pelangganIdSelect.value) {
            isValid = false;
            errorMessages.push('ID Pelanggan harus diisi untuk peran Member');
        }
    }
    
    if (!isValid) {
        // Display validation errors
        errorMessages.forEach(msg => {
            const li = document.createElement('li');
            li.textContent = msg;
            validationErrorsList.appendChild(li);
        });
        validationErrors.classList.remove('hidden');
        return;
    }

    // Prepare numeric values for server
    const totalHiddenInput = document.createElement('input');
    totalHiddenInput.type = 'hidden';
    totalHiddenInput.name = 'total_harga_numeric';
    totalHiddenInput.value = total;
    this.appendChild(totalHiddenInput);

    const uangKembaliHiddenInput = document.createElement('input');
    uangKembaliHiddenInput.type = 'hidden';
    uangKembaliHiddenInput.name = 'uang_kembali_numeric';
    uangKembaliHiddenInput.value = uangBayar - total;
    this.appendChild(uangKembaliHiddenInput);

    // Submit the form traditionally
    this.submit();
});
});

function showModal() {
    document.getElementById('createModal').classList.remove('hidden');
}

function hideModal() {
    document.getElementById('createModal').classList.add('hidden');
    resetForm();
}

function resetForm() {
    const form = document.getElementById('formPenjualan');
    form.reset();
    
    // Hide validation errors
    const validationErrors = document.getElementById('validationErrors');
    validationErrors.classList.add('hidden');
    validationErrors.querySelector('ul').innerHTML = '';
    
    // Reset all rows except the first one
    const rows = document.querySelectorAll('.produk-row');
    for (let i = 1; i < rows.length; i++) {
        rows[i].remove();
    }
    
    // Reset the first row
    const firstRow = rows[0];
    firstRow.querySelector('select').selectedIndex = 0;
    firstRow.querySelector('.jumlah-produk').value = 1;
    firstRow.querySelector('.subtotal').value = '';
    
    // Reset total and payment fields
    document.getElementById('total_harga').value = '';
    document.getElementById('uang_bayar').value = '';
    document.getElementById('uang_kembali').value = '';
    
    // Reset and hide Pelanggan ID field
    document.getElementById('pelangganIdField').classList.add('hidden');
    const pelangganIdInput = document.querySelector('input[name="PelangganID"]');
    pelangganIdInput.value = '';
    pelangganIdInput.removeAttribute('required');
}

function toggleDropdown(id) {
    const dropdown = document.getElementById(`dropdown-${id}`);
    dropdown.classList.toggle('hidden');
    
    // Close dropdown when clicking outside
    document.addEventListener('click', function closeDropdown(e) {
        if (!e.target.closest(`#dropdown-${id}`) && !e.target.closest(`button[onclick="toggleDropdown(${id})"]`)) {
            dropdown.classList.add('hidden');
            document.removeEventListener('click', closeDropdown);
        }
    });
}

document.addEventListener('DOMContentLoaded', function() {
    // Get all members data
    const members = @json($pelanggan);
    
    // Debug: Check the actual structure of the data
    console.log('Member data structure:', members[0] || 'No members found');
    
    const peranSelect = document.getElementById('peranSelect');
    const pelangganIdField = document.getElementById('pelangganIdField');
    const memberSearch = document.getElementById('memberSearch');
    const searchResults = document.getElementById('searchResults');
    const selectedMemberContainer = document.getElementById('selectedMemberContainer');
    const selectedPelangganID = document.getElementById('selectedPelangganID');
    
    // Toggle visibility of search field based on selected role
    peranSelect.addEventListener('change', function() {
    if (this.value === 'Member') {
        pelangganIdField.classList.remove('hidden');
        // Update this line to use the correct element ID
        document.getElementById('selectedPelangganID').setAttribute('required', 'required');
    } else {
        pelangganIdField.classList.add('hidden');
        // Update this line to use the correct element ID
        const pelangganIdSelect = document.getElementById('selectedPelangganID');
        pelangganIdSelect.value = '';
        pelangganIdSelect.removeAttribute('required');
    }
    });
    
    // Find the actual phone number field in the member data
    function findPhoneField(member) {
        // Try common field names for phone number
        const possibleFields = ['NoTelp', 'notelp', 'no_telp', 'telepon', 'phone', 'hp', 'handphone', 'nohp'];
        
        for (const field of possibleFields) {
            if (member[field] !== undefined) {
                return field;
            }
        }
        
        // If no standard field is found, look for anything that might be a phone number
        for (const field in member) {
            const value = member[field];
            if (typeof value === 'string' && /^\d{8,15}$/.test(value.replace(/\D/g, ''))) {
                return field;
            }
        }
        
        return null;
    }
    
    // Implement search functionality with dynamic field detection
    memberSearch.addEventListener('input', function() {
        const searchTerm = this.value.trim();
        
        if (searchTerm.length < 2) {
            searchResults.classList.add('hidden');
            searchResults.innerHTML = '';
            return;
        }
        
        const filteredMembers = [];
        
        // Find the phone field from the first member
        const phoneField = members.length > 0 ? findPhoneField(members[0]) : null;
        console.log('Detected phone field:', phoneField);
        
        if (phoneField) {
            // Filter members based on detected phone field
            members.forEach(member => {
                const phoneValue = member[phoneField];
                if (phoneValue && phoneValue.toString().includes(searchTerm)) {
                    filteredMembers.push({
                        id: member.PelangganID || member.pelanggan_id || member.id,
                        name: member.Nama || member.nama || member.name,
                        phone: phoneValue
                    });
                }
            });
        } else {
            // Fallback: Search across all fields
            members.forEach(member => {
                for (const field in member) {
                    const value = member[field];
                    if (value && value.toString().includes(searchTerm)) {
                        filteredMembers.push({
                            id: member.PelangganID || member.pelanggan_id || member.id,
                            name: member.Nama || member.nama || member.name,
                            phone: value
                        });
                        break;
                    }
                }
            });
        }
        
        console.log('Filtered Members:', filteredMembers);
        
        searchResults.innerHTML = '';
        
        if (filteredMembers.length === 0) {
            searchResults.innerHTML = '<div class="p-2 text-sm text-gray-500">Tidak ada hasil</div>';
        } else {
            filteredMembers.forEach(member => {
                const item = document.createElement('div');
                item.className = 'p-2 hover:bg-gray-100 cursor-pointer text-sm';
                item.textContent = `${member.name} - ${member.phone}`;
                
                item.addEventListener('click', function() {
                    memberSearch.value = member.phone;
                    
                    // Clear existing options except the first one
                    while (selectedPelangganID.options.length > 1) {
                        selectedPelangganID.remove(1);
                    }
                    
                    // Add the selected member to the dropdown
                    const option = document.createElement('option');
                    option.value = member.id;
                    option.textContent = `${member.name} (Tel: ${member.phone})`;
                    option.selected = true;
                    selectedPelangganID.appendChild(option);
                    
                    selectedMemberContainer.classList.remove('hidden');
                    searchResults.classList.add('hidden');
                });
                
                searchResults.appendChild(item);
            });
        }
        
        searchResults.classList.remove('hidden');
    });
    
    // Hide search results when clicking outside
    document.addEventListener('click', function(event) {
        if (!searchResults.contains(event.target) && event.target !== memberSearch) {
            searchResults.classList.add('hidden');
        }
    });
});
</script>
@endpush
@endsection