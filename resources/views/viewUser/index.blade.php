<x-app-layout>
    <div class="body">
        <h1 class="username">{{ $user->name }}</h1>
        <div class="post">
            <h1 class="title">Thought</h1>
            <div class="the-border"></div>
            @foreach ($posts as $post)
                <div class="thought">
                    <div class="post-info">
                        <p class="post-user">{{ $post->user->name }}</p>
                        <p class="date">{{ $post->created_at }}</p>
                    </div>
                    @if ($post->image)
                        <img src="{{ asset('storage/' . $post->image) }}" class="image">
                    @endif
                    @if ($post->video)
                        <video controls>
                            <source src="{{ asset('storage/' . $post->video) }}" type="video/mp4">
                            Your browser does not support the video tag.
                        </video>
                    @endif
                    <p class="caption">{{ $post->caption }}</p>
                    <div class="option">
                        <a href="{{ route('comment.index', $post) }}" class="link-comment">Comment</a>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</x-app-layout>