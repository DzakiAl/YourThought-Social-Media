<x-app-layout>
    <form action="{{ route('search') }}" method="GET" class="form">
        <input type="text" name="query" placeholder="Search for users" class="input">
        <button type="submit" class="button-a">Search</button>
    </form>

    @if (isset($query))
        @if ($users->isNotEmpty())
            <ul>
                @foreach ($users as $user)
                    <div class="user-showed">
                        <li><a href="{{ route('viewUser.index', $user) }}" class="user-link">{{ $user->name }}</a></li>
                    </div>
                @endforeach
            </ul>
        @else
            <div class="user-showed">
                <p>No users found for '{{ $query }}'.</p>
            </div>
        @endif
    @endif
</x-app-layout>
