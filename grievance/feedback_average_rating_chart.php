<?php

/// user satifaction
$data['satisfaction'] = 0;
if ($fdate != '' && $tdate != '') {
    $sql = "select sum(rating_no) as count from rating_mst where DATE(ts) BETWEEN '$fdate' AND '$tdate'";
} else {
    // more than 3 stars users
    $sql = "select sum(rating_no) as count from rating_mst";
}
//echo $sql;
$rs = mysqli_query($conn, $sql);
$row = mysqli_fetch_assoc($rs);
$sum_ratings = $row['count'];

if ($fdate != '' && $tdate != '') {
    $sql = "select COUNT(grievance_id) as count from rating_mst where DATE(ts) BETWEEN '$fdate' AND '$tdate'";
} else {
    // all users
    $sql = "select COUNT(grievance_id) as count from rating_mst";
}
//echo $sql;
$rs = mysqli_query($conn, $sql);
$row = mysqli_fetch_assoc($rs);
$total_ratings = $row['count'];


// satisaction

$data['average_rating'] = round($sum_ratings / $total_ratings);

$avg_rating_percent = round($data['average_rating']);


?>
<style>
    @keyframes html-progress {
        to {
            --progress-value: 0;
        }
    }



    @keyframes css-progress {
        to {
            --progress-value: 0;
        }
    }



    @keyframes js-progress {
        to {
            --progress-value: <?php echo $avg_rating_percent; ?>;
        }
    }





    .progress-bar-container {
        padding: 22px 10px !important;
        display: flex;
        align-items: center;
    }

    .progress-bar {
        width: 140px;
        height: 140px;
        border-radius: 50%;
        margin: 0 auto;
        /* to center the percentage value */
        /*
        display: flex;
        justify-content: center;
        align-items: center;
*/
    }



    .progress-bar::before {
        counter-reset: percentage var(--progress-value);
        content: counter(percentage) '%';
    }




    .rating {
        background:
            radial-gradient(closest-side, white 79%, transparent 80% 100%, white 0),
            conic-gradient(green calc(var(--progress-value) * 1%), lightgray 0);
        animation: js-progress 2s 1 forwards;
        transition: 0.3s;
    }

    .rating:hover {
        background:
            radial-gradient(closest-side, white 79%, transparent 80% 100%, white 0),
            conic-gradient(green calc(var(--progress-value) * 1%), lightgray 0);
        animation: js-progress 2s 1 forwards;
        box-shadow: 0px 0px 10px rgba(0, 0, 0, 1);
        transition: 0.3s;
    }



    .rating::before {
        animation: js-progress 2s 1 forwards;
    }


    progress {
        visibility: hidden;
        width: 0;
        height: 0;
    }
</style>


<div class="col-md-3 mb-4">
    <div class="card">
        <div class="card-body">
            <div class="card-title mb-3">
                <h6 style="color:#008000"><b>Average Rating</b> </h6>
            </div>
            <div class="progress-bar-container">

                <div class="progress-bar rating" style="margin-bottom:15px">
                    <progress id="js" min="2" max="100" value="<?php echo $avg_rating_percent; ?>"></progress>
                </div>
            </div>
        </div>
    </div>
</div>


<!--
<script>
    $(function() {
  $('.chart').easyPieChart({
    scaleColor: false,
    lineWidth: 10,
    lineCap: 'round',
    barColor: '#333',
    size: 200,
    animate: 500
  });
});

</script>
-->