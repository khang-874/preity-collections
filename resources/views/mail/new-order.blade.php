<p>New order from {{$customer -> firstName}} {{$customer -> lastName}} at: {{$order -> created_at}}</p>
<p>Checking the customer's order: {{ url('/admin/customers/' . $customer -> id . '/edit')}}</p>