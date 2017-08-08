<div class="header-2" data-url="{{Request::url()}}">
    &nbsp;
    @php
        //for some views, show only a specific organization
        if (isset($specific)) {
            $orgs = App\Organization::where('id', $specific)->first();
        } else {
            $orgs = Auth::user()->allowed_organizations();
            if(Request::session()->has('orgid')) {
                $org_id = Request::session()->get('orgid');
            } else {
                $org_id = Auth::user()->id;
            }
        }
        // $cnt = $orgs->count();
    @endphp
    @if(isset($specific))
        {{ $orgs->name }}
    @else
    <select id="selected_org_id" name="selected_org_id">
    @foreach ($orgs as $org)
        <option {{ $org_id==$org->id ? 'selected' : '' }} value="{{ $org->id }}"> {{$org->name}} {{$org->city}}</option>
    @endforeach
    @endif
    </select>
</div>
