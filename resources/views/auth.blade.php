<!DOCTYPE html>
<html>

<head>
    <title>Slide Navbar</title>
    <link rel="stylesheet" type="text/css" href="css/auth.css">
    <link href="https://fonts.googleapis.com/css2?family=Jost:wght@500&display=swap" rel="stylesheet">
</head>

<body>
    <div class="main">
        <input type="checkbox" id="chk" aria-hidden="true">
        <div class="signup">
            <form action="{{ route('register') }}" method="POST">
                @csrf
                <label for="chk" aria-hidden="true">Sign up</label>
                <input type="text" name="username" placeholder="User name" required="">
                <input type="text" name="name" placeholder="Name" required="">
                <input type="email" name="email" placeholder="Email" required="">
                <input type="password" name="password" placeholder="Password" required="">
                <button type="submit">Sign up</button>
            </form>
        </div>
        <div class="login">
            <form action="{{ route('actionlogin') }}" method="POST">
                @csrf
                <label for="chk" aria-hidden="true">Login</label>
                <input type="username" name="username" placeholder="Username" required="">
                <input type="password" name="password" placeholder="Password" required="">
                <button type="submit">Login</button>
            </form>
        </div>
    </div>
</body>

</html>