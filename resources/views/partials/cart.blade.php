<div class="restaurant-cart">
    <h3 class="mb-0">Your Order</h3>
    <hr>
    <ul class="list-group" style="list-style: none">
        @foreach(\Cart::getContent() as $item)
            <li>
                <form method="POST" action="{{ route('cart.remove', $item->id) }}">
                    @csrf
                    @method('DELETE')
                    <span class="badge badge-dark">{{ $item->quantity }}</span>
                    <p class="d-inline-block">{{$item->name}}</p>
                    <button type="submit" class="close">
                        <span>×</span>
                    </button>
                </form>
            </li>
        @endforeach
    </ul>
    @if(!\Cart::isEmpty())
        <a href="{{ route('checkout') }}" class="btn btn-info btn-block">Checkout</a>
    @else
        <p>Start adding items from the menu to build your order.</p>
    @endif
</div>