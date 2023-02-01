<x-app-layout>
    <div class="max-w-2xl mx-auto p-4 sm:p-6 lg:p-8">
        <div class="text-center" style="font-size: 60px; color:darkslategrey">
            <h1><b><i> Edit Chirp </i></b></h1>
        </div>
        <form action="{{ route('chirps.update',$chirp)}}" method="post">
            @csrf
            @method('patch')
            <textarea name="message" 
            class="block w-full border-gray-300 focus:borderindigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm" 
            >{{ old('message', $chirp->message)}}</textarea>
            <x-input-error :messages="$errors->get('message')" class="mt-2" />
            <br>
            <img src="{{config('filesystems.disks.chirper.url')}}/{{$chirp->user->name}}/{{$chirp->attachments()->first()?->server_name}}" alt="img">
     
            <div class="mt-4 space-x-2">
                <x-primary-button class="mt-4">{{__('Save')}}</x-primary-button>
                <a href="{{route('chirps.index')}}">{{__('Cancel')}}</a>
            </div>  
        </form>
    </div>    
</x-app-layout>        