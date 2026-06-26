<x-admin-layout :title="'Feedback'" :eyebrow="'Rating & komentar user'">

    {{-- Statistik --}}
    <div style="display: grid; grid-template-columns: repeat(3, 1fr); gap: 16px; margin-bottom: 24px;">
        <div class="surface" style="padding: 20px; text-align: center;">
            <p style="color: #6B7280; font-size: 12px; margin: 0 0 6px; font-family: 'JetBrains Mono', monospace; text-transform: uppercase; letter-spacing: 0.08em;">Total Feedback</p>
            <p style="color: #FAFBFC; font-size: 28px; font-weight: 600; margin: 0;">{{ $stats['total'] }}</p>
        </div>
        <div class="surface" style="padding: 20px; text-align: center;">
            <p style="color: #6B7280; font-size: 12px; margin: 0 0 6px; font-family: 'JetBrains Mono', monospace; text-transform: uppercase; letter-spacing: 0.08em;">Rata-rata Rating</p>
            <p style="color: #4FE6AB; font-size: 28px; font-weight: 600; margin: 0;">{{ $stats['average'] }} ★</p>
        </div>
        <div class="surface" style="padding: 20px;">
            <p style="color: #6B7280; font-size: 12px; margin: 0 0 10px; font-family: 'JetBrains Mono', monospace; text-transform: uppercase; letter-spacing: 0.08em;">Distribusi Rating</p>
            @foreach([5,4,3,2,1] as $star)
                <div style="display: flex; align-items: center; gap: 8px; margin-bottom: 4px;">
                    <span style="color: #F5C518; font-size: 12px; width: 20px;">{{ $star }}★</span>
                    <div style="flex: 1; background: #2A323E; border-radius: 4px; height: 6px;">
                        @php $pct = $stats['total'] > 0 ? ($stats['counts'][$star] / $stats['total']) * 100 : 0; @endphp
                        <div style="width: {{ $pct }}%; background: #4FE6AB; height: 6px; border-radius: 4px;"></div>
                    </div>
                    <span style="color: #9CA3AF; font-size: 12px; width: 20px;">{{ $stats['counts'][$star] }}</span>
                </div>
            @endforeach
        </div>
    </div>

    {{-- Tabel Feedback --}}
    <div class="surface" style="padding: 4px 20px 12px; overflow-x: auto;">
        <table class="data-table">
            <thead>
                <tr>
                    <th>User</th>
                    <th>Rating</th>
                    <th>Komentar</th>
                    <th>Tanggal</th>
                </tr>
            </thead>
            <tbody>
                @forelse($feedbacks as $fb)
                    <tr>
                        <td>{{ $fb->session->user->name ?? '-' }}</td>
                        <td>
                            <span style="color: #F5C518;">
                                @for($i = 1; $i <= 5; $i++)
                                    {{ $i <= $fb->rating ? '★' : '☆' }}
                                @endfor
                            </span>
                        </td>
                        <td style="color: #9CA3AF;">{{ $fb->comments ?? '-' }}</td>
                        <td style="color: #9CA3AF; font-size: 12.5px;">{{ $fb->created_at->format('d M Y, H:i') }}</td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="4" style="text-align: center; color: #6B7280; padding: 32px 12px;">
                            Belum ada feedback dari user.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div style="margin-top: 16px;">
        {{ $feedbacks->links() }}
    </div>

</x-admin-layout>