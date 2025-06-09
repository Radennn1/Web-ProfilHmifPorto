@extends('layouts.dapur')

@section('content')
<div class="container mx-auto px-4 py-8">
    <h2 class="text-2xl font-semibold mb-6">Edit Album: {{ $album->nama_album }}</h2>

    @if (session('error'))
        <div class="bg-red-100 text-red-700 px-4 py-3 rounded mb-4">
            {{ session('error') }}
        </div>
    @endif

    <form action="{{ route('galeri.update', $album->id) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        <div class="mb-4">
            <label for="nama_album" class="block text-sm font-medium text-gray-700">Nama Album</label>
            <input type="text" id="nama_album" name="nama_album" value="{{ old('nama_album', $album->nama_album) }}" required
                class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
        </div>

        <div class="mb-4">
            <label for="thumbnail" class="block text-sm font-medium text-gray-700">Thumbnail Album (opsional)</label>
            <input type="file" id="thumbnail" name="thumbnail"
                class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
            @if ($album->thumbnail)
                <p class="text-sm text-gray-500 mt-2">Thumbnail saat ini:</p>
                <img src="{{ asset('storage/' . $album->thumbnail) }}" alt="Thumbnail Album" class="w-32 h-32 object-cover mt-1 rounded-md shadow">
            @endif
        </div>

        <div class="flex items-center gap-4">
            <button type="submit" class="bg-blue-500 text-white px-6 py-2 rounded-md hover:bg-blue-600">Simpan Perubahan</button>
            <a href="{{ route('dapurgaleri') }}" class="bg-gray-500 text-white px-6 py-2 rounded-md hover:bg-gray-600">Kembali</a>
        </div>
    </form>
    <h4 class="text-xl font-semibold mt-10 mb-4">Upload Foto ke Album</h4>

    <form action="{{ route('galeri.upload', $album->id) }}" method="POST" enctype="multipart/form-data" class="mb-8">
        @csrf

        <div class="mb-4">
            <label for="foto" class="block text-sm font-medium text-gray-700">Pilih Foto (maks. 20 foto, masing-masing maks. 35MB)</label>
            <input type="file" id="foto" name="foto[]" multiple accept="image/*"
                class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
            @error('foto')
                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
            @enderror
            @error('foto.*')
                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
            @enderror
        </div>

        <div class="mb-4">
            <label for="custom_name" class="block text-sm font-medium text-gray-700">Nama File Khusus (opsional)</label>
            <input type="text" id="custom_name" name="custom_name" placeholder="contoh: kegiatan_hmif"
                value="{{ old('custom_name') }}"
                class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
            <p class="text-gray-500 text-sm mt-1">Jika diisi, nama file akan menjadi: <i>nama_khusus_1.jpg</i>, <i>nama_khusus_2.jpg</i>, dst.</p>
        </div>

        <button type="submit" class="bg-green-600 text-white px-6 py-2 rounded-md hover:bg-green-700">
            Upload Foto
        </button>
    </form>
    <h5 class="text-xl font-semibold mb-4">Daftar Foto</h5>
    <div class="overflow-y-auto max-h-[350px] p-2 border rounded">
        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4">
            @forelse ($files as $file)
                <div class="bg-white shadow-sm rounded-lg overflow-hidden">
                    <div class="relative">
                        <iframe 
                            src="{{ $file['previewUrl'] }}" 
                            title="{{ $file['name'] }}"
                            allow="autoplay" 
                            class="w-full h-48 border-none"
                        ></iframe>
                    </div>
                    <div class="p-3">
                        <p class="text-sm text-gray-700 truncate">{{ $file['name'] }}</p>
                        <div class="mt-2 flex gap-2">
                            <a href="{{ $file['webViewLink'] }}" target="_blank" class="bg-blue-500 text-white text-xs px-3 py-1 rounded-md hover:bg-blue-600">Lihat</a>
                            <form action="{{ route('galeri.hapus', ['id' => $album->id, 'fileId' => $file['id']]) }}" method="POST" class="d-inline" onsubmit="return confirm('Yakin ingin menghapus foto ini?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="bg-red-500 text-white text-xs px-3 py-1 rounded-md hover:bg-red-600">Hapus</button>
                            </form>
                        </div>
                    </div>
                </div>
            @empty
                <p class="text-center text-gray-500">Tidak ada foto di album ini.</p>
            @endforelse
        </div>
    </div>      
</div>
@endsection
