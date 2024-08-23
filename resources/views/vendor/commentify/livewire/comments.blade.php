<div>

    <section class="bg-white py-8 lg:py-16">
        <div class="max-w-2xl mx-auto px-4">
            <!-- Judul Diskusi dan Tombol Toggle -->
            <div class="flex justify-between items-center mb-6">
                <h2 class="text-lg lg:text-2xl font-bold text-red-500">
                    Diskusi ({{$comments->count()}})
                </h2>
                <button id="toggleButton" class="px-4 py-2 text-yellow-500 underline">
                    @if($comments->count() > 0)
                        Sembunyikan
                    @else
                        Tampilkan
                    @endif
                </button>
            </div>

            <!-- Container Diskusi -->
            <div id="commentsContainer" class="{{ $comments->count() > 0 ? '' : 'hidden' }}">
                @auth
                @include('commentify::livewire.partials.comment-form',[
                'method' => 'postComment',
                'state' => 'newCommentState',
                'inputId' => 'comment',
                'inputLabel' => 'Your comment',
                'button' => 'Post Komentar'
                ])
                @else
                <a class="mt-2 text-sm" href="/login">Log in to comment!</a>
                @endauth

                @if($comments->count())
                @foreach($comments as $comment)
                <livewire:comment :$comment :key="$comment->id" />
                @endforeach
                {{$comments->links()}}
                @else
                <p>No comments yet!</p>
                @endif
            </div>
        </div>
    </section>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const toggleButton = document.getElementById('toggleButton');
        const commentsContainer = document.getElementById('commentsContainer');

        // Mengatur tampilan awal
        let isVisible = commentsContainer.classList.contains('hidden') ? false : true;
        toggleButton.addEventListener('click', function() {
            isVisible = !isVisible;
            if (isVisible) {
                commentsContainer.classList.remove('hidden');
                toggleButton.textContent = 'Sembunyikan Diskusi';
            } else {
                commentsContainer.classList.add('hidden');
                toggleButton.textContent = 'Tampilkan Diskusi';
            }
        });
    });
</script>
