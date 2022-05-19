<!-- <main class="content"> -->
        <ul>
            <li class="main_catalog">
                
                <div class="grid main_catalog_section">
                    @forelse($cardlist as $item)
                        @include('blocks.card', ['item' => $item])
                    @empty
                    
                    @endforelse
                </div>
            </li>
            
        </ul>
    <!-- </main> -->