<x-app-layout title="welcome">
    <div class="p-4 sm:ml-64">
        
        
        @foreach ($komen as $komen)
            <div>
               
                <h1 class="mb-4 text-xl font-extrabold tracking-tight leading-none text-black md:text-3xl lg:text-3xl">{{ $komen->title }}</h1>
            </div>
        @endforeach
        <livewire:comments :model="$komen"/>
    
    </div>
</x-app-layout>
