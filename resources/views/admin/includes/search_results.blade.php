@if (count($items) > 0)
    @foreach ($items as $item)
        <a class="item" href="{{ route('showRestaurant', $item->id) }}">
            <h2 class="title">{{ $item->name }} {{ $type == 'branch' ? '( ' . $item->restaurant->name . ' )' : '' }}
            </h2>
            <div class="address">
                <span class="badge badge-secondary">{{ $item->name_barcode }}</span>
                {{ isset($item->country->id) ? $item->country->name : '' }}
                {{ isset($item->city->id) ? ' , ' . $item->city->name : '' }}
            </div>
            <div class="status">
                @php
                    if ($type == 'restaurant') {
                        $itemStatus = $item->getRealStatus();
                    }
                @endphp
                @if (isset($itemStatus) and !empty($itemStatus))
                    @if (in_array($itemStatus, ['active', 'tentative']))
                        <span
                            class="badge badge-success">{{ trans('dashboard._restaurant_status.' . $itemStatus) }}</span>
                    @elseif (in_array($itemStatus, ['tentative_finished', 'finished']))
                        <span
                            class="badge badge-danger">{{ trans('dashboard._restaurant_status.' . $itemStatus) }}</span>
                    @elseif (in_array($itemStatus, ['less_30_day']))
                        <span class="badge badge-info">{{ trans('dashboard._restaurant_status.' . $itemStatus) }}</span>
                    @elseif (in_array($itemStatus, ['archived', 'inActive', 'inComplete']))
                        <span
                            class="badge badge-warning">{{ trans('dashboard._restaurant_status.' . $itemStatus) }}</span>
                    @else
                        {{-- <span class="badge badge-warning">{{ $itemStatus }}</span> --}}
                    @endif
                @endif
            </div>
        </a>
    @endforeach
@else
    <p class="text-center mt-3">{{ trans('dashboard.no_results') }}</p>
@endif
