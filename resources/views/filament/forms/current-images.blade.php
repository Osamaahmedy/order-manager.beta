@php
    $imageUrls = collect($images)
        ->filter(fn($img) => $img && Storage::disk('public')->exists($img))
        ->map(fn($img) => Storage::disk('public')->url($img))
        ->values()
        ->toArray();
@endphp

@if (count($imageUrls))
<div class="flex flex-wrap justify-center gap-4">
    @foreach ($imageUrls as $index => $image)
        <div class="w-32 h-32 overflow-hidden rounded-md cursor-pointer transition-transform duration-300 hover:scale-105">
            <img
                src="{{ $image }}"
                data-index="{{ $index }}"
                onclick="openLightbox({{ $index }})"
                class="w-full h-full object-cover"
            />
        </div>
    @endforeach
</div>


    {{-- Lightbox --}}
    {{-- Lightbox --}}
<div
id="lightbox"
class="fixed inset-0 bg-black/80 flex flex-col items-center justify-center z-50 hidden"
onclick="closeLightbox(event)"
>
<div class="relative flex items-center justify-center bg-black/80 rounded-lg p-4 max-w-[90vw] max-h-[80vh]">


    {{-- Image --}}
    <img style="width:40rem; height:40rem; "
            id="lightbox-image"
            class="object-contain rounded shadow-2xl transition-transform duration-300"
            src=""
            alt="Preview"
        />



</div>

{{-- Counter --}}
<div id="counter" class="mt-3 text-white text-base bg-black/80 px-4 py-2 rounded z-50 select-none">
    1 / {{ count($imageUrls) }}
</div>
</div>

    <script>
        const images = @json($imageUrls);
        let currentIndex = 0;
        let zoomLevel = 1;

        const lightbox = document.getElementById('lightbox');
        const lightboxImage = document.getElementById('lightbox-image');
        const counter = document.getElementById('counter');

        function openLightbox(index) {
            currentIndex = index;
            updateLightbox();
            lightbox.classList.remove('hidden');
        }

        function closeLightbox(event) {
            if (event.target === lightbox) {
                lightbox.classList.add('hidden');
            }
        }

        function updateLightbox() {
            lightboxImage.src = images[currentIndex];
            counter.innerText = `${currentIndex + 1} / ${images.length}`;
            zoomLevel = 1;
            lightboxImage.style.transform = `scale(1)`;
        }

        function nextImage(e) {
            e.stopPropagation();
            currentIndex = (currentIndex + 1) % images.length;
            updateLightbox();
        }

        function prevImage(e) {
            e.stopPropagation();
            currentIndex = (currentIndex - 1 + images.length) % images.length;
            updateLightbox();
        }

        document.addEventListener('keydown', function (e) {
            if (lightbox.classList.contains('hidden')) return;

            if (e.key === 'ArrowRight') nextImage(e);
            else if (e.key === 'ArrowLeft') prevImage(e);
            else if (e.key === 'Escape') lightbox.classList.add('hidden');
        });

        lightboxImage.addEventListener('wheel', (event) => {
            event.preventDefault();
            const delta = Math.sign(event.deltaY);

            if (delta < 0 && zoomLevel < 3) zoomLevel += 0.1;
            else if (delta > 0 && zoomLevel > 1) zoomLevel -= 0.1;

            lightboxImage.style.transform = `scale(${zoomLevel.toFixed(2)})`;
        });
    </script>
@endif
