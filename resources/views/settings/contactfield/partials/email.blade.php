<!-- Email -->
<div class="pa3 mb3 br2 bg-white" style="box-shadow: 0 1px 1px #ccc;">
  <div class="header relative mb-2">
    <h6>{{ __('settings.email_type') }}</h6>
    <a href="/settings/contactfield/create?type=email" class="default-btn fw6 pv1 ph3 absolute top-0 right-0">
      {{ __('settings.add_new_email_cta') }}
    </a>
  </div>
  @if (isset($contactFieldValuesGrouped['email']) && $contactFieldValuesGrouped['email']->count() > 0)
    <ul class="list pa0 ma0">
      @foreach($contactFieldValuesGrouped['email'] as $contactFieldValue)
        <li class="relative pa2 br1">
          <div class="table-row">
            <div class="mr-5">
              {{ $contactFieldValue->value }}<span class="light-gray-text"> ({{ $contactFieldValue->defaultLabel->name }})</span>
              
              <!-- Privacy icon -->
              @switch($contactFieldValue->privacy->code)
                @case(\App\Privacy::PUBLIC_PRIVACY)
                  <i class="fas fa-globe-americas privacy-icon light-gray-text ml-1" title="{{ __('settings.public_privacy_desc') }}"></i>
                  @break
                @case(\App\Privacy::FRIENDS_PRIVACY)
                  <i class="fas fa-user-friends privacy-icon light-gray-text ml-1" title="{{ __('settings.friends_privacy_desc') }}"></i>
                  @break
                @default
                  <i class="fas fa-lock privacy-icon light-gray-text ml-1" title="{{ __('settings.only_me_privacy_desc') }}"></i>
              @endswitch
            </div>
            <div class="dropdown more-actions f6">
              <a class="dots" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                <i class="fas fa-ellipsis-h"></i>
              </a>
              <div class="dropdown-menu dropdown-menu-right">
                <a class="dropdown-item f7" href="/settings/contactfield/{{ $contactFieldValue->id }}/edit"><i class="fa fa-edit mr2"></i>{{ __('settings.edit') }}</a>
                <a class="dropdown-item f7" href="#" onclick="if (confirm('{{ __('user.contact_field_delete_confirmation') }}')) { $(this).closest('.table-row').find('.entry-delete-form').submit(); } return false;"><i class="fa fa-trash mr2"></i>{{ __('settings.delete') }}</a>
              </div>
            </div>
            <!-- Delete form -->
            <form method="POST" action="{{ action('ContactFieldsController@destroy', ['contactFieldValue' => $contactFieldValue->id]) }}" class="entry-delete-form">
              @method('DELETE')
              @csrf
            </form>
          </div>
        </li>
      @endforeach
    </ul>
  @else
    <div class="mv2">
      <div class="tc pa2 light-gray-text">
        <i class="fas fa-envelope mr-2"></i>
        {{ __('settings.email_empty_desc') }}
      </div>
    </div>
  @endif
</div>
<!-- End email -->
