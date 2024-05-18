<x-app-layout>
    <div class="body">
        <h1 class="username">{{ Auth::user()->name }}</h1>
        <a href="{{ route('profile.edit') }}" class="link">Edit Profile</a>
        <a href="{{ route('post.create') }}" class="link">Create your thought</a>
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
                        <form action="{{ route('post.destroy', $post) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this post?');">
                            @method('DELETE')
                            @csrf
                            <button class="link">Delete</button>
                        </form>
                        <a href="{{ route('comment.index', $post) }}" class="link-comment">Comment</a>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</x-app-layout>