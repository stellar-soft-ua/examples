<div class="row">
    <div class="col-md-10">
        <strong>{{ $title }}</strong>
        <div>{{ $description }}</div>
    </div>
    <div class="col-md-2 text-right">
    <a class="underline font-weight-semi-bold color-black" target="_blank" download href="{{ $file_url ?: get_attachment_url($file) }}">{{ $file_title ?: 'PDF' }}</a>
    </div>
</div>
