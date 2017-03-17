<div>
    <p>
        Dear {{ $user->name}}, thanks for your continued service to the Gospel
        of Christ.  {{ $ticket->organization->name }} needs your help with
         {{ $ticket->subject }}.  This event is scheduled on {{ $ticket->date_start}}
          thru {{ $ticket->date_end }}.  See below for more details.
    </p>
    <p>
        <a href="{{ url('/evite/'.$token.'?r=y') }}">Yes, I will help</a>
    </p>
    <p>
        <a href="{{ url('/evite/'.$token.'?r=n') }}">Sorry, not this time</a>
    </p>
    <p>
        {{ $ticket->description }}
    </p>


</div>