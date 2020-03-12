Hi {{ ucfirst($expert->firstname_exp) }} {{ strtoupper($expert->name_exp) }},
Your recently requested to reset your password. Click the button below to reset it.
Reset your password : http://annotateme.fr/account/reset/token?k={{ $passwordResets->token }}&id_exp={{ $passwordResets->id_exp }}
