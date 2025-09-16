@if (flash()->message)

<!-- <i class="bi bi-star"></i> -->
<div class="alert alert-light-{{ flash()->class ?? 'info'}} color-{{ flash()->class ?? 'info'}}">{{ flash()->message }}</div>

@endif
