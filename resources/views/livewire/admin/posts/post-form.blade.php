<form wire:submit.prevent="save">
    {{-- Header --}}
    <div class="flex justify-between items-start mb-8">
        <div>
            <h2 class="text-2xl font-serif font-bold text-gray-900">
                {{ $post->exists ? 'Edit Artikel' : 'Tulis Artikel Baru' }}
            </h2>
            <p class="text-gray-500 text-sm mt-1">Isi detail artikel, atur status, dan publikasikan.</p>
        </div>
        <div class="flex gap-3">
            <x-util.button type="button" variant="outline" wire:navigate href="{{ route('admin.posts.index') }}">
                Batal
            </x-util.button>
            <x-util.button type="submit" wire:target="save, thumbnailUpload">
                Simpan Artikel
            </x-util.button>
        </div>
    </div>

    {{-- Form Layout --}}
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        {{-- Main Content --}}
        <div class="lg:col-span-2 space-y-6">
            <x-panel.card>
                <div class="p-6">
                    <div>
                        <x-util.form.label for="title" value="Judul Artikel" />
                        <x-util.form.input wire:model.lazy="title" id="title" type="text"
                            class="mt-1 text-lg font-semibold !p-4" placeholder="e.g. Tips Umroh Saat Musim Panas" />
                        @error('title') <span class="text-red-500 text-sm mt-1">{{ $message }}</span> @enderror
                    </div>

                    <div class="mt-6">
                        <x-util.form.label for="content" value="Isi Konten" />
                        <div class="mt-1">
                            <x-forms.trix-editor wire:model="content" />
                        </div>
                        @error('content') <span class="text-red-500 text-sm mt-1">{{ $message }}</span> @enderror
                    </div>
                </div>
            </x-panel.card>
        </div>

        {{-- Sidebar --}}
        <div class="lg:col-span-1 space-y-6">
            <x-panel.card>
                <div class="px-6 py-5 border-b border-gray-100">
                    <h3 class="font-semibold text-gray-900">Pengaturan</h3>
                </div>
                <div class="p-6 space-y-4">
                    {{-- Status --}}
                    <div>
                        <x-util.form.label for="status" value="Status" />
                        <select wire:model="status" id="status"
                            class="mt-1 block w-full bg-gray-50 border-gray-200 rounded-lg text-sm focus:ring-primary-500 focus:border-primary-500 h-12 px-4">
                            @foreach(\App\Enums\PostStatus::cases() as $status)
                            <option value="{{ $status->value }}">{{ ucfirst($status->value) }}</option>
                            @endforeach
                        </select>
                        @error('status') <span class="text-red-500 text-sm mt-1">{{ $message }}</span> @enderror
                    </div>

                    {{-- Thumbnail --}}
                    <div>
                        <x-util.form.label value="Thumbnail" />
                        <div class="mt-1">
                            @if ($thumbnailUpload)
                            <img src="{{ $thumbnailUpload->temporaryUrl() }}" alt="Thumbnail Preview"
                                class="rounded-lg object-cover w-full h-48 mb-4">
                            @elseif($post->thumbnail)
                            <img src="{{ Storage::url($post->thumbnail) }}" alt="Current Thumbnail"
                                class="rounded-lg object-cover w-full h-48 mb-4">
                            @endif

                            <label for="thumbnail-upload" class="cursor-pointer">
                                <div
                                    class="p-4 text-center border-2 border-dashed border-gray-200 rounded-lg hover:bg-gray-50">
                                    <div wire:loading wire:target="thumbnailUpload" class="text-sm text-gray-500">
                                        <p>Uploading...</p>
                                    </div>
                                    <div wire:loading.remove wire:target="thumbnailUpload"
                                        class="text-sm text-gray-500">
                                        <x-phosphor-upload-simple-bold class="w-8 h-8 mx-auto text-gray-400 mb-2" />
                                        <p>Klik untuk memilih gambar</p>
                                        <p class="text-xs">PNG, JPG, WEBP max. 2MB</p>
                                    </div>
                                </div>
                            </label>
                            <input type="file" wire:model="thumbnailUpload" id="thumbnail-upload" class="sr-only">
                        </div>
                        @error('thumbnailUpload') <span class="text-red-500 text-sm mt-1">{{ $message }}</span>
                        @enderror
                    </div>
                </div>
            </x-panel.card>
        </div>
    </div>
</form>
