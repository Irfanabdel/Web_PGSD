<x-app-layout title="Evaluasi">
    <div class="p-6 sm:ml-64 pt-8">
        <div class="bg-white shadow-md rounded-lg p-6 mb-6">
            <!-- Info Step -->
            <div class="flex justify-center items-center">
                <p class="text-2xl font-bold text-gray-900">
                    <span class="text-red-500">Step 3</span>
                </p>
            </div>
            <h1 class="text-2xl flex justify-center font-extrabold tracking-tight leading-tight text-gray-900 md:text-4xl lg:text-4xl mb-8">Evaluasi</h1>
            <!-- Formulir Tambah Evaluasi -->
            <form action="{{ route('learnings.store.step3', ['learning' => $learning->id, 'module' => $module->id]) }}" method="POST">
                @csrf
                <div class="mb-6">
                    <label for="title" class="block text-sm font-medium text-gray-700 mb-2">Judul Evaluasi</label>
                    <input type="text" name="title" id="title" class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm focus:ring-yellow-400 focus:border-yellow-400 sm:text-sm" required>
                </div>

                <div class="mb-6">
                    <label for="description" class="block text-sm font-medium text-gray-700 mb-2">Deskripsi Evaluasi</label>
                    <textarea name="description" id="description" rows="4" class="resize-y mt-1 block w-full border border-gray-300 rounded-md shadow-sm focus:ring-yellow-400 focus:border-yellow-400 sm:text-sm"></textarea>
                    <p class="mt-2 text-sm text-gray-500">Anda dapat mengunggah beberapa file pembelajaran untuk siswa. Jenis file yang diterima: PDF, DOC, DOCX, PPT, PPTX</p>
                </div>

                <div class="mb-6">
                    <label for="start_datetime" class="block text-sm font-medium text-gray-700 mb-2">Tanggal Mulai</label>
                    <input type="datetime-local" name="start_datetime" id="start_datetime" class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm focus:ring-yellow-400 focus:border-yellow-400 sm:text-sm">
                </div>

                <div class="mb-6">
                    <label for="end_datetime" class="block text-sm font-medium text-gray-700 mb-2">Tanggal Berakhir</label>
                    <input type="datetime-local" name="end_datetime" id="end_datetime" class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm focus:ring-yellow-400 focus:border-yellow-400 sm:text-sm">
                </div>

                <div class="flex justify-end">
                    <button type="submit" class="inline-flex items-center px-4 py-2 bg-blue-600 text-white rounded-md shadow-sm hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                        Simpan
                    </button>
                </div>
            </form>
        </div>
    </div>

    <script src="https://cdn.tiny.cloud/1/alb42zv55n2f3tyry7ir4vpjl69aaxbwn30db6omng9lmsj5/tinymce/6/tinymce.min.js" referrerpolicy="origin"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Inisialisasi TinyMCE untuk textarea 'description'
            tinymce.init({
                selector: '#description',
                plugins: 'lists link image media',
                toolbar: 'customfileupload | undo redo | bold italic underline | bullist numlist | link image media',
                menubar: false,
                branding: false,
                height: 300,
                content_style: "body { font-family:Arial,Helvetica,sans-serif; font-size:14px }",
                setup: function(editor) {
                    editor.ui.registry.addButton('customfileupload', {
                        text: 'Upload File',
                        onAction: function() {
                            var input = document.createElement('input');
                            input.setAttribute('type', 'file');
                            input.setAttribute('accept', '.pdf,.doc,.docx,.ppt,.pptx'); // Filter file types

                            input.onchange = function() {
                                var file = this.files[0];
                                var formData = new FormData();
                                formData.append('file', file);
                                formData.append('_token', document.querySelector('meta[name="csrf-token"]').getAttribute('content')); // Include CSRF token

                                fetch('{{ route('learnings.evaluation.files') }}', {
                                    method: 'POST',
                                    body: formData
                                })
                                .then(response => response.json())
                                .then(data => {
                                    if (data.success) {
                                        editor.insertContent(`<a href="${data.url}" target="_blank">${file.name}</a>`);
                                    } else {
                                        alert('Error uploading file');
                                    }
                                })
                                .catch(error => {
                                    console.error('Error:', error);
                                    alert('Error uploading file');
                                });
                            };

                            input.click();
                        }
                    });

                    editor.on('change', function() {
                        tinymce.triggerSave(); // Sinkronkan konten TinyMCE dengan textarea
                    });
                }
            });
        });
    </script>
</x-app-layout>
