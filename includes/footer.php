 </div>
    <div id="main" class="container mx-auto mt-8">
        <!-- Your main content here -->
    </div>
    <div id="footer" class="bg-gray-800 text-white py-4 text-center">
        Copyright 2007, Widget Corp
    </div>

    <?php
    if (isset($connection)) {
        mysqli_close($connection);
    }
    ?>
</body>

</html>