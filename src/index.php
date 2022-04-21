<?php require_once "header.php";
if (isset($_SESSION['username']) && $_SESSION['username'] == "admin")
    echo "<form hidden aria-hidden='true' id='loggedIn' value='admin'></form>";
echo <<<_END
<form id="form_example" action="#" name="sort" method="POST">
    <label>Sort by:</label>
    <select name="sort" id='sort' onchange="setSort($(this))">
          <option value="Title ASC">Title: A-Z</option>
          <option value="Title DESC">Title: Z-A</option>
          <option value="Created ASC">Date: ascending</option>
          <option value="Created DESC">Date: descending</option>
    </select>
</form> 
_END;
?>
<div id="dynamic">
    <div class="row" id="append"></div>
</div>
<?php require_once "footer.php"; ?>
