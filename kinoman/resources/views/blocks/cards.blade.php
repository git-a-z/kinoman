<div class="grid main_catalog_section">
    @forelse($data as $item)
        @include('blocks.card', ['item' => $item])
    @empty
    @endforelse
</div>
