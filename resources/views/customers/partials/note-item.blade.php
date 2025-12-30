<div class="timeline-item" data-note-id="{{ $note->id }}">
    <div class="d-flex justify-content-between align-items-start mb-2">
        @php
            $noteTypeEmojis = [
                'note' => '📝',
                'call' => '📞',
                'meeting' => '👥',
                'email' => '📧',
                'sms' => '💬',
            ];
            $emoji = $noteTypeEmojis[$note->note_type] ?? '📝';
        @endphp
        <span class="badge badge-modern bg-light text-dark border">
            {{ $emoji }} {{ $note->note_type_label }}
        </span>
        <small class="text-muted">
            {{ $note->created_at->diffForHumans() }}
        </small>
    </div>
    <p class="mb-2 text-dark">{{ $note->note }}</p>
    
    @if($note->next_action_date)
        <div class="mb-2">
            <span class="badge bg-warning text-dark">
                <i class="bi bi-calendar-event me-1"></i>
                Sonraki işlem: {{ $note->next_action_date->format('d.m.Y') }}
            </span>
        </div>
    @endif
    
    <small class="text-muted">
        <i class="bi bi-person-circle me-1"></i>
        <strong>{{ $note->user->name }}</strong>
    </small>
</div>