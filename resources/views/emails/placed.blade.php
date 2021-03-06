@component('mail::message')
# Order Received

Thank you {{ auth()->user()->name }} for your order.

**Order ID:** {{ $order->id }}<br>
**Order Total:** ${{ $order->billing_total }}<br>

**Items Ordered:**<br>
@foreach ($order->menu_items as $menu)
* {{ $menu->name }} <br>
Price: ${{ $menu->price }} <br>
Quantity: {{ $menu->pivot->quantity }} <br><br>
@endforeach

You can get further details about your order by logging into our website.
@component('mail::button', ['url' => config('app.url'), 'color' => 'green'])
Go to Website
@endcomponent

Regards,<br/>
Kevin Malone
@endcomponent
