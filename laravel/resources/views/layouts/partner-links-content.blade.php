<table class="w-100 table-bordered count-links" data-next-page="{{ $statLinks['nextPage'] }}" data-count-links="{{ count($statLinks['links']) }}" data-standart-count-links="{{ $standartLinks }}">
    <tbody>
    @foreach($statLinks['links'] as $key => $sLink)
        @if($sLink['count'])
            <tr>
                <th class="text-center">Посилання</th>
                <th class="text-center">Продано за весь час</th>
                <th class="text-center">Сума</td>
                <th class="text-center">Нараховано</th>
            </tr>
            <tr>
                <td rowspan="3">
                    <span class="ms-2 fw-bold">{{ $sLink['name'] }}:</span>
                    <div  class="ms-2 mt-2 me-2 alert alert-primary alert-link d-flex justify-content-between" role="alert">
                        <span class="stat-link">{{ $sLink['link'] }}</span>
                        <i class="fas fa-copy copy mt-1"></i>
                    </div >
                </td>
                <td data-stat-value="{{ $sLink['name'] }}" data-stat-link="{{ $sLink['link'] }}" class="text-center">
                    {{ $sLink['count'] }}зам. <i class="fas fa-eye mt-1 watch show-order-icon"></i>
                </td>
                <td class="text-center">
                    {{ $sLink['all_price'] }}грн.
                </td>
                <td class="text-center">
                    {{ $sLink['payments'] }}грн.
                </td>
            </tr>
            <tr>
                <th class="text-center">Останні продажі</th>
                <th class="text-center">Сума</th>
                <th class="text-center">Нараховано</th>
            </tr>
            <tr>
                <td data-stat-value="{{ $sLink['name'] }}" data-stat-link="{{ $sLink['link'] }}" class="text-center">
                    {{ $sLink['paid_count'] }}зам. <i class="fas fa-eye mt-1 watch show-order-icon-last"></i>
                </td>
                <td class="text-center">
                    {{ $sLink['paid_all_price'] }}грн.
                </td>
                <td class="text-center">
                    {{ $sLink['paid_payments'] }}грн.
                </td>
            </tr>
        @endif
    @endforeach
    </tbody>
</table>
