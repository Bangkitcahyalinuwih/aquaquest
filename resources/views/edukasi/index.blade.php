<x-app-layout>
    <h1>Daftar Edukasi</h1>
    <ul>
        @foreach ($konten as $item)
            <li><a href="{{ route('edukasi.show', $item) }}">{{ $item->judul }}</a></li>
        @endforeach
    </ul>
    {{ $konten->links() }}
</x-app-layout>
