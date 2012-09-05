@if( Auth::check() )
<div id="userBar">
     {{ $username }}
</div>
@endif