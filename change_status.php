<!-- Formularz do akceptacji -->

<form action="update_status.php" method="post" style="display: inline;" onsubmit="return confirm('Czy na pewno chcesz ZAKCEPTOWAĆ <?php echo $row['id']; ?>?');">
    <input type="hidden" name="report_id" value="<?php echo htmlspecialchars($row['id']); ?>">
    <input type="hidden" name="new_status" value="1">
    <button type="submit" class="btn btn-success" <?php echo ($row['status'] == '1' || $row['status'] == '2') ? 'disabled' : ''; ?>>
        Akceptuj
    </button>
</form>

<!-- Formularz do odrzucenia -->

<form action="update_status.php" method="post" style="display: inline;" onsubmit="return confirm('Czy na pewno chcesz ODRZUCIĆ <?php echo $row['id']; ?>?');">
    <input type="hidden" name="report_id" value="<?php echo htmlspecialchars($row['id']); ?>">
    <input type="hidden" name="new_status" value="2">
    <button type="submit" class="btn btn-danger" <?php echo ($row['status'] == '1' || $row['status'] == '2') ? 'disabled' : ''; ?>>
        Odrzuc
    </button>
</form>