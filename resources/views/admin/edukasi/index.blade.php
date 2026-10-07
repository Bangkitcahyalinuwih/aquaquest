<x-app-layout>
    <h1>Kelola Konten Edukasi</h1>
    @if (session('status'))
        <p>{{ session('status') }}</p>
    @endif
    <a href="{{ route('admin.edukasi.create') }}">+ Tambah Konten</a>
    <table border="1" cellpadding="6">
        @foreach ($konten as $item)
            <tr>
                <td>{{ $item->judul }}</td>
                <td>
                    <a href="{{ route('admin.edukasi.edit', $item) }}">Edit</a>
                    <form action="{{ route('admin.edukasi.destroy', $item) }}" method="POST" style="display:inline">
                        @csrf @method('DELETE')
                        <button type="submit" onclick="return confirm('Yakin hapus?')">Hapus</button>
                    </form>
                </td>
            </tr>
        @endforeach
    </table>
    {{ $konten->links() }}
</x-app-layout>