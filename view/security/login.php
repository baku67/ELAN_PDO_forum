    
<div class="loginMain">

    <h1>Log in</h1>

    <form action="index.php?ctrl=security&action=login" method="post">

        <label>Email</label>
        <input type="text" name="email" required>
        <br>
        <label>Password</label>
        <input type="password" name="password" required>
        <br>
        <input class="loginSubmit" type="submit" value="Login">

    </form>
    
    <p class="switchLoginForm">Already have an account ? <a href="index.php?ctrl=security&action=subscribeForm">Click here</a></p>

</div>