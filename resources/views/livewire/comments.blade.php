<div>
    <!-- Formulir untuk menambahkan komentar -->
    <div class="mb-6 p-4 bg-white border border-gray-200 rounded-lg shadow-md">
        <h2 class="text-lg font-semibold mb-4">Tambah Komentar</h2>
        <form wire:submit.prevent="addComment" class="space-y-4">
            <div>
                <label for="commentBody" class="block text-sm font-medium text-gray-700">Komentar:</label>
                <textarea id="commentBody" wire:model="newComment" rows="4" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm p-2 focus:ring-indigo-500 focus:border-indigo-500"></textarea>
                @error('newComment') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
            </div>
            <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700">Kirim</button>
        </form>
    </div>

    <!-- Daftar komentar -->
    <div>
        @foreach ($comments as $comment)
            <div class="mb-4 p-4 bg-white border border-gray-200 rounded-lg shadow-md">
                <p class="text-gray-700">{{ $comment->body }}</p>
                <p class="text-sm text-gray-500 mt-2">Ditambahkan pada: {{ $comment->created_at->format('d M Y, H:i') }}</p>
            </div>
        @endforeach

        <!-- Pesan jika tidak ada komentar -->
        @if($comments->isEmpty())
            <p class="text-gray-500">Belum ada komentar.</p>
        @endif
    </div>
</div>
