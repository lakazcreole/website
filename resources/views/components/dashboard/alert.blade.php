<div class="alert alert-{{ $type }} alert-dismissible fade show" role="alert">
  {{ $slot }}
  @if(isset($closeable) && $closeable)
    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
      <span aria-hidden="true">&times;</span>
    </button>
  @endif
</div>
