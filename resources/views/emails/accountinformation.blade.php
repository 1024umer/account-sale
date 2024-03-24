@if (isset($emailData) && is_array($emailData))
    @foreach ($emailData as $account)
        <p>Username: {{ $account['Username'] ?? '' }}</p>
        <p>Password: {{ $account['Password'] ?? '' }}</p>
        <p>Email: {{ $account['Email'] ?? '' }}</p>
        <p>Email Password: {{ $account['EmailPassword'] ?? '' }}</p>
        <p>2Fa: {{ is_array($account) ? $account['2Fa'] ?? '' : $account }}</p>
        <p>Followers: {{ is_array($account) ? $account['Followers'] ?? '' : '' }}</p>
        <hr>
    @endforeach
@else
    <p>Username: {{ $emailData['Username'] ?? '' }}</p>
    <p>Password: {{ $emailData['Password'] ?? '' }}</p>
    <p>Email: {{ $emailData['Email'] ?? '' }}</p>
    <p>Email Password: {{ $emailData['EmailPassword'] ?? '' }}</p>
    <p>2Fa: {{ $emailData['2Fa'] ?? '' }}</p>
    <p>Followers: {{ $emailData['Followers'] ?? '' }}</p>
@endif
