<div>
    <x-panel.card>
        <div class="px-6 py-5 border-b border-gray-100 flex justify-between items-center">
            <div>
                <h3 class="font-serif font-bold text-lg text-gray-900">Artikel & Blog</h3>
                <p class="text-sm text-gray-500">Tulis dan kelola semua konten artikel untuk website.</p>
            </div>
            <div>
                <x-util.button 
                    type="button" 
                    variant="primary"
                    wire:navigate href="{{ route('admin.posts.create') }}"
                >
                    <x-slot:icon>
                        <x-phosphor-plus-bold class="w-4 h-4"/>
                    </x-slot:icon>
                    Tulis Artikel Baru
                </x-util.button>
            </div>
        </div>

        <div class="p-6">
            <x-panel.toolbar>
                <x-slot:search>
                    <div class="relative w-full">
                        <input
                            type="text"
                            wire:model.live.debounce.300ms="search"
                            placeholder="Cari judul artikel..."
                            class="pl-10 pr-4 py-2.5 w-full bg-gray-50 border border-gray-200 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-primary-500 focus:border-transparent transition-all"
                        />
                        <x-phosphor-magnifying-glass class="w-5 h-5 absolute left-3 top-1/2 -translate-y-1/2 text-gray-400" />
                    </div>
                </x-slot:search>

                <x-slot:filters>
                    <select wire:model.live="filterStatus" class="bg-gray-50 border-gray-200 rounded-lg text-sm focus:ring-primary-500 focus:border-primary-500">
                        <option value="">Semua Status</option>
                        <option value="published">Published</option>
                        <option value="draft">Draft</option>
                    </select>
                </x-slot:filters>
            </x-panel.toolbar>

            <x-panel.table :packages="$posts">
                <x-slot:head>
                    <th class="px-6 py-4">Judul</th>
                    <th class="px-6 py-4">Author</th>
                    <th class="px-6 py-4">Status</th>
                    <th class="px-6 py-4">Tanggal Terbit</th>
                    <th class="px-6 py-4 text-center">Aksi</th>
                </x-slot:head>
                <x-slot:body>
                    @forelse ($posts as $post)
                        <tr wire:key="{{ $post->id }}" class="hover:bg-gray-50/80 transition-colors">
                            <td class="px-6 py-4 font-bold text-gray-900">{{ $post->title }}</td>
                            <td class="px-6 py-4 text-gray-600">{{ $post->author->name }}</td>
                            <td class="px-6 py-4">
                                <span class="px-2 py-1 text-xs font-semibold rounded-full {{ $post->status === \App\Enums\PostStatus::PUBLISHED ? 'bg-green-100 text-green-800' : 'bg-gray-100 text-gray-800' }}">
                                    {{ $post->status->value }}
                                </span>
                            </td>
                            <td class="px-6 py-4 text-gray-500">{{ $post->created_at->format('d M Y') }}</td>
                            <td class="px-6 py-4 text-center">
                                <a href="{{ route('admin.posts.edit', $post) }}" wire:navigate class="inline-block text-gray-400 hover:text-primary-600 mx-1" title="Edit Artikel">
                                    <x-phosphor-pencil class="w-5 h-5"/>
                                </a>
                                <button type="button" wire:click="deletePost({{ $post->id }})" wire:confirm="Anda yakin ingin menghapus artikel ini?" class="text-gray-400 hover:text-red-600 mx-1" title="Hapus Artikel">
                                    <x-phosphor-trash class="w-5 h-5"/>
                                </button>
                            </td>
                        </tr>
                    @empty
                         <tr>
                            <td colspan="5" class="px-6 py-12 text-center text-gray-500">
                                <x-phosphor-newspaper class="w-12 h-12 mx-auto text-gray-300"/>
                                <p class="mt-2">Belum ada artikel yang ditulis.</p>
                            </td>
                        </tr>
                    @endforelse
                </x-slot:body>
            </x-panel.table>
        </div>
    </x-panel.card>
</div>
