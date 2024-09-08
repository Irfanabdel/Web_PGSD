<x-app-layout :title="$evaluation->title">
<div class="p-6 sm:ml-64 pt-8">
    <div class="p-4 bg-white border border-gray-200 rounded-lg shadow-md space-y-8">
        <h3 class="text-lg font-semibold">{{ $evaluation->title }}</h3>
        <p class="text-sm text-red-500">Mulai : {{ $evaluation->start_datetime }}</p>
        <p class="text-sm text-red-500">Berakhir : {{ $evaluation->end_datetime }}</p>

        <form action="{{ route('learnings.store.work', $evaluation->id) }}" method="POST" class="space-y-6">
            @csrf

            <!-- Deskripsi Evaluasi -->
            <div>
                <label for="description" class="py-2 block text-sm font-medium">Deskripsi Evaluasi</label>
                <div class="evaluation-description mt-1 text-sm text-gray-600">{!! $evaluation->description !!}</div>
            </div>

            <!-- Input Kerjakan Evaluasi -->
            <div>
                <label for="answers" class="py-2 block text-sm font-medium">Kerjakan Evaluasi</label>
                <textarea id="answers" name="answers" class="resize-y mt-1 block w-full border border-gray-300 rounded-md shadow-sm focus:ring-yellow-400 focus:border-yellow-400 sm:text-sm" rows="5">{{ old('answers') }}</textarea>
                @error('answers')
                <span class="text-red-500 text-sm">{{ $message }}</span>
                @enderror
            </div>

            <!-- Tombol Kirim -->
            <div>
                <button type="submit" class="inline-flex items-center px-4 py-2 bg-blue-600 text-white font-medium rounded-lg hover:bg-blue-700 focus:ring-2 focus:ring-blue-300">
                    Kirim
                </button>
            </div>
        </form>
    </div>
</div>



    <!-- Include styles and TinyMCE scripts -->
    <link href="{{ asset('css/styles.css') }}" rel="stylesheet">
    <script src="https://cdn.tiny.cloud/1/alb42zv55n2f3tyry7ir4vpjl69aaxbwn30db6omng9lmsj5/tinymce/6/tinymce.min.js" referrerpolicy="origin"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            tinymce.init({
                selector: '#answers',
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
