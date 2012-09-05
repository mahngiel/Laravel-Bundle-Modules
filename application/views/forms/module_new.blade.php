@layout('admin/master')

@section('content')
<nav class="admin-subnav">
    <ul>
        <li>{{ HTML::link_to_route('modules', 'Modules') }}</li>
        <li>{{ HTML::link_to_route('module_areas', 'Modules Areas') }}</li>
        <li class="selected">{{ HTML::link_to_route('module_area_new', 'Create Module Area') }}</li>
    </ul>
</nav>

<section id="phdModules" class="subcontent">
    @if( $errors->has() )
      <div class="errors">{{ $errors->first('username', ':message') }}</div>
      <div class="errors">{{ $errors->first('password', ':message') }}</div>
    @endif

    {{ Form::open('admin/modules.areas.new', 'POST') }}
    {{ Form::token() }}

    {{ Form::label('name', 'New Area Name') }}
    {{ Form::text('name', Input::old('name')) }}

    {{ Form::submit('Create', array('class'=>'btn-module')) }}

    {{ Form::close() }}
@endsection