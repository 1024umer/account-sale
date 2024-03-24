
<form method="post" action="https://payeer.com/merchant/" id="payeer_form">
    @csrf
    <input type="hidden" name="m_shop" value="{{ $m_shop }}">
    <input type="hidden" name="m_orderid" value="{{ $m_orderid }}">
    <input type="hidden" name="m_amount" value="{{ $m_amount }}">
    <input type="hidden" name="m_curr" value="{{ $m_curr }}">
    <input type="hidden" name="m_desc" value="{{ $m_desc }}">
    <input type="hidden" name="m_sign" value="{{ $sign }}">
    <input type="submit" name="m_process" value="send" />
</form>

<script defer>
    document.addEventListener("DOMContentLoaded", function(event) {
        var idOfYourForm = "payeer_form";
        document.getElementById(idOfYourForm).submit();
    });
</script>

