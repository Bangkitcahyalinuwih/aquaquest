@props(['action'])

{{-- Hapus onsubmit bawaan, ganti dengan form biasa --}}
<form method="POST" action="{{ $action }}" class="inline-block">
    @csrf
    @method('DELETE')

    {{-- Ubah type menjadi button, dan panggil fungsi JS onclick --}}
    <button type="button" onclick="konfirmasiHapus(this)" class="text-red-500 hover:text-red-700 transition"
        title="Hapus">
        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"
            class="w-5 h-5">
            <path stroke-linecap="round" stroke-linejoin="round"
                d="M14.74 9l-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 01-2.244 2.077H8.084a2.25 2.25 0 01-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 00-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 013.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 00-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 00-7.5 0" />
        </svg>
    </button>
</form>

{{-- @once memastikan script SweetAlert hanya dimuat 1 kali walau ada 100 tombol hapus di tabel --}}
@once
    @push('scripts')
        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
        <script>
            function konfirmasiHapus(tombol) {
                Swal.fire({
                    title: 'Yakin ingin menghapus?',
                    text: "Data yang dihapus tidak dapat dikembalikan!",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#0891b2', // Sesuai dengan warna bg-cyan-600 milikmu
                    cancelButtonColor: '#ef4444', // Sesuai dengan warna bg-red-500
                    confirmButtonText: 'Ya, Hapus!',
                    cancelButtonText: 'Batal',
                    background: '#ffffff',
                    color: '#0f172a', // text-slate-900
                }).then((result) => {
                    // Jika user klik "Ya, Hapus!"
                    if (result.isConfirmed) {
                        // Cari form terdekat dari tombol yang diklik, lalu submit
                        tombol.closest('form').submit();
                    }
                });
            }
        </script>
    @endpush
@endonce
