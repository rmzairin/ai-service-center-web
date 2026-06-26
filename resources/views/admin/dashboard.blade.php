<x-admin-layout :title="'Dashboard'" :eyebrow="'Ringkasan sistem'">

    {{-- Kartu Statistik --}}
    <div style="display: grid; grid-template-columns: repeat(4, 1fr); gap: 16px; margin-bottom: 28px;">

        <div class="surface" style="padding: 20px;">
            <p style="color: #6B7280; font-size: 11px; margin: 0 0 8px; font-family: 'JetBrains Mono', monospace; text-transform: uppercase; letter-spacing: 0.08em;">Total Sesi Chat</p>
            <p style="color: #FAFBFC; font-size: 30px; font-weight: 600; margin: 0 0 4px;">{{ $summary['total_sessions'] }}</p>
            <p style="color: #4FE6AB; font-size: 12px; margin: 0;">+{{ $summary['today_sessions'] }} hari ini</p>
        </div>

        <div class="surface" style="padding: 20px;">
            <p style="color: #6B7280; font-size: 11px; margin: 0 0 8px; font-family: 'JetBrains Mono', monospace; text-transform: uppercase; letter-spacing: 0.08em;">Total Pesan</p>
            <p style="color: #FAFBFC; font-size: 30px; font-weight: 600; margin: 0 0 4px;">{{ $summary['total_messages'] }}</p>
            <p style="color: #9CA3AF; font-size: 12px; margin: 0;">dari semua sesi</p>
        </div>

        <div class="surface" style="padding: 20px;">
            <p style="color: #6B7280; font-size: 11px; margin: 0 0 8px; font-family: 'JetBrains Mono', monospace; text-transform: uppercase; letter-spacing: 0.08em;">Rata-rata Rating</p>
            <p style="color: #F5C518; font-size: 30px; font-weight: 600; margin: 0 0 4px;">{{ $summary['avg_rating'] }} ★</p>
            <p style="color: #9CA3AF; font-size: 12px; margin: 0;">dari {{ $summary['total_feedbacks'] }} feedback</p>
        </div>

        <div class="surface" style="padding: 20px;">
            <p style="color: #6B7280; font-size: 11px; margin: 0 0 8px; font-family: 'JetBrains Mono', monospace; text-transform: uppercase; letter-spacing: 0.08em;">Knowledge Aktif</p>
            <p style="color: #FAFBFC; font-size: 30px; font-weight: 600; margin: 0 0 4px;">{{ $summary['total_knowledge'] }}</p>
            <p style="color: #9CA3AF; font-size: 12px; margin: 0;">{{ $summary['total_users'] }} user terdaftar</p>
        </div>

    </div>

    <div style="display: grid; grid-template-columns: 2fr 1fr; gap: 16px; margin-bottom: 28px;">

        {{-- Grafik Chat per Hari --}}
        <div class="surface" style="padding: 24px;">
            <p style="color: #9CA3AF; font-size: 11px; margin: 0 0 4px; font-family: 'JetBrains Mono', monospace; text-transform: uppercase; letter-spacing: 0.08em;">Chat per hari</p>
            <p style="color: #FAFBFC; font-size: 15px; font-weight: 600; margin: 0 0 20px;">7 Hari Terakhir</p>

            <div style="display: flex; align-items: flex-end; gap: 8px; height: 120px;">
                @php
                    $chatTotals = array_column($chatPerDay, 'total');
                    $maxChat = count($chatTotals) > 0 ? max(max($chatTotals), 1) : 1;
                @endphp
                @foreach($chatPerDay as $day)
                    @php $height = max(($day['total'] / $maxChat) * 100, 4); @endphp
                    <div style="flex: 1; display: flex; flex-direction: column; align-items: center; gap: 6px;">
                        <span style="color: #4FE6AB; font-size: 10px;">{{ $day['total'] > 0 ? $day['total'] : '' }}</span>
                        <div style="width: 100%; height: {{ $height }}%; background: {{ $day['total'] > 0 ? '#3DDC9C' : '#2A323E' }}; border-radius: 4px 4px 0 0; min-height: 4px;"></div>
                        <span style="color: #6B7280; font-size: 10px; white-space: nowrap;">{{ $day['date'] }}</span>
                    </div>
                @endforeach
            </div>
        </div>

        {{-- Distribusi Rating --}}
        <div class="surface" style="padding: 24px;">
            <p style="color: #9CA3AF; font-size: 11px; margin: 0 0 4px; font-family: 'JetBrains Mono', monospace; text-transform: uppercase; letter-spacing: 0.08em;">Distribusi rating</p>
            <p style="color: #FAFBFC; font-size: 15px; font-weight: 600; margin: 0 0 20px;">Feedback User</p>

            @php
                $ratingTotals = array_column($ratings, 'total');
                $maxRating = count($ratingTotals) > 0 ? max(max($ratingTotals), 1) : 1;
            @endphp
            @foreach(array_reverse($ratings) as $r)
                <div style="display: flex; align-items: center; gap: 10px; margin-bottom: 10px;">
                    <span style="color: #F5C518; font-size: 12px; width: 24px; text-align: right;">{{ $r['star'] }}★</span>
                    <div style="flex: 1; background: #2A323E; border-radius: 4px; height: 8px;">
                        @php $pct = ($r['total'] / $maxRating) * 100; @endphp
                        <div style="width: {{ $pct }}%; background: #F5C518; height: 8px; border-radius: 4px; transition: width 0.3s;"></div>
                    </div>
                    <span style="color: #9CA3AF; font-size: 12px; width: 20px;">{{ $r['total'] }}</span>
                </div>
            @endforeach
        </div>

    </div>

    <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 16px;">

        {{-- Source Chat --}}
        <div class="surface" style="padding: 24px;">
            <p style="color: #9CA3AF; font-size: 11px; margin: 0 0 4px; font-family: 'JetBrains Mono', monospace; text-transform: uppercase; letter-spacing: 0.08em;">Sumber chat</p>
            <p style="color: #FAFBFC; font-size: 15px; font-weight: 600; margin: 0 0 20px;">Platform</p>

            @forelse($chatBySource as $src)
                <div style="display: flex; justify-content: space-between; align-items: center; padding: 10px 0; border-bottom: 1px solid #2A323E;">
                    <span style="color: #D7DAE0; font-size: 13.5px; text-transform: capitalize;">{{ $src['source'] }}</span>
                    <span style="color: #4FE6AB; font-size: 13.5px; font-weight: 600;">{{ $src['total'] }}</span>
                </div>
            @empty
                <p style="color: #6B7280; font-size: 13px;">Belum ada data.</p>
            @endforelse
        </div>

        {{-- Feedback Terbaru --}}
        <div class="surface" style="padding: 24px;">
            <p style="color: #9CA3AF; font-size: 11px; margin: 0 0 4px; font-family: 'JetBrains Mono', monospace; text-transform: uppercase; letter-spacing: 0.08em;">Feedback terbaru</p>
            <p style="color: #FAFBFC; font-size: 15px; font-weight: 600; margin: 0 0 20px;">5 Terbaru</p>

            @forelse($recentFeedbacks as $fb)
                <div style="padding: 10px 0; border-bottom: 1px solid #2A323E;">
                    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 4px;">
                        <span style="color: #D7DAE0; font-size: 13px; font-weight: 500;">
                            {{ $fb->session->user->name ?? 'User' }}
                        </span>
                        <span style="color: #F5C518; font-size: 13px;">
                            @for($i = 1; $i <= 5; $i++)
                                {{ $i <= $fb->rating ? '★' : '☆' }}
                            @endfor
                        </span>
                    </div>
                    @if($fb->comments)
                        <p style="color: #6B7280; font-size: 12px; margin: 0;">{{ Str::limit($fb->comments, 50) }}</p>
                    @endif
                </div>
            @empty
                <p style="color: #6B7280; font-size: 13px;">Belum ada feedback.</p>
            @endforelse
        </div>

    </div>

</x-admin-layout>