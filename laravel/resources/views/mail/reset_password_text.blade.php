Hi {{ ucfirst($expert->firstname_exp) }} {{ strtoupper($expert->name_exp) }},
Your recently requested to reset your password. Click the button below to reset it.
This link is available for {{ $DURATION_TOKEN }} minutes
Reset your password : {{ route('account.reset.token') }}?k={{ $passwordResets->token }}&id_exp={{ $passwordResets->id_exp }}
