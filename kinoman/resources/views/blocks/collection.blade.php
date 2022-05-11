<div class="grid main_catalog_section">
    @forelse($collection as $item)
        @include('blocks.card', ['item' => $item])
    @empty
    @endforelse
</div>
