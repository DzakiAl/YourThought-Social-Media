<x-app-layout>
    <div class="comment-container">
        <div class="comment-form">
            <h3 class="title-comment-form">Add a Comment</h3>
            <form action="{{ route('comment.store', $post) }}" method="POST">
                @csrf
                <input type="text" name="comment" class="comment-input" required>
                <button type="submit" class="link">Submit</button>
            </form>
        </div>

        <h2 class="comment-title">Comments</h2>
        @foreach ($post->comments as $comment)
            <div class="comment">
                <p class="comment-user">{{ $comment->user->name }} at 
                    {{ $comment->created_at->format('H:i d-m-Y') }}</p>
                <p class="comment-content">{{ $comment->comment }}</p>
                @if ($comment->user_id === auth()->id())
                    <form action="{{ route('comment.destroy', $comment) }}" method="POST"
                        onsubmit="return confirm('Are you sure you want to delete this comment?');">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="link">Delete</button>
                    </form>
                @endif
            </div>
        @endforeach
    </div>
</x-app-layout>