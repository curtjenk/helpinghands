<div class="header-2">
    @php
        $orgs = Auth::user()->allowed_organizations();
        $cnt = $orgs->count();
        //for some views, show only a specific organization
        if (isset($specific)) {
            $orgs = $orgs->where('id', $specific);
        }
    @endphp
    @if($cnt==1)
        {{$orgs[0]->name}} {{$orgs[0]->city}}
    @else
    <select id="selected_org_id" name="selected_org_id">
    @foreach ($orgs as $org)
        <option {{ Auth::user()->organization_id==$org->id ? 'selected' : '' }} value="{{ $org->id }}"> {{$org->name}} {{$org->city}}</option>
    @endforeach
    @endif
    </select>
</div>
