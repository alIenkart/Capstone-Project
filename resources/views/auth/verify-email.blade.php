<h1>Verify Your Email</h1>
<p>
    A verification link has been sent to your email address.
</p>
<form method="POST" action="{{ route('verification.send') }}">
    @csrf
    <button type="submit">Resend Verification Email</button>
</form>