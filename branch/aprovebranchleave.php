<h3>Sidebar</h3>
<a href="managerdashboard.php">Home</a>
<a href="managerleave.php">leave</a>
<a href="managerattendance.php">attendance</a>
<a class="active" href="managerdetails.php">details
    <ul id="sub-menu">
        <li><a href="#">manage employees in this branch</a></li>
    </ul>
</a>

<!-- Include the jQuery library -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<!-- Add the JavaScript code to toggle the sub-menu -->
<script>
$(document).ready(function() {
    $('.active').click(function() {
        $('#sub-menu').toggle();
    });
});
</script>

<!-- Add the CSS code to hide the sub-menu by default -->
<style>
#sub-menu {
    display: none;
}
</style>
