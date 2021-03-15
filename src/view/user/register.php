<h1><?= htmlspecialchars($naslov) ?></h1>
<form method="post">
    <label>Name</label>
    <input type="text" name="User[user_first]" value="<?=$data['user_first'] ?? ''?>">  
    <?php if (!empty($errors['user_first'])) :?>
        <p class="error"><?= htmlspecialchars($errors['user_first']) ?></p>
    <?php endif;?>
    <br>
        
    <label>Lastname</label>
    <input type="text" name="User[user_last]" value="<?=$data['user_last'] ?? ''?>">  
    <?php if (!empty($errors['user_last'])) :?>
        <p class="error"><?= htmlspecialchars($errors['user_last']) ?></p>
    <?php endif;?>    
    <br>
    
    <label>E-mail</label>
    <input type="text" name="User[user_email]" value="<?=$data['user_email'] ?? ''?>">  
    <?php if (!empty($errors['user_email'])) :?>
        <p class="error"><?= htmlspecialchars($errors['user_email']) ?></p>
    <?php endif;?>       
    <br>
    
    <label>Password</label>
    <input type="password" name="User[password]" value="<?=$data['password'] ?? ''?>">  
    <?php if (!empty($errors['user_pwd'])) :?>
        <p class="error"><?= htmlspecialchars($errors['user_pwd']) ?></p>
    <?php endif;?>  
    <br>
    
    <button>Register</button>
    
</form>