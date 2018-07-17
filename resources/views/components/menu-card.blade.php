<div class="shadow-lg relative overflow-hidden">
  @isset($tag)
    <div class="card-tag">
      {{ $tag }}
    </div>
  @endif
  <div class="zoom-wrapper">
    {{ $image }}
  </div>
  <div class="p-4">
    <div class="mb-3">
      <h3 class="text-2xl font-normal text-orange">{{ $title }}</h3>
    </div>
    <div class="text-orange-darker">
      {{ $slot }}
    </div>
  </div>
</div>
