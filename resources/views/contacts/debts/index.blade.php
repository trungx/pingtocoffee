<div class="p-3 mb3">
  <div class="relative">
    <div class="db mb1">
      <div class="dib light-gray-text">
        <div class="fl f5">{{ __('user.debts_heading') }}</div>
      </div>
      <!-- Add cta -->
      <a href="/contact/{{ $user->id }}/debt" class="default-btn fw6 pv1 ph3 absolute top-0 right-0">{{ __('user.debts_add_cta') }}</a>
    </div>

    @if ($debts->count() == 0)
      <!-- Empty state -->
      <div class="tc">
        <div class="f4 mv2">{{ __('user.debts_empty') }}</div>
        <div class="light-gray-text">{{ __('user.debts_whats') }}</div>
      </div>
    @else
      <!-- List debt -->
      <ul class="dt list pa0 ma0 w-100">
        @foreach($debts as $debt)
          <li class="table-row dt-row">
            <div class="pv2 ph3 tl f6 dtc date f7 light-gray-text">{{ $debt->date_time }}</div>

            @if ($debt->in_debt)
              <div class="pv2 ph3 tl f6 dtc debt-nature">{{ __('user.in_debt_yes', ['name' => $user->first_name, 'amount' => floatval($debt->amount), 'currency' => auth()->user()->currency]) }}</div>
            @else
              <div class="pv2 ph3 tl f6 dtc debt-nature">{{ __('user.in_debt_no', ['name' => $user->first_name, 'amount' => floatval($debt->amount), 'currency' => auth()->user()->currency]) }}</div>
            @endif

            <div class="pv2 ph3 tl f6 dtc reason">{{ $debt->reason }}</div>
            <div class="pv2 ph3 tl f6 dtc list-actions">
              <a href="/contact/{{ $user->id }}/debt/{{ $debt->id }}" title="Edit"><i class="fas fa-pencil-alt f7 mr2"></i></a>
              <a href="javascript:void(0);" title="Delete" onclick="if (confirm('{{ __('user.debt_delete_confirmation') }}')) { $(this).closest('.table-row').find('.entry-delete-form').submit(); } return false;">
                <i class="fas fa-trash-alt f7"></i>
              </a>
            </div>
            <form method="POST" action="/contact/{{ $user->username }}/debt/{{ $debt->id }}" class="entry-delete-form hidden">
              @method('DELETE')
              @csrf
            </form>
          </li>
        @endforeach

        <li class="dt-row">
          <div class="pv2 ph3 tl f6 dtc"></div>

          @if ($totalDebt > 0)
            <div class="pv2 ph3 tl f6 dtc b">{{ __('user.in_debt_yes', ['name' => $user->getCompleteName(), 'amount' => $totalDebt, 'currency' => auth()->user()->currency]) }}</div>
          @else
            <div class="pv2 ph3 tl f6 dtc b">{{ __('user.in_debt_no', ['name' => $user->getCompleteName(), 'amount' => substr($totalDebt, 1), 'currency' => auth()->user()->currency]) }}</div>
          @endif

          <div class="pv2 ph3 tl f6 dtc"></div>
          <div class="pv2 ph3 tl f6 dtc"></div>
        </li>
      </ul>
    @endif
  </div>
</div>
