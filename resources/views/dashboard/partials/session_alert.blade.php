@if(session('success'))
  @component('dashboard.components.alert', ['type' => 'success'])
    {{ session('success') }}
  @endcomponent
@endif
