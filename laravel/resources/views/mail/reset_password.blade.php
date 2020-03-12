<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <style>
        * {
            box-sizing: border-box;
            font-family: sans-serif;
        }

        .flex {
            display: flex;
        }

        .flex-center {
            justify-content: center;
        }

        .btn {
            color: #FFF;
            background-color: #007bff;
            text-decoration: none;
            font-weight: 400;
            text-align: center;
            user-select: none;
            border: 1px solid transparent;
            padding: .375rem .75rem;
            font-size: 1rem;
            line-height: 1.5;
            border-radius: .25rem;
        }
    </style>
</head>

<body>
    <h2>Hi {{ ucfirst($expert->firstname_exp) }} {{ strtoupper($expert->name_exp) }},</h2>
    <div>
        <p>Your recently requested to reset your password. Click the button below to reset it.</p>
        <div class="flex flex-center">
            <a href="http://annotateme.fr/account/reset/token?k={{ $passwordResets->token }}&id_exp={{ $passwordResets->id_exp }}" class="btn">Reset your password</a>
        </div>
    </div>

</body>

</html>