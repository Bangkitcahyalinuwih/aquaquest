<x-app-layout>
    <h1>Kelola Biota</h1>
    @if (session('status'))
        <p>{{ session('status') }}</p>
    @endif
    <a href="{{ route('admin.biota.create') }}">+ Tambah Biota</a>
    <table border="1" cellpadding="6">
        @foreach ($biota as $item)
            <tr>
                <td>{{ $item->nama }}</td>
                <td>{{ $item->kategori }}</td>
                <td>
                    <a href="{{ route('admin.biota.edit', $item) }}">Edit</a>
                    <form action="{{ route('admin.biota.destroy', $item) }}" method="POST" style="display:inline">
                        @csrf @method('DELETE')
                        <button type="submit" onclick="return confirm('Yakin hapus?')">Hapus</button>
                    </form>
                </td>
            </tr>
        @endforeach
    </table>
    {{ $biota->links() }}
</x-app-layout>