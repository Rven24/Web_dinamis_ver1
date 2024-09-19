<?php
include 'includes/config.php';
$sql = "SELECT content FROM pages WHERE title = 'About'";
$result = $conn->query($sql);
if ($result->num_rows > 0) {
$row = $result->fetch_assoc();
echo $row['content'];
} else {
echo "Content not found.";
}
?>