<div class="btn-group">
    <button class="btn btn-sm btn-outline-warning" data-toggle="dropdown" aria-expanded="false"
            title="{{ trans('form.order.change_status') }}">
        <i class="fa fa-recycle" aria-hidden="true"></i>
    </button>
    <ul class="dropdown-menu dropdown-menu-status" data-table-id="@if(isset($lowerModelName)) #{{ $lowerModelName }}-table @endif">
        <li @if($q->status === \App\Models\Order::STATUS_NOTIFICATION_RECRUITMENT || $q->status !== \App\Models\Order::STATUS_WAITING_LIST_INTERVIEW) hidden @endif>
            <a href="javascript:void(0);" class="js-change-order-status"
               data-order-status-name="{{ trans('form.order.notification_recruitment') }}"
               data-url-change-status="{{ route('admin.orders.changeStatus', [$q->id, \App\Models\Order::STATUS_NOTIFICATION_RECRUITMENT]) }}"><i
                    class="fa fa-recycle"></i> @lang('form.order.notification_recruitment')</a>
            <hr>
        </li>
        <li @if($q->status === \App\Models\Order::STATUS_WAITING_LIST_INTERVIEW || ($q->status !== \App\Models\Order::STATUS_NOTIFICATION_RECRUITMENT && $q->status !== \App\Models\Order::STATUS_PASS)) hidden @endif>
            <a href="javascript:void(0);" class="js-change-order-status"
               data-order-status-name="{{ trans('form.order.waiting_list_interview') }}"
               data-url-change-status="{{ route('admin.orders.changeStatus', [$q->id, \App\Models\Order::STATUS_WAITING_LIST_INTERVIEW]) }}"><i
                    class="fa fa-recycle"></i> @lang('form.order.waiting_list_interview')</a>
            <hr>
        </li>
        <li @if($q->status === \App\Models\Order::STATUS_PASS || ($q->status !== \App\Models\Order::STATUS_WAITING_LIST_INTERVIEW && $q->status !== \App\Models\Order::STATUS_LEARNING_MAKE_FILE)) hidden @endif>
            <a href="javascript:void(0);" class="js-change-order-status"
               data-order-status-name="{{ trans('form.order.passed') }}"
               data-url-change-status="{{ route('admin.orders.changeStatus', [$q->id, \App\Models\Order::STATUS_PASS]) }}"><i
                    class="fa fa-recycle"></i> @lang('form.order.passed')</a>
            <hr>
        </li>
        <li @if($q->status === \App\Models\Order::STATUS_LEARNING_MAKE_FILE || ($q->status !== \App\Models\Order::STATUS_PASS && $q->status !== \App\Models\Order::STATUS_VISA)) hidden @endif>
            <a href="javascript:void(0);" class="js-change-order-status"
               data-order-status-name="{{ trans('form.order.learning_make_file') }}"
               data-url-change-status="{{ route('admin.orders.changeStatus', [$q->id, \App\Models\Order::STATUS_LEARNING_MAKE_FILE]) }}"><i
                    class="fa fa-recycle"></i> @lang('form.order.learning_make_file')</a>
            <hr>
        </li>
        <li @if($q->status === \App\Models\Order::STATUS_VISA || ($q->status !== \App\Models\Order::STATUS_LEARNING_MAKE_FILE && $q->status !== \App\Models\Order::STATUS_EXIT_OF_COUNTRY)) hidden @endif>
            <a href="javascript:void(0);" class="js-change-order-status"
               data-order-status-name="{{ trans('form.order.visa') }}"
               data-url-change-status="{{ route('admin.orders.changeStatus', [$q->id, \App\Models\Order::STATUS_VISA]) }}"><i
                    class="fa fa-recycle"></i> @lang('form.order.visa')</a>
            <hr>
        </li>
        <li @if($q->status === \App\Models\Order::STATUS_EXIT_OF_COUNTRY || ($q->status !== \App\Models\Order::STATUS_VISA && $q->status !== \App\Models\Order::STATUS_WORKING)) hidden @endif>
            <a href="javascript:void(0);" class="js-change-order-status"
               data-order-status-name="{{ trans('form.order.exiting_of_country') }}"
               data-url-change-status="{{ route('admin.orders.changeStatus', [$q->id, \App\Models\Order::STATUS_EXIT_OF_COUNTRY]) }}"><i
                    class="fa fa-recycle"></i> @lang('form.order.exiting_of_country')</a>
            <hr>
        </li>
        <li @if($q->status === \App\Models\Order::STATUS_WORKING || ($q->status !== \App\Models\Order::STATUS_EXIT_OF_COUNTRY && $q->status !== \App\Models\Order::STATUS_RETURN_VN)) hidden @endif>
            <a href="javascript:void(0);" class="js-change-order-status"
               data-order-status-name="{{ trans('form.order.working') }}"
               data-url-change-status="{{ route('admin.orders.changeStatus', [$q->id, \App\Models\Order::STATUS_WORKING]) }}"><i
                    class="fa fa-recycle"></i> @lang('form.order.working')</a>
            <hr>
        </li>
        <li @if($q->status === \App\Models\Order::STATUS_RETURN_VN || $q->status !== \App\Models\Order::STATUS_WORKING) hidden @endif>
            <a href="javascript:void(0);" class="js-change-order-status"
               data-order-status-name="{{ trans('form.order.return_vn') }}"
               data-url-change-status="{{ route('admin.orders.changeStatus', [$q->id, \App\Models\Order::STATUS_RETURN_VN]) }}"><i
                    class="fa fa-recycle"></i> @lang('form.order.return_vn')</a></li>
    </ul>
</div>
