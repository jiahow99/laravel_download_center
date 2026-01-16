@php
    $can_download = $entry->status == \Mices\DownloadCenter\Models\DownloadCenter::STATUS_COMPLETED && 
    Storage::disk('public')->exists($entry->path);
@endphp

@if ($can_download)
  <a href="{{ Storage::disk('public')->url($entry->path) }}" download="{{ basename($entry->path) }}" class="btn btn-sm btn-link text-capitalize">
    <i class="la la-download"></i> Download
  </a>
@endif