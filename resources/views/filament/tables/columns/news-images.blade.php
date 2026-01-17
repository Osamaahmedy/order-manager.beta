<div class="flex gap-2">
    @foreach(array_slice($getState() ?? [], 0, 2) as $image)
        <img src="{{ Storage::disk('public')->url($image) }}" class="h-10 w-10 rounded-md object-cover shadow" />
    @endforeach
</div>
