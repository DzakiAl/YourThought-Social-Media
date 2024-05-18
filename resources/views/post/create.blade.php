<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Create your thought') }}
        </h2>
    </x-slot>
    <form action="{{ route('post.store') }}" class="form" enctype="multipart/form-data" method="POST">
        @method('POST')
        @csrf
        <input type="file" name="image" class="input"><br>
        <input type="text" name="caption" class="input" placeholder="What's your thought?">
        <div class="option">
            <a href="{{route('profile.index')}}" class="button-b">Cancel</a>
            <button class="button-a">Submit</button>
        </div>
    </form>
</x-app-layout>
