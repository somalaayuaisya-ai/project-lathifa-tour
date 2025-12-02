<div wire:poll.30s="refreshStats">
    <div class="mb-8">
        <h2 class="text-2xl font-serif font-bold text-gray-900">Assalamualaikum, Admin! 👋</h2>
        <p class="text-gray-500 text-sm mt-1">Berikut adalah ringkasan aktivitas travel Lathifa Tour hari ini.</p>
    </div>

    {{-- Stats Cards --}}
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
        <x-panel.stat-card 
            title="Total Inquiries" 
            :value="$stats['total_inquiries'] ?? 0"
            icon="whatsapp-logo" 
            icon-style="fill" 
            icon-color-class="bg-primary-50 text-primary-600"
        />
        <x-panel.stat-card 
            title="Inquiries Baru" 
            :value="$stats['new_inquiries'] ?? 0"
            icon="warning-circle" 
            icon-style="fill" 
            icon-color-class="bg-red-50 text-red-500"
        />
        <x-panel.stat-card 
            title="Paket Aktif" 
            :value="$stats['active_packages'] ?? 0"
            icon="airplane-tilt" 
            icon-style="fill" 
            icon-color-class="bg-gold-50 text-gold-600"
        />
        <x-panel.stat-card 
            title="Total Jamaah" 
            :value="$stats['total_users'] ?? 0"
            icon="users-three" 
            icon-style="fill" 
            icon-color-class="bg-blue-50 text-blue-600"
        />
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        {{-- Chart --}}
        <div class="lg:col-span-2">
            <x-panel.card>
                <div class="px-6 py-5 border-b border-gray-100 flex flex-col sm:flex-row sm:items-center justify-between gap-4">
                    <div>
                        <h3 class="font-serif font-bold text-lg text-gray-900">Tren Inquiries Masuk</h3>
                        <p class="text-sm text-gray-500">Grafik calon jamaah yang menghubungi via web.</p>
                    </div>
                    <div>
                        <select wire:model.live="chartFilter" class="bg-gray-50 border-gray-200 rounded-lg text-sm focus:ring-primary-500 focus:border-primary-500">
                            <option value="7d">7 Hari Terakhir</option>
                            <option value="30d">30 Hari Terakhir</option>
                            <option value="1m">Bulan Ini</option>
                        </select>
                    </div>
                </div>
                <div class="p-4">
                    <x-panel.chart :chartData="$inquiryChartData" />
                </div>
            </x-panel.card>
        </div>

        {{-- Recent Inquiries List --}}
        <div class="lg:col-span-1">
             <x-panel.card>
                <div class="px-6 py-5 border-b border-gray-100">
                    <h3 class="font-serif font-bold text-lg text-gray-900">Inquiries Perlu Follow-Up</h3>
                    <p class="text-sm text-gray-500">5 inquiry terbaru dengan status "New".</p>
                </div>
                <div class="divide-y divide-gray-100">
                    @forelse ($recentInquiries as $inquiry)
                        <div class="p-4 flex items-center gap-4 hover:bg-gray-50/80 transition-colors">
                            <div class="w-10 h-10 bg-blue-50 rounded-full flex items-center justify-center text-blue-600 shrink-0">
                                <x-phosphor-user-bold class="w-5 h-5"/>
                            </div>
                            <div class="flex-1 min-w-0">
                                <p class="font-semibold text-sm text-gray-800 truncate">{{ $inquiry->guest_name ?? $inquiry->user->name }}</p>
                                <p class="text-xs text-gray-500 truncate" title="{{ $inquiry->package->title }}">
                                    Tertarik: {{ Str::limit($inquiry->package->title, 25) }}
                                </p>
                            </div>
                            <a href="#" class="text-gray-400 hover:text-primary-600" title="Lihat Detail">
                                <x-phosphor-arrow-right-bold class="w-5 h-5"/>
                            </a>
                        </div>
                    @empty
                        <div class="p-6 text-center text-gray-500">
                            <x-phosphor-check-circle-bold class="w-8 h-8 mx-auto mb-2 text-green-500"/>
                            <p class="text-sm">Kerja bagus! Tidak ada inquiry yang perlu di-follow up.</p>
                        </div>
                    @endforelse
                </div>
            </x-panel.card>
        </div>
    </div>
</div>
