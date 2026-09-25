<div class="bg-white p-6 rounded-xl border-2 mb-6" style="border-color:#16302E; box-shadow:4px 4px 0px 0px #16302E;">
    <h3 class="text-lg font-bold mb-4" style="font-family:'Space Grotesk', sans-serif; color:#16302E;">
        Top 3 Star Performers
    </h3>
    <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
        @php
            // Ambil semua user yang ada nilainya, urutkan, reset index, ambil 3 teratas
            $topThree = $performers->values()->take(3);
        @endphp
        
        @foreach($topThree as $index => $user)
            <div class="p-4 rounded-lg flex items-center gap-4" style="background:#F1F6F5;">
                <div class="w-12 h-12 flex items-center justify-center rounded-full font-bold text-lg text-white"
                     style="background:{{ $index == 0 ? '#F4A261' : ($index == 1 ? '#75B8C0' : '#16302E') }};">
                    #{{ $index + 1 }}
                </div>
                <div>
                    <div class="font-bold text-[#16302E]">{{ $user['name'] }}</div>
                    <div class="text-xs text-[#5B6B68]">{{ $user['group'] }}</div>
                    <div class="text-sm font-semibold" style="color:#75B8C0;">Score: {{ number_format($user['avg_score'], 2) }}</div>
                </div>
            </div>
        @endforeach
    </div>
</div>
