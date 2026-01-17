<div class="flex gap-2">
    @foreach(json_decode($images, true) ?? [] as $image)
        <img src="{{ Storage::disk('public')->url($image) }}" class="h-16 w-16 rounded object-cover" />
    @endforeach
</div>
