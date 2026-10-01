<a class="cdd_{{ $user->unique_id }} {{ $hid_me }}" id="{{ $user->unique_id }}" href="{{ route('chats.show', ['user_id' => $user->unique_id]) }}">
    <div class="content">
        <img src="{{ asset('php/images/' . $user->img) }}" alt="">
        <div class="details cdsd_{{ $user->unique_id }}">
            <span>{{ $user->name }} {{ $user->lname }}</span>
            <p>{{ $you }}{{ $messageText }}</p>
        </div>
    </div>
    <div class="status-dot {{ $offline }}">
        <i class="fas fa-circle"></i>
    </div>
</a>
