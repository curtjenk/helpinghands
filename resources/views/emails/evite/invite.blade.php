<div>
    <p>
        {{ $user->name}}, thanks for your continued service!</p>
    </p>
    <p>
        <a href="{{ url('/evite/'.$user->id.'/'.$ticket->id.'?r=y') }}">Yes, I'm going!</a>
    </p>
    <p>
        <a href="{{ url('/evite/'.$user->id.'/'.$ticket->id.'?r=n') }}">Sorry</a>
    </p>
    <p>
        {{ $ticket->description }}
    </p>


</div>