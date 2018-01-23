<!DOCTYPE html>
<html lang="en">
<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Star Admin</title>
    <link rel="stylesheet" href="../node_modules/font-awesome/css/font-awesome.min.css" />
    <link rel="stylesheet" href="../node_modules/perfect-scrollbar/dist/css/perfect-scrollbar.min.css" />
    <link rel="stylesheet" href="../node_modules/flag-icon-css/css/flag-icon.min.css" />
    <link rel="stylesheet" href="star/assets/css/style.css" />
    <link rel="shortcut icon" href="star/assets/images/favicon.png" />
</head>
<body>
    <div class="container-scroller">
        <?php require_once './require/_navbar.html'?>
        <div class="container-fluid">
            <div class="row row-offcanvas row-offcanvas-right">
                <?php require_once './require/_sidebar.html'?>
                <div class="content-wrapper">
                    <h2>Add your content here</h2>
                    <p>All the pages in admin/content should be rendered here.</p>
                    <p>To change the sidebar links open and edit require/_sidebar</p>
                </div>
            </div>
            <?php require_once './require/_footer.html'?>
        </div>
    </div>

    <script src="../node_modules/jquery/dist/jquery.min.js"></script>
    <script src="../node_modules/popper.js/dist/umd/popper.min.js"></script>
    <script src="../node_modules/bootstrap/dist/js/bootstrap.min.js"></script>
    <script src="../node_modules/chart.js/dist/Chart.min.js"></script>
    <script src="../node_modules/perfect-scrollbar/dist/js/perfect-scrollbar.jquery.min.js"></script>
    <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyB5NXz9eVnyJOA81wimI8WYE08kW_JMe8g&callback=initMap" async defer></script>
    <script src="star/assets/js/off-canvas.js"></script>
    <script src="star/assets/js/hoverable-collapse.js"></script>
    <script src="star/assets/js/misc.js"></script>
    <script src="star/assets/js/chart.js"></script>
    <script src="star/assets/js/maps.js"></script>

</body>
</html>

