    
<div class="loginMain">

    <h1>Register</h1>

    <form action="index.php?ctrl=security&action=register" method="post">
        <label>Username</label>
        <input type="text" name="username" required />
        <br>
        <label>Email</label>
        <input type="text" name="email" required />
        <br>
        <label>Password</label>
        <input type="password" name="password" id="password" required />
        <br>
        <label>Repeat password</label>
        <input type="password" name="passwordCheck" id="passwordCheck" required />
        <br>

        <input class="loginSubmit" type="submit" value="Register" />
    </form>

    <p class="switchLoginForm">Not registered yet ?<a href="index.php?ctrl=security&action=connexionForm">Click here</a></p>


</div>