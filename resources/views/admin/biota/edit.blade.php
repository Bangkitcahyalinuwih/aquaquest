<x-app-layout>
    <h1>Edit Biota</h1>

    <form action="{{ route('admin.biota.update', $biota) }}" method="POST">
        @csrf
        @method('PUT')

        <p>
            <label>Nama</label><br>
            <input type="text" name="nama" value="{{ old('nama', $biota->nama) }}">
            @error('nama') <span>{{ $message }}</span> @enderror
        </p>

        <p>
            <label>Nama Latin</label><br>
            <input type="text" name="nama_latin" value="{{ old('nama_latin', $biota->nama_latin) }}">
            @error('nama_latin') <span>{{ $message }}</span> @enderror
        </p>

        <p>
            <label>Kategori</label><br>
            <input type="text" name="kategori" value="{{ old('kategori', $biota->kategori) }}">
            @error('kategori') <span>{{ $message }}</span> @enderror
        </p>

        <p>
            <label>Deskripsi</label><br>
            <textarea name="deskripsi" rows="5">{{ old('deskripsi', $biota->deskripsi) }}</textarea>
            @error('deskripsi') <span>{{ $message }}</span> @enderror
        </p>

        <p>
            <label>Habitat</label><br>
            <input type="text" name="habitat" value="{{ old('habitat', $biota->habitat) }}">
            @error('habitat') <span>{{ $message }}</span> @enderror
        </p>

        <p>
            <label>Status Konservasi</label><br>
            <input type="text" name="status_konservasi" value="{{ old('status_konservasi', $biota->status_konservasi) }}">
            @error('status_konservasi') <span>{{ $message }}</span> @enderror
        </p>

        <p>
            <label>Latitude</label><br>
            <input type="text" name="latitude" value="{{ old('latitude', $biota->latitude) }}">
            @error('latitude') <span>{{ $message }}</span> @enderror
        </p>

        <p>
            <label>Longitude</label><br>
            <input type="text" name="longitude" value="{{ old('longitude', $biota->longitude) }}">
            @error('longitude') <span>{{ $message }}</span> @enderror
        </p>

        <button type="submit">Update</button>
        <a href="{{ route('admin.biota.index') }}">Batal</a>
    </form>
</x-app-layout>
