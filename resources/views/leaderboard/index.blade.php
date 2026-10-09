<x-app-layout>
    <h1>Peringkat</h1>
    <ol>
        @foreach ($pemain as $urutan => $item)
            <li>{{ $urutan + 1 }}. {{ $item->name }} — {{ $item->total_xp }} XP (Level {{ $item->level }})</li>
        @endforeach
    </ol>
</x-app-layout>