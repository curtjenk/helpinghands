<div>
    <h3>Dear {{ $user->name}},</h3>
    <p>
        Thanks for your continued service to the Gospel
        of Christ.  {{ $ticket->organization->name }} needs your help with
         {{ $ticket->subject }}.  This event is scheduled on {{ $ticket->date_start}}
          thru {{ $ticket->date_end }}.  See below for more details.
    </p>
    <h4>Please respond by clicking the appropriate link</h4>
    <p>
        <a href="{{ url('/api/evite/s/'.$ticket->id."/".$user->id."/".$token) }}">Yes, I will help</a>
    </p>
    <p>
        <a href="{{ url('/api/evite/o/'.$ticket->id."/".$user->id."/".$token) }}">Sorry, not this time</a>
    </p>
    <h4><u>Event Description</u></h4>
    <p>
        {{ $ticket->description }}
    </p>


</div>