<x-util.modal wire:model.live="modalOpen" maxWidth="7xl">
    <div 
        class="p-6"
        x-data="{ currentStep: @entangle('currentStep') }"
    >
        <h2 class="text-lg font-bold text-gray-900 border-b border-gray-100 pb-4 mb-6">
            {{ $packageId ? 'Edit Paket' : 'Tambah Paket Baru' }}
        </h2>

        {{-- Stepper Navigation --}}
        <ol class="flex items-center w-full text-sm font-medium text-center text-gray-500 mb-8">
            <li class="flex md:w-full items-center" :class="{ 'text-primary-600': currentStep >= 1 }">
                <span class="flex items-center after:content-['/'] sm:after:hidden after:mx-2 after:text-gray-200">
                    <span class="p-2 rounded-full" :class="{ 'bg-primary-100': currentStep >= 1 }">
                        <x-phosphor-note-pencil-bold class="w-5 h-5"/>
                    </span>
                    <span class="ml-2">Detail Utama</span>
                </span>
            </li>
            <li class="flex md:w-full items-center" :class="{ 'text-primary-600': currentStep >= 2 }">
                <span class="flex items-center before:content-[''] before:w-full before:h-1 before:border-b before:border-gray-200 before:border-1 before:hidden sm:before:inline-block before:mx-6 xl:before:mx-10" :class="{ 'before:border-primary-200': currentStep >= 2 }">
                    <span class="flex-shrink-0 flex items-center after:content-['/'] sm:after:hidden after:mx-2 after:text-gray-200">
                        <span class="p-2 rounded-full" :class="{ 'bg-primary-100': currentStep >= 2 }">
                            <x-phosphor-list-bullets-bold class="w-5 h-5"/>
                        </span>
                        <span class="ml-2">Itinerary</span>
                    </span>
                </span>
            </li>
            <li class="flex items-center" :class="{ 'text-primary-600': currentStep >= 3 }">
                 <span class="flex items-center before:content-[''] before:w-full before:h-1 before:border-b before:border-gray-200 before:border-1 before:hidden sm:before:inline-block before:mx-6 xl:before:mx-10" :class="{ 'before:border-primary-200': currentStep >= 3 }">
                    <span class="p-2 rounded-full" :class="{ 'bg-primary-100': currentStep >= 3 }">
                        <x-phosphor-images-square-bold class="w-5 h-5"/>
                    </span>
                    <span class="ml-2">Galeri</span>
                </span>
            </li>
        </ol>

        <form wire:submit.prevent="save">
            {{-- Step 1: Main Details --}}
            <div x-show="currentStep === 1">
                <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                    <div class="md:col-span-2 space-y-6">
                        <div>
                            <x-util.form.label for="title" value="Nama Paket" />
                            <x-util.form.input wire:model.live.debounce.300ms="title" id="title" type="text" class="mt-1 text-lg font-semibold !p-4" placeholder="e.g. Tips Umroh Saat Musim Panas"/>
                            @error('title') <span class="text-red-500 text-sm mt-1">{{ $message }}</span> @enderror
                        </div>
                        <div>
                            <x-util.form.label for="slug" value="Slug" />
                            <x-util.form.input wire:model="slug" id="slug" type="text" class="mt-1 bg-gray-100" readonly />
                            @error('slug') <span class="text-red-500 text-sm mt-1">{{ $message }}</span> @enderror
                        </div>
                        <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
                             <div>
                                <x-util.form.label for="price_quad" value="Harga (Quad)" />
                                <x-util.form.input wire:model="price_quad" id="price_quad" type="number" step="any" class="mt-1" />
                                @error('price_quad') <span class="text-red-500 text-sm mt-1">{{ $message }}</span> @enderror
                            </div>
                            <div>
                                <x-util.form.label for="price_triple" value="Harga (Triple)" />
                                <x-util.form.input wire:model="price_triple" id="price_triple" type="number" step="any" class="mt-1" />
                            </div>
                            <div>
                                <x-util.form.label for="price_double" value="Harga (Double)" />
                                <x-util.form.input wire:model="price_double" id="price_double" type="number" step="any" class="mt-1" />
                            </div>
                        </div>
                         <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                             <div>
                                <x-util.form.label for="departure_date" value="Tgl. Berangkat" />
                                <x-util.form.input wire:model="departure_date" id="departure_date" type="date" class="mt-1" />
                                @error('departure_date') <span class="text-red-500 text-sm mt-1">{{ $message }}</span> @enderror
                            </div>
                            <div>
                                <x-util.form.label for="duration_days" value="Durasi Hari" />
                                <x-util.form.input wire:model="duration_days" id="duration_days" type="number" class="mt-1" min="1" />
                                @error('duration_days') <span class="text-red-500 text-sm mt-1">{{ $message }}</span> @enderror
                            </div>
                         </div>
                         <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                            <div>
                                <x-util.form.label for="hotel_makkah" value="Hotel Makkah" />
                                <x-util.form.input wire:model="hotel_makkah" id="hotel_makkah" type="text" class="mt-1" />
                            </div>
                            <div>
                                <x-util.form.label for="hotel_madinah" value="Hotel Madinah" />
                                <x-util.form.input wire:model="hotel_madinah" id="hotel_madinah" type="text" class="mt-1" />
                            </div>
                         </div>
                         <div>
                            <x-util.form.label for="airline_name" value="Maskapai" />
                            <x-util.form.input wire:model="airline_name" id="airline_name" type="text" class="mt-1" />
                        </div>
                    </div>
                    <div class="md:col-span-1 space-y-6">
                        <div>
                            <x-util.form.label value="Gambar Unggulan" />
                            <div class="mt-1">
                                @if ($featuredImageUpload)
                                    <img src="{{ $featuredImageUpload->temporaryUrl() }}" class="rounded-lg object-cover w-full h-48 mb-4">
                                @elseif ($package && $package->featured_image)
                                    <img src="{{ Storage::url($package->featured_image) }}" class="rounded-lg object-cover w-full h-48 mb-4">
                                @endif
                                <label for="featured-image-upload" class="cursor-pointer">
                                    <div class="p-4 text-center border-2 border-dashed border-gray-200 rounded-lg hover:bg-gray-50">
                                        <div wire:loading wire:target="featuredImageUpload" class="text-sm text-gray-500">Uploading...</div>
                                        <div wire:loading.remove wire:target="featuredImageUpload" class="text-sm text-gray-500">
                                            <x-phosphor-upload-simple-bold class="w-8 h-8 mx-auto text-gray-400 mb-2"/>
                                            <p>Pilih Gambar Unggulan</p>
                                        </div>
                                    </div>
                                </label>
                                <input type="file" wire:model="featuredImageUpload" id="featured-image-upload" class="sr-only">
                                @error('featuredImageUpload') <span class="text-red-500 text-sm mt-1">{{ $message }}</span> @enderror
                            </div>
                        </div>
                         <div>
                            <x-util.form.label for="description" value="Deskripsi Paket" />
                            <textarea wire:model.defer="description" id="description" rows="6" class="border-gray-300 focus:border-primary-500 focus:ring-primary-500 rounded-xl shadow-sm mt-1 block w-full"></textarea>
                        </div>
                        <div class="flex items-center gap-8">
                             <label for="is_featured" class="flex items-center">
                                <input wire:model="is_featured" id="is_featured" type="checkbox" class="rounded border-gray-300 text-primary-600 shadow-sm focus:ring-primary-600">
                                <span class="ml-2 text-sm text-gray-600">Unggulkan</span>
                            </label>
                            <label for="is_active" class="flex items-center">
                                <input wire:model="is_active" id="is_active" type="checkbox" class="rounded border-gray-300 text-primary-600 shadow-sm focus:ring-primary-600">
                                <span class="ml-2 text-sm text-gray-600">Aktifkan</span>
                            </label>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Step 2: Itinerary --}}
            <div x-show="currentStep === 2">
                <div class="space-y-4">
                    @foreach ($itineraries as $index => $itinerary)
                        <div wire:key="itinerary-{{ $index }}" class="p-4 bg-gray-50 rounded-lg border flex flex-col md:flex-row gap-4 relative">
                            <div class="w-full md:w-20">
                                <x-util.form.label :for="'itinerary-day-'.$index" value="Hari ke-" />
                                <x-util.form.input type="number" wire:model="itineraries.{{ $index }}.day_number" :id="'itinerary-day-'.$index" class="w-full mt-1" />
                            </div>
                            <div class="flex-1">
                                <x-util.form.label :for="'itinerary-title-'.$index" value="Judul Kegiatan" />
                                <x-util.form.input type="text" wire:model="itineraries.{{ $index }}.title" :id="'itinerary-title-'.$index" class="mt-1" placeholder="e.g. Tiba di Madinah & Check-in" />
                                @error('itineraries.'.$index.'.title') <div class="text-red-500 text-xs mt-1">{{ $message }}</div> @enderror
                            </div>
                            <div class="flex-1">
                                <x-util.form.label :for="'itinerary-desc-'.$index" value="Deskripsi Kegiatan" />
                                <x-util.form.input type="text" wire:model="itineraries.{{ $index }}.description" :id="'itinerary-desc-'.$index" class="mt-1" placeholder="e.g. Proses imigrasi, perjalanan ke hotel..." />
                                @error('itineraries.'.$index.'.description') <div class="text-red-500 text-xs mt-1">{{ $message }}</div> @enderror
                            </div>
                            <div class="flex items-end">
                                <button type="button" wire:click="removeItineraryDay({{ $index }})" class="p-2 text-red-500 hover:text-red-700 hover:bg-red-100 rounded-full">
                                    <x-phosphor-trash class="w-5 h-5"/>
                                </button>
                            </div>
                        </div>
                    @endforeach
                    @error('itineraries') <div class="text-red-500 text-sm mt-2">{{ $message }}</div> @enderror
                </div>
                <x-util.button type="button" variant="outline" wire:click="addItineraryDay" class="mt-4">
                    <x-slot:icon><x-phosphor-plus /></x-slot:icon>
                    Tambah Hari
                </x-util.button>
            </div>

            {{-- Step 3: Gallery --}}
            <div x-show="currentStep === 3">
                <div class="space-y-4">
                    @if(!empty($galleries))
                        <p class="text-sm font-medium text-gray-700">Gambar Tersimpan</p>
                        <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 gap-4">
                        @foreach ($galleries as $index => $gallery)
                            <div wire:key="gallery-{{ $gallery['id'] }}" class="relative group">
                                <img src="{{ Storage::url($gallery['image_url']) }}" class="w-full h-32 object-cover rounded-lg">
                                <button type="button" wire:click="removeGalleryItem({{ $index }})" class="absolute top-1 right-1 p-1 bg-red-600 text-white rounded-full opacity-0 group-hover:opacity-100 transition-opacity">
                                    <x-phosphor-x class="w-4 h-4"/>
                                </button>
                            </div>
                        @endforeach
                        </div>
                    @endif
                    
                    <p class="text-sm font-medium text-gray-700 pt-4 border-t border-gray-200">Tambah Gambar Baru</p>
                    @foreach ($galleryUploads as $index => $upload)
                        <div wire:key="new-gallery-{{ $index }}" class="p-4 bg-blue-50 rounded-lg border border-blue-200 flex items-center gap-4">
                            @if ($upload)
                                <img src="{{ $upload->temporaryUrl() }}" class="w-20 h-20 rounded object-cover">
                            @endif
                            <div class="flex-1">
                                <x-util.form.label value="Upload Gambar Baru" />
                                <input type="file" wire:model="galleryUploads.{{ $index }}" class="block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-blue-100 file:text-blue-700 hover:file:bg-blue-200 mt-1">
                                @error('galleryUploads.'.$index) <div class="text-red-500 text-xs mt-1">{{ $message }}</div> @enderror
                            </div>
                             <button type="button" wire:click="removeNewGalleryItem({{ $index }})" class="p-2 text-red-500 hover:text-red-700 hover:bg-red-100 rounded-full">
                                <x-phosphor-trash class="w-5 h-5"/>
                            </button>
                        </div>
                    @endforeach
                </div>
                <x-util.button type="button" variant="outline" wire:click="addGalleryItem" class="mt-4">
                    <x-slot:icon><x-phosphor-plus /></x-slot:icon>
                    Tambah Upload
                </x-util.button>
            </div>
            
            {{-- Stepper Actions --}}
            <div class="mt-8 flex justify-between gap-3 border-t border-gray-200 pt-6">
                <div>
                    <x-util.button type="button" variant="outline" wire:click="previousStep" x-show="currentStep > 1">
                        Sebelumnya
                    </x-util.button>
                </div>
                <div class="flex gap-3">
                    <x-util.button type="button" variant="secondary" wire:click="closeModal">
                        Batal
                    </x-util.button>
                    <x-util.button type="button" variant="primary" wire:click="nextStep" x-show="currentStep < 3">
                        Berikutnya
                    </x-util.button>
                    <x-util.button type="submit" wire:target="save, featuredImageUpload, galleryUploads" x-show="currentStep === 3">
                        {{ $packageId ? 'Simpan Perubahan' : 'Buat Paket' }}
                    </x-util.button>
                </div>
            </div>
        </form>
    </div>
</x-util.modal>