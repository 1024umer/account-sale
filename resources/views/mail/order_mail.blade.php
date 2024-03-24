@component('mail::message')
# Order Received!

Hello {{ $name }},

We want to inform you that we have received your order. Below, you'll find the details of your delivery:
<hr><br>
@php
    $ordermode1 = $orderMode;
@endphp
@if($product_type == 'GamingAccountcart')
@foreach($channels as $channel)
    @if($ordermode1 == 'Easy Mode Accepted')
        <?php
        // Split the string into an array of labels and values
        list($labels, $values) = explode('=', $channel['value1']);
        $labelArray = preg_split("/[:,:\/]/", $labels);
        $valueArray = preg_split("/[:,:\/]/", $values);

        // Output the formatted values
        foreach ($labelArray as $index => $label) {
            echo $label . ': ' . $valueArray[$index] . '<br>';
        }
        ?>
    @else
        <strong>Details 1:</strong> {{ $channel['value1'] }}<br>
        {{-- <strong>Details 2:</strong> {{ $channel['value2'] }}<br>
        <strong>Details 3:</strong> {{ $channel['value3'] }}<br>
        <strong>Details 4:</strong> {{ $channel['value4'] }}<br>
        <strong>Details 5:</strong> {{ $channel['value5'] }}<br>
        <strong>Details 6:</strong> {{ $channel['value6'] }}<br>
        <strong>Details 7:</strong> {{ $channel['value7'] }}<br>
        <strong>Details 8:</strong> {{ $channel['value8'] }}<br> --}}
    @endif

@endforeach
<br><hr><br>
@endif

@if($product_type == 'GamingAccount')
@foreach($channels as $ch)
@if($ordermode1 == 'Easy Mode Accepted')
<?php
// Split the string into an array of labels and values
list($labels, $values) = explode('=', $ch->value1);
$labelArray = preg_split("/[:,:\/]/", $labels);
$valueArray = preg_split("/[:,:\/]/", $values);

// Output the formatted values
foreach ($labelArray as $index => $label) {
    echo $label . ': ' . $valueArray[$index] . '<br>';
}
?>
@else
**Details 1:** {{ $ch->value1 }}
{{-- **Details 2:** {{ $ch->value2 }}
**Details 3:** {{ $ch->value3 }}
**Details 4:** {{ $ch->value4 }}
**Details 5:** {{ $ch->value5 }}
**Details 6:** {{ $ch->value6 }}
**Details 7:** {{ $ch->value7 }}
**Details 8:** {{ $ch->value8 }} --}}
<br>
@endif
@endforeach
@else
{{-- @foreach($channels as $ch)
**Key:** {{ $ch->key }}
**Validity:** {{ $ch->days }} days
<br>
@endforeach --}}
@endif

If you have any questions or concerns, feel free to reach out to our support team. Thank you for choosing Devil Software.

Best regards,
Devil Software Team
@endcomponent
