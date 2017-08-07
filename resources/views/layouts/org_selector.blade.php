<div class="header-2" data-url="{{Request::url()}}">
    @php
        $orgs = Auth::user()->allowed_organizations();
        if(Request::session()->has('orgid')) {
            $org_id = Request::session()->get('orgid');
        } else {
            $org_id = Auth::user()->id;
        }
        //for some views, show only a specific organization
        // if (isset($specific)) {
        //     $orgs = $orgs->where('id', $specific);
        // }
        // $cnt = $orgs->count();
    @endphp
    {{-- @if(isset($specific))
        {{$orgs[0]->name}} {{$orgs[0]->city}}
    @else --}}
    <select id="selected_org_id" name="selected_org_id">
    @foreach ($orgs as $org)
        <option {{ $org_id==$org->id ? 'selected' : '' }} value="{{ $org->id }}"> {{$org->name}} {{$org->city}}</option>
    @endforeach
    {{-- @endif --}}
    </select>
</div>
