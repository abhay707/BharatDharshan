@props(['item', 'collection' => 'gallery', 'width' => 800, 'height' => 600, 'class' => '', 'alt' => null])
@php
  $imageUrl = null;
  if (method_exists($item, 'getFirstMediaUrl')) {
      $imageUrl = $item->getFirstMediaUrl($collection) ?: null;
  }
  if (!$imageUrl && isset($item->cover_image) && $item->cover_image) {
      $imageUrl = \Storage::url($item->cover_image);
  }
  if (!$imageUrl) {
      $imageUrl = "https://picsum.photos/seed/{$item->slug}/{$width}/{$height}";
  }
  $altText = $alt ?? $item->name;
@endphp
<img src="{{ $imageUrl }}" alt="{{ $altText }}" class="{{ $class }}" loading="lazy">
