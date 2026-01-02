<ul class="nav nav-pills animation-nav nav-justified mb-3" role="tablist">
    <li class="nav-item waves-effect waves-light">
        <a class="nav-link @if (request()->routeIs('order.pending')) {{ 'active' }} @endif"
            href="{{ route('order.pending') }}" role="tab">
            Pending Order <span class="badge bg-danger rounded-circle"></span>
        </a>
    </li>
    <li class="nav-item waves-effect waves-light">
        <a class="nav-link @if (request()->routeIs('order.dispatched')) {{ 'active' }} @endif"
            href="{{ route('order.dispatched') }}" role="tab">
            Dispatched Order <span class="badge bg-danger rounded-circle"></span>
        </a>
    </li>
    <li class="nav-item waves-effect waves-light">
        <a class="nav-link @if (request()->routeIs('order.cancel')) {{ 'active' }} @endif"
            href="{{ route('order.cancel') }}" role="tab">
            Cancel Order<span class="badge bg-danger rounded-circle"></span>
        </a>
    </li>

</ul>
