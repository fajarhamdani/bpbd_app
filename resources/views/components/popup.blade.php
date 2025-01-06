@php
$role_id = auth()->user()->role_id ?? null;
$isVerified = auth()->user()->is_verified ?? false;
@endphp

<div id="verificationToast" class="hidden fixed bottom-5 right-5 bg-gray-800 text-white shadow-lg rounded-md z-50 p-4 flex flex-col space-y-2">
    <div class="flex items-start space-x-4">
        <div class="flex-shrink-0">
            <!-- Icon -->
            <svg class="h-6 w-6 text-blue-400" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round" d="M13 16h-1v-4h-1m1-4h.01M12 19.5a7.5 7.5 0 100-15 7.5 7.5 0 000 15z" />
            </svg>
        </div>
        <div class="flex-1">
            <p class="text-sm">
                Anda perlu melakukan verifikasi untuk menjadi staff.
                <a href="{{ route('pegawai.validate-nip') }}" class="font-bold text-yellow-400 hover:underline">Klik di sini untuk verifikasi.</a>
            </p>
        </div>
        <button id="closeToast" class="flex-shrink-0 text-gray-400 hover:text-blue-400 text-lg font-bold">&times;</button>
    </div>
    <!-- Progress Bar -->
    <div class="h-1 bg-gray-600 rounded-full relative overflow-hidden">
        <div id="progressBar" class="absolute top-0 left-0 h-full bg-blue-500" style="width: 100%;"></div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const role_id = {{ json_encode($role_id) }};
        const isVerified = {{ json_encode($isVerified) }};

        // Tampilkan toast notification jika role_id adalah 3 dan belum terverifikasi
        if (role_id === 3 && !isVerified) {
            const toast = document.getElementById('verificationToast');
            const progressBar = document.getElementById('progressBar');

            toast.classList.remove('hidden');

            // Durasi tampil toast
            const duration = 10000; // 30 detik

            // Mengurangi lebar progress bar secara bertahap
            let width = 100; // Dalam persen
            const interval = 10; // Perubahan setiap 10ms
            const decrement = (100 / (duration / interval));

            const timer = setInterval(() => {
                width -= decrement;
                if (width <= 0) {
                    width = 0;
                    clearInterval(timer);
                }
                progressBar.style.width = `${width}%`;
            }, interval);

            // Sembunyikan toast setelah durasi selesai
            setTimeout(() => {
                toast.classList.add('hidden');
            }, duration);
        }

        // Tombol untuk menutup toast notification
        document.getElementById('closeToast').addEventListener('click', function() {
            document.getElementById('verificationToast').classList.add('hidden');
        });
    });
</script>