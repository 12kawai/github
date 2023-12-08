<!DOCTYPE html>
<html>
<head>
    <title>家計簿</title>
</head>
<body>
    <h1>家計簿</h1>
    <form action="process.php" method="post">
        <label for="expense">支出:</label>
        <input type="text" name="expense" id="expense" required>
        <label for="description">説明:</label>
        <input type="text" name="description" id="description">
        <input type="submit" value="記録する">
    </form>
</body>
</html>
