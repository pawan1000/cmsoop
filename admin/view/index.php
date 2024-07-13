<?php 
    include('C:\xampp\htdocs\cmsoop\admin\view\includes\admin_header.php');
    include('C:\xampp\htdocs\cmsoop\admin\view\includes\admin_navigation.php');
?>
<div id="page-wrapper">
        <div class="container-fluid">
            <!-- Page Heading -->
            <div class="row">
                <div class="col-lg-12">
                    <h1 class="page-header">
                        Welcome to Admin
                        <?php 
                            echo $_SESSION['username'];
                        ?>
                    </h1>
                    <form action="/cmsoop/admin/view/index.php" method="post"> 
                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="start date">Start Date</label>
                                    <input type="date" required class="form-control" name="start_date">
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="End date">End Date</label>
                                    <input type="date" required class="form-control" name="end_date">
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                <label for="button"></label>
                                <input type="submit" class="btn btn-success form-control" name="submit" value="Apply">
                                </div>
                            </div>
                        </div>
                    <div class="row">
                        <!-- Posts -->
                        <div class="col-lg-3 col-md-6">
                            <div class="panel panel-primary">
                                <div class="panel-heading">
                                    <div class="row">
                                        <div class="col-xs-3">
                                            <i class="fa fa-file-text fa-5x"></i>
                                        </div>
                                        <div class="col-xs-9 text-right">
                                            <div class='huge'><?php echo  Functions::get_postscount('my_data')?></div>
                                            <div>Posts</div>
                                        </div>
                                    </div>
                                </div>
                                <a href="/cmsoop/view/author_posts.php?author=<?php echo Functions::get_fullname(); ?>">
                                    <div class="panel-footer">
                                        <span class="pull-left">View Details</span>
                                        <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
                                        <div class="clearfix"></div>
                                    </div>
                                </a>
                            </div>
                        </div>
                        <!-- Comments -->
                        <div class="col-lg-3 col-md-6">
                            <div class="panel panel-green">
                                <div class="panel-heading">
                                    <div class="row">
                                        <div class="col-xs-3">
                                            <i class="fa fa-comments fa-5x"></i>
                                        </div>
                                        <div class="col-xs-9 text-right">
                                        <div class='huge'><?php echo  Functions::get_commentscount('my_data')?></div>
                                            <div>Comments</div>
                                        </div>
                                    </div>
                                </div>
                                <a href="/cmsoop/view/author_posts.php?author=<?php echo Functions::get_fullname(); ?>">
                                    <div class="panel-footer">
                                        <span class="pull-left">View Details</span>
                                        <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
                                        <div class="clearfix"></div>
                                    </div>
                                </a>
                            </div>
                        </div>
                        <!-- Categories -->
                        <div class="col-lg-3 col-md-6">
                            <div class="panel panel-red">
                                <div class="panel-heading">
                                    <div class="row">
                                        <div class="col-xs-3">
                                            <i class="fa fa-list fa-5x"></i>
                                        </div>
                                        <div class="col-xs-9 text-right">
                                        <div class='huge'><?php echo  Functions::get_categoriescount('my_data')?></div>
                                            <div>Categories</div>
                                        </div>
                                    </div>
                                </div>
                                <a href="/cmsoop/view/author_posts.php?author=<?php echo Functions::get_fullname(); ?>">
                                    <div class="panel-footer">
                                        <span class="pull-left">View Details</span>
                                        <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
                                        <div class="clearfix"></div>
                                    </div>
                                </a>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                            <script type="text/javascript">
                                google.charts.load("current", {packages:['corechart']});
                                google.charts.setOnLoadCallback(drawChart);
                                function drawChart() 
                                {
                                    var data = google.visualization.arrayToDataTable([
                                    ["Element", "Count", { role: "style" } ],
                                    <?php
                                        $element_text=['Active Posts','Comments','Categories'];
                                        $element_count=[Functions::get_postscount('my_data'),Functions::get_commentscount('my_data'),Functions::get_categoriescount('my_data')];       
                                        for ($i=0;$i<sizeof($element_text);$i++)
                                        {
                                            echo '["' . $element_text[$i] . '", ' . $element_count[$i] . ', "#b87333"],';
                                        }
                                    ?>
                                    ]);
                                    var view = new google.visualization.DataView(data);
                                    view.setColumns([0, 1,
                                                    { calc: "stringify",
                                                        sourceColumn: 1,
                                                        type: "string",
                                                        role: "annotation" },
                                                    2]);

                                    var options = 
                                    {
                                        title: "Dashboard",
                                        width: 600,
                                        height: 400,
                                        bar: {groupWidth: "95%"},
                                        legend: { position: "none" },
                                    };
                                    var chart = new google.visualization.ColumnChart(document.getElementById("columnchart_values"));
                                    chart.draw(view, options);
                                }
                            </script>
                            <div id="columnchart_values" style="width: 900px; height: 300px;"></div>
                            <br><br><br><br><br>
                    </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

<?php include 'includes/admin_footer.php';?>
