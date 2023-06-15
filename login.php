<!DOCTYPE html>
<html>
<head>
    <title>Login</title>
    <style>
   .container {
    width: 80%;
    margin: 0 auto;
    overflow: hidden;
    text-align: center;
}

form {
    margin-top: 2rem;
    background-color: #fff;
    padding: 2rem;
    border-radius: 5px;
    box-shadow: 0 2px 3px rgba(0,0,0,0.1);
    border: 1px solid #ccc;
}

form label {
    display: block;
    margin-bottom: 0.5rem;
    font-weight: bold;
}

form input[type="email"],
form input[type="password"] {
    width: 100%;
    padding: 0.5rem;
    margin-bottom: 1rem;
    box-sizing: border-box;
    border-radius: 5px;
    border: 1px solid #ccc;
}

form input[type="submit"] {
    background-color: #333;
    color: #fff;
    border: none;
    padding: 0.7rem 1.5rem;
    cursor:pointer;
    border-radius: 5px;
}

form input[type="submit"]:hover {
    background-color:#555
}

    </style>
</head>
<body>
    <div class="login-box">
  <h2>Login</h2>
  <form>
    <div class="user-box">
      <input type="text" name="" required="">
      <label>Username</label>
    </div>
    <div class="user-box">
      <input type="password" name="" required="">
      <label>Password</label>
    </div>
    <a href="#">
      <span></span>
      <span></span>
      <span></span>
      <span></span>
      Submit
    </a>
  </form>
</div>
</body>
</html>
