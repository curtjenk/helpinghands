<div>
    <h3>Dear {{ $user->name}},</h3>
    <p>
        Great!  We can certainly use your help with <b> {{ $ticket->subject }}</b>.
        This event is scheduled on {{ $ticket->date_start}} thru {{ $ticket->date_end }}.
    </p>
    <p>
        Please add the date to your calendar.
    </p>
    <p>
        Thanks again for your commitment!
    </p>
    <h4><u>Event Description</u></h4>
    <p>
        {{ $ticket->description }}
    </p>


</div>