<form method="POST" action="{{ route('ticket-status.update') }}">
    @csrf
    @foreach ($statuses as $status)
        <div>
            <label>{{ $status->label }} ({{ $status->code }})</label>
            <input type="color" name="colors[{{ $status->code }}]" value="{{ $status->color }}">
        </div>
    @endforeach
    <button type="submit">Enregistrer</button>
</form>