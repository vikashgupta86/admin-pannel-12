<?php

function doubleChar($str) {
    $char_arr = str_split($str);  
    $double_char_str = '';

    foreach ($char_arr as $char) {
        $double_char_str .= $char . $char;
    }

    return $double_char_str;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['inputstr'])) {
    $inpstr = $_POST['inputstr'];
    $output = doubleChar($inpstr);
} else {
    $output = '';
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Double Character</title>
</head>
<body>

<form method="post">
    <input type="text" name="inputstr" placeholder="Enter text" required>
    <button type="submit">Submit</button>
</form>

<?php
if ($output !== '') {
    echo "<h3>Result:</h3>";
    echo "<p>" . htmlspecialchars($output) . "</p>";
}
?>

</body>
</html>
