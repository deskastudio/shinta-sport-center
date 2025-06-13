@extends('layouts.customer')

@section('title', 'Booking - ' . $lapangan->nm_lapangan)

@section('content')
<!-- Page Header -->
<section class="bg-primary-600 text-white py-8">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex items-center space-x-4">
            <a href="{{ route('lapangan') }}" class="text-white hover:text-primary-200">
                ← Kembali
            </a>
            <h1 class="text-2xl md:text-3xl font-bold">Booking {{ $lapangan->nm_lapangan }}</h1>
        </div>
    </div>
</section>

<!-- Booking Form -->
<section class="py-8">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
            <!-- Lapangan Info -->
            <div class="card">
                <h2 class="text-xl font-bold text-gray-800 mb-4">Informasi Lapangan</h2>
                
                @if($lapangan->foto)
                    <img src="{{ asset('storage/' . $lapangan->foto) }}" 
                         alt="{{ $lapangan->nm_lapangan }}" 
                         class="w-full h-48 object-cover rounded-lg mb-4">
                @else
                    <div class="w-full h-48 bg-gradient-to-br from-primary-100 to-primary-200 rounded-lg flex items-center justify-center mb-4">
                        <div class="text-center">
                            <span class="text-4xl text-primary-600">🏸</span>
                            <p class="text-primary-700 font-semibold mt-2">{{ $lapangan->nm_lapangan }}</p>
                        </div>
                    </div>
                @endif
                
                <div class="space-y-3">
                    <div class="flex justify-between">
                        <span class="text-gray-600">Nama Lapangan:</span>
                        <span class="font-semibold">{{ $lapangan->nm_lapangan }}</span>
                    </div>
                    <div class="flex justify-between">
                        <span class="text-gray-600">Jenis:</span>
                        <span class="bg-primary-100 text-primary-800 px-2 py-1 rounded-full text-sm">
                            {{ $lapangan->jenis_lapangan }}
                        </span>
                    </div>
                    <div class="flex justify-between">
                        <span class="text-gray-600">Harga per Jam:</span>
                        <span class="text-xl font-bold text-primary-600">
                            Rp {{ number_format($lapangan->harga_per_jam, 0, ',', '.') }}
                        </span>
                    </div>
                    <div class="pt-2 border-t">
                        <p class="text-gray-600 text-sm">{{ $lapangan->deskripsi }}</p>
                    </div>
                </div>
            </div>

            <!-- Booking Form -->
            <div class="card">
                <h2 class="text-xl font-bold text-gray-800 mb-4">Form Booking</h2>
                
                <form action="{{ route('booking.store') }}" method="POST" enctype="multipart/form-data" id="bookingForm">
                    @csrf
                    <input type="hidden" name="kd_lapangan" value="{{ $lapangan->kd_lapangan }}" id="kd_lapangan">
                    
                    <!-- Customer Info -->
                    <div class="space-y-4 mb-6">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Nama Lengkap</label>
                            <input type="text" name="nm_customer" required
                                   class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-primary-500"
                                   placeholder="Masukkan nama lengkap" value="{{ old('nm_customer') }}">
                            @error('nm_customer')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                        
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Email</label>
                            <input type="email" name="email" required
                                   class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-primary-500"
                                   placeholder="nama@email.com" value="{{ old('email') }}">
                            @error('email')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                        
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">No. HP</label>
                            <input type="text" name="no_hp" required
                                   class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-primary-500"
                                   placeholder="08123456789" value="{{ old('no_hp') }}">
                            @error('no_hp')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                        
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Alamat</label>
                            <textarea name="alamat" required rows="2"
                                      class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-primary-500"
                                      placeholder="Alamat lengkap">{{ old('alamat') }}</textarea>
                            @error('alamat')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    <!-- Date Selection -->
                    <div class="mb-6">
                        <label class="block text-sm font-medium text-gray-700 mb-1">Tanggal Main</label>
                        <input type="date" name="tgl_main" required id="tglMain"
                               min="{{ date('Y-m-d') }}"
                               class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-primary-500"
                               value="{{ old('tgl_main') }}">
                        @error('tgl_main')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Time Slots -->
                    <div class="mb-6">
                        <label class="block text-sm font-medium text-gray-700 mb-3">Pilih Slot Waktu</label>
                        
                        <!-- Loading indicator -->
                        <div id="slotsLoading" class="text-center py-4 hidden">
                            <div class="inline-block animate-spin rounded-full h-6 w-6 border-b-2 border-primary-600"></div>
                            <p class="text-sm text-gray-500 mt-2">Mengecek ketersediaan slot...</p>
                        </div>
                        
                        <!-- No date selected message -->
                        <div id="noDateSelected" class="text-center py-8 text-gray-500">
                            <span class="text-3xl">📅</span>
                            <p class="mt-2">Pilih tanggal terlebih dahulu untuk melihat slot yang tersedia</p>
                        </div>
                        
                        <!-- Slots container -->
                        <div class="grid grid-cols-2 sm:grid-cols-3 gap-2" id="timeSlots">
                            <!-- Slots will be loaded here via JavaScript -->
                        </div>
                        
                        @error('kd_slot')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Payment Info -->
                    <div class="mb-6 p-4 bg-yellow-50 border border-yellow-200 rounded-lg">
                        <h3 class="font-semibold text-yellow-800 mb-2">Informasi Pembayaran</h3>
                        <p class="text-sm text-yellow-700 mb-2">Transfer ke rekening berikut:</p>
                        <div class="text-sm text-yellow-800">
                            <p><strong>Bank BCA: 1234567890</strong></p>
                            <p><strong>A.n: Shinta Sport Center</strong></p>
                            <p class="mt-2">Total: <span class="font-bold">Rp {{ number_format($lapangan->harga_per_jam, 0, ',', '.') }}</span></p>
                        </div>
                    </div>

                    <!-- Upload Bukti Bayar -->
                    <div class="mb-6">
                        <label class="block text-sm font-medium text-gray-700 mb-1">Upload Bukti Bayar</label>
                        <input type="file" name="bukti_bayar" accept="image/*" required
                               class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-primary-500">
                        <p class="text-xs text-gray-500 mt-1">Format: JPG, PNG. Max: 2MB</p>
                        @error('bukti_bayar')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Catatan -->
                    <div class="mb-6">
                        <label class="block text-sm font-medium text-gray-700 mb-1">Catatan (Opsional)</label>
                        <textarea name="catatan" rows="2"
                                  class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-primary-500"
                                  placeholder="Catatan tambahan...">{{ old('catatan') }}</textarea>
                    </div>

                    <!-- Submit Button -->
                    <button type="submit" id="submitBtn" disabled
                            class="w-full bg-gray-400 text-white py-3 rounded-lg font-semibold cursor-not-allowed transition-colors">
                        Pilih slot waktu terlebih dahulu
                    </button>
                </form>
            </div>
        </div>
    </div>
</section>

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    const tglMainInput = document.getElementById('tglMain');
    const timeSlotsContainer = document.getElementById('timeSlots');
    const slotsLoading = document.getElementById('slotsLoading');
    const noDateSelected = document.getElementById('noDateSelected');
    const submitBtn = document.getElementById('submitBtn');
    const kd_lapangan = document.getElementById('kd_lapangan').value;
    
    // All available slots from server
    const allSlots = @json($slots);
    
    let selectedSlot = null;
    
    // Function to enable/disable submit button
    function updateSubmitButton() {
        if (selectedSlot) {
            submitBtn.disabled = false;
            submitBtn.classList.remove('bg-gray-400', 'cursor-not-allowed');
            submitBtn.classList.add('bg-primary-600', 'hover:bg-primary-700');
            submitBtn.textContent = 'Booking Sekarang';
        } else {
            submitBtn.disabled = true;
            submitBtn.classList.add('bg-gray-400', 'cursor-not-allowed');
            submitBtn.classList.remove('bg-primary-600', 'hover:bg-primary-700');
            submitBtn.textContent = 'Pilih slot waktu terlebih dahulu';
        }
    }
    
    // Function to convert time string to minutes for sorting
    function timeToMinutes(timeStr) {
        const [hours, minutes] = timeStr.split(':').map(Number);
        return hours * 60 + minutes;
    }
    
    // Function to load available slots
    function loadAvailableSlots(tgl_main) {
        // Show loading
        slotsLoading.classList.remove('hidden');
        noDateSelected.classList.add('hidden');
        timeSlotsContainer.innerHTML = '';
        selectedSlot = null;
        updateSubmitButton();
        
        // Clear any previous info messages
        const existingInfo = document.querySelector('.mb-4.bg-blue-50');
        if (existingInfo) {
            existingInfo.remove();
        }
        
        const existingNoSlots = timeSlotsContainer.nextElementSibling;
        if (existingNoSlots && existingNoSlots.classList.contains('mt-4')) {
            existingNoSlots.remove();
        }
        
        // Make AJAX request
        fetch('{{ route("booking.check.slots") }}', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') || '{{ csrf_token() }}'
            },
            body: JSON.stringify({
                kd_lapangan: kd_lapangan,
                tgl_main: tgl_main
            })
        })
        .then(response => response.json())
        .then(data => {
            // Hide loading
            slotsLoading.classList.add('hidden');
            
            // Get data from response
            const bookedSlots = data.booked_slots || [];
            const pastSlots = data.past_slots || [];
            const currentTime = data.current_time || '';
            const isToday = data.is_today || false;
            
            console.log('Debug - Current time:', data.debug_current_time);
            console.log('Debug - Past slots:', pastSlots);
            console.log('Debug - Booked slots:', bookedSlots);
            
            // Sort all slots by time
            const sortedSlots = [...allSlots].sort((a, b) => {
                return timeToMinutes(a.jam_mulai) - timeToMinutes(b.jam_mulai);
            });
            
            // Categorize slots
            const availableSlots = [];
            const unavailableSlots = [];
            
            sortedSlots.forEach(slot => {
                const isBooked = bookedSlots.includes(slot.kd_slot);
                const isPast = pastSlots.includes(slot.kd_slot);
                
                if (isBooked || isPast) {
                    unavailableSlots.push({
                        ...slot,
                        reason: isBooked ? 'booked' : 'past'
                    });
                } else {
                    availableSlots.push(slot);
                }
            });
            
            // Render slots in order: available first, then unavailable
            const slotsToRender = [...availableSlots, ...unavailableSlots];
            
            if (slotsToRender.length > 0) {
                timeSlotsContainer.innerHTML = slotsToRender.map(slot => {
                    const isAvailable = availableSlots.some(s => s.kd_slot === slot.kd_slot);
                    const reason = slot.reason || '';
                    
                    if (isAvailable) {
                        // Available slot
                        return `
                            <label class="slot-option cursor-pointer">
                                <input type="radio" name="kd_slot" value="${slot.kd_slot}" 
                                       class="hidden slot-radio" required>
                                <div class="slot-card border-2 border-gray-200 rounded-lg p-3 text-center hover:border-primary-300 transition-colors">
                                    <div class="text-sm font-medium text-gray-700">${slot.display_waktu}</div>
                                    <div class="text-xs text-green-600 mt-1">Tersedia</div>
                                </div>
                            </label>
                        `;
                    } else {
                        // Unavailable slot
                        const bgColor = reason === 'past' ? 'bg-gray-100' : 'bg-red-50';
                        const textColor = reason === 'past' ? 'text-gray-400' : 'text-red-400';
                        const borderColor = reason === 'past' ? 'border-gray-200' : 'border-red-200';
                        const reasonText = reason === 'past' ? 'Sudah terlewat' : 'Sudah dibooking';
                        
                        return `
                            <div class="slot-unavailable cursor-not-allowed">
                                <div class="slot-card border-2 ${borderColor} ${bgColor} rounded-lg p-3 text-center opacity-60">
                                    <div class="text-sm font-medium ${textColor}">${slot.display_waktu}</div>
                                    <div class="text-xs ${textColor} mt-1">${reasonText}</div>
                                </div>
                            </div>
                        `;
                    }
                }).join('');
                
                // Add info message if today
                if (isToday && pastSlots.length > 0) {
                    timeSlotsContainer.insertAdjacentHTML('beforebegin', `
                        <div class="mb-4 p-3 bg-blue-50 border border-blue-200 rounded-lg">
                            <div class="flex items-center">
                                <span class="text-blue-600 mr-2">ℹ️</span>
                                <div class="text-sm text-blue-800">
                                    <strong>Info:</strong> Saat ini pukul ${currentTime}. Slot yang sudah terlewat tidak dapat dipilih.
                                </div>
                            </div>
                        </div>
                    `);
                }
                
                // Add event listeners to available slots only
                addSlotEventListeners();
                
                // Check if no available slots
                if (availableSlots.length === 0) {
                    timeSlotsContainer.insertAdjacentHTML('afterend', `
                        <div class="mt-4 text-center py-4 text-gray-500">
                            <span class="text-3xl">⏰</span>
                            <p class="mt-2 font-medium">Tidak ada slot yang tersedia</p>
                            <p class="text-sm">
                                ${isToday ? 'Semua slot sudah terisi atau sudah terlewat waktu.' : 'Semua slot sudah terisi untuk tanggal ini.'}
                            </p>
                            <p class="text-sm mt-1">Silakan pilih tanggal lain.</p>
                        </div>
                    `);
                }
            } else {
                timeSlotsContainer.innerHTML = `
                    <div class="col-span-full text-center py-8 text-gray-500">
                        <span class="text-3xl">⏰</span>
                        <p class="mt-2">Tidak ada slot waktu tersedia</p>
                        <p class="text-sm">Silakan pilih tanggal lain</p>
                    </div>
                `;
            }
        })
        .catch(error => {
            console.error('Error:', error);
            slotsLoading.classList.add('hidden');
            timeSlotsContainer.innerHTML = `
                <div class="col-span-full text-center py-8 text-red-500">
                    <span class="text-3xl">❌</span>
                    <p class="mt-2">Terjadi kesalahan saat memuat slot</p>
                    <p class="text-sm">Silakan refresh halaman</p>
                </div>
            `;
        });
    }
    
    // Function to add event listeners to slot radio buttons
    function addSlotEventListeners() {
        const slotRadios = document.querySelectorAll('.slot-radio');
        
        slotRadios.forEach((radio) => {
            radio.addEventListener('change', function() {
                // Reset all available cards
                document.querySelectorAll('.slot-option .slot-card').forEach(card => {
                    card.classList.remove('border-primary-500', 'bg-primary-50');
                    card.classList.add('border-gray-200');
                });
                
                // Highlight selected card
                if (this.checked) {
                    const parentCard = this.closest('.slot-option').querySelector('.slot-card');
                    parentCard.classList.remove('border-gray-200');
                    parentCard.classList.add('border-primary-500', 'bg-primary-50');
                    selectedSlot = this.value;
                } else {
                    selectedSlot = null;
                }
                
                updateSubmitButton();
            });
        });
    }
    
    // Event listener for date change
    tglMainInput.addEventListener('change', function() {
        const selectedDate = this.value;
        
        if (selectedDate) {
            loadAvailableSlots(selectedDate);
        } else {
            timeSlotsContainer.innerHTML = '';
            noDateSelected.classList.remove('hidden');
            selectedSlot = null;
            updateSubmitButton();
        }
    });
    
    // Initial state
    updateSubmitButton();
});
</script>
@endpush
@endsection