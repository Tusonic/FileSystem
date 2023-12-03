<?php

$message = "";
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $oldPassword = $_POST['oldPassword'];
    $newPassword = $_POST['newPassword'];
    $confirmPassword = $_POST['confirmPassword'];

    if ($newPassword == $confirmPassword) {
        $password = new password();
        $message = $password->ChangePassword($userId, $oldPassword, $newPassword);
    } else {
        $message = "Błednie wpisane hasła";
       
    }
}


?>


<form method="post">
    <div class="card-body">
        <div class="form-group">
            <label for="oldPassword">Stare hasło</label>
            <input type="password" class="form-control" name="oldPassword" required>
        </div>
        <div class="form-group">
            <label for="newPassword">Nowe hasło</label>
            <input type="password" class="form-control" name="newPassword" required>
        </div>
        <div class="form-group">
            <label for="confirmPassword">Potwierdź nowe hasło</label>
            <input type="password" class="form-control" name="confirmPassword" required>
        </div>
                 
           <?php if ($message): ?>
           <div class="alert alert-info alert-dismissible">
              <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
              <h5><i class="icon fas fa-info"></i> Informacja</h5>
              <?php echo $message; ?>
           </div>
           <?php endif; ?>
        

    <div class="card-footer">
        <button type="submit" class="btn btn-primary">Zastosuj</button>
    </div>
 </form>