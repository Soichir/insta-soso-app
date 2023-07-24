<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
</head>
<body>

    <h1>Welcome to Kredo Insta App</h1>
    <hr>
    <p>Hello! {{$name}}</p>
    <p>Thank you for registering!</p>
    <p>In Kredo Insta App, you can post any pictures you like.</p>
    <p>You can comment to the other's posts and like the posts as well.</p>
    <p>Follow many friends and share your joy!</p>
    <img src="{{ asset('./images/ss.insta.png') }}" alt="">
    <p>To start, please access the website <a href="{{$app_url}}">here</a>.</p>
    <p>Thank you!</p>

</body>
</html>